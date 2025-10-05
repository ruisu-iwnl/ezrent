<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TenantCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tenantName;
    public $email;
    public $password;
    public $loginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($tenantName, $email, $password)
    {
        $this->tenantName = $tenantName;
        $this->email = $email;
        $this->password = $password;

        // Generate a one-time token stored server-side for direct login
        $token = Str::random(40);
        Cache::put('direct_login_' . $token, [
            'email' => $email,
        ], now()->addMinutes(30));

        // Temporary signed URL containing only the token
        $this->loginUrl = URL::temporarySignedRoute('direct-login', now()->addMinutes(30), [
            'token' => $token,
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to EZRent - Your Login Credentials',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.tenant-credentials',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
