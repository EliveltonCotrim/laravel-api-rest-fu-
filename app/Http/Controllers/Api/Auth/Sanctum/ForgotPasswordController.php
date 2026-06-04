<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth\Sanctum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\Sanctum\ForgotPasswordRequest;
use App\Jobs\SendResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

final class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['message' => 'Não encontramos uma conta com este email.'], 404);
            }

            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                ['email' => $user->email, 'token' => $token, 'created_at' => now()],
            );

            SendResetPasswordEmail::dispatch($user, $token);

            return response()->json([
                'message' => 'Enviamos um link de redefinição de senha para o seu email.',
            ], 200);

        } catch (\Throwable $th) {
            Log::error('ForgotPasswordController', [
                'email' => $request->email,
                'error' => $th->getMessage(),
            ]);

            return response()->json(['message' => 'Erro ao solicitar redefinição de senha.'], 500);
        }
    }
}
