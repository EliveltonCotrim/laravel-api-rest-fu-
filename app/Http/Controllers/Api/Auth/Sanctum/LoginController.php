<?php

namespace App\Http\Controllers\Api\Auth\Sanctum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\Sanctum\loginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(loginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }

            $permissions = $user->getAllPermissions()->pluck('name')->toArray();

            // Gerar o token
            $token = $user->createToken('api-token', $permissions, now()->addMinutes(3))->plainTextToken;
            
            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'permissions' => $permissions
            ], 200);

        } catch (\Throwable $th) {
            Log::error($th);

            return response()->json(['message' => 'Erro ao fazer login'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout realizado com sucesso'], 200);
        } catch (\Throwable $th) {
            Log::error($th);

            return response()->json(['message' => 'Erro ao fazer logout'], 500);
        }
    }
}
