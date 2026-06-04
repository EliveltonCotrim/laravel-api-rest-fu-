<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly string $token,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Redefinição de Senha'),
            to: [new Address($this->user->email, $this->user->name)],
        );
    }

    public function content(): Content
    {
        $url = config('app.frontend_url') . '/reset-password?token=' . $this->token . '&email=' . urlencode($this->user->email);

        return new Content(
            view: 'emails.reset-password',
            with: [
                'user' => $this->user,
                'token' => $this->token,
                'url' => $url,
                'expiresIn' => 60,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
