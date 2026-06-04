<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f5;
            color: #18181b;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #18181b;
            padding: 32px 40px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .body {
            padding: 40px;
        }
        .body p {
            font-size: 16px;
            line-height: 1.6;
            margin: 0 0 16px;
            color: #3f3f46;
        }
        .button-container {
            text-align: center;
            margin: 32px 0;
        }
        .button {
            display: inline-block;
            background-color: #18181b;
            color: #ffffff;
            text-decoration: none;
            padding: 14px 36px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
        }
        .button:hover {
            background-color: #27272a;
        }
        .footer {
            padding: 24px 40px;
            border-top: 1px solid #e4e4e7;
            text-align: center;
        }
        .footer p {
            font-size: 13px;
            color: #a1a1aa;
            margin: 4px 0;
        }
        .warning {
            background-color: #fef3c7;
            border-radius: 8px;
            padding: 16px;
            font-size: 14px;
            color: #92400e;
            margin: 24px 0;
        }
        .token-text {
            background-color: #f4f4f5;
            border-radius: 8px;
            padding: 12px 16px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            text-align: center;
            word-break: break-all;
            letter-spacing: 2px;
            margin: 16px 0;
            color: #18181b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Redefinição de Senha</h1>
        </div>

        <div class="body">
            <p>Olá, <strong>{{ $user->name }}</strong>!</p>

            <p>Recebemos uma solicitação de redefinição de senha para sua conta. Clique no botão abaixo para criar uma nova senha:</p>

            <div class="button-container">
                <a href="{{ $url }}" class="button" target="_blank" rel="noopener noreferrer">
                    Redefinir Senha
                </a>
            </div>

            <p>Se o botão não funcionar, copie e cole o link abaixo no seu navegador:</p>

            <div class="token-text">{{ $url }}</div>

            <p>Ou utilize o token diretamente:</p>

            <div class="token-text">{{ $token }}</div>

            <div class="warning">
                <strong>Atenção:</strong> Este link expira em <strong>{{ $expiresIn }} minutos</strong>.
                Se você não solicitou a redefinição de senha, ignore este email.
            </div>

            <p style="margin-top: 24px;">Atenciosamente,<br>{{ config('app.name') }}</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
            <p>Este email foi enviado automaticamente, por favor não responda.</p>
        </div>
    </div>
</body>
</html>
