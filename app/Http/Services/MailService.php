<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendConfirmationLetter(int $userId): void
    {
        $user = User::find($userId);
        $data = [
            'name' => $user->username,
            'verification_link' => route('verify.email', ['token' => $user->email_verification_token])
        ];

        Mail::send('confirmation', $data, function($message) use ($user) {
            $message->to("$user->email", "$user->username")->subject
            ("Вы были успешно зарегистрированы на InfoserviceTest.");
            $message->from(getenv('MAIL_FROM_ADDRESS'),getenv('MAIL_FROM_NAME'));
        });
    }

}
