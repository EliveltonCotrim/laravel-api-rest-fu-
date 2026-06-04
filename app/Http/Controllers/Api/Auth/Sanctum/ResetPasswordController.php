<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth\Sanctum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\Sanctum\ResetPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

final class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $record = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

            if (!$record) {
                return response()->json(['message' => 'Nenhuma solicitação de redefinição encontrada para este email.'], 404);
            }

            if (!hash_equals($record->token, $request->token)) {
                return response()->json(['message' => 'Token inválido ou expirado.'], 400);
            }

            $expiresAt = Carbon::parse($record->created_at)->addMinutes(60);

            if (now()->greaterThan($expiresAt)) {
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
                return response()->json(['message' => 'Token expirado. Solicite uma nova redefinição de senha.'], 400);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['message' => 'Usuário não encontrado.'], 404);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            $user->tokens()->delete();

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return response()->json([
                'message' => 'Senha redefinida com sucesso.',
            ], 200);

        } catch (\Throwable $th) {
            Log::error('ResetPasswordController', [
                'email' => $request->email,
                'error' => $th->getMessage(),
            ]);

            return response()->json(['message' => 'Erro ao redefinir senha.'], 500);
        }
    }
}
