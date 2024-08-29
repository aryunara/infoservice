<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\SendRequest;
use App\Jobs\SendTextJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getProfile()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function update(PasswordChangeRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();

        $oldPassword = $user->password;

        if (!$oldPassword) {
            return redirect('profile-board')->with('Старый пароль не найден в базе данных.');
        }

        if (!empty($validated['old-psw'])) {
            if (!Hash::check($validated['old-psw'], $oldPassword)) {
                return redirect()->back()->withErrors([
                    'old-psw' => 'Old password is incorrect.',
                ]);
            }
            $user->password = Hash::make($validated['new-psw']);
            $user->save();
        }

        return redirect('profile-board')->withSuccess('Пароль обновлен успешно.');
    }

    public function sendConfirmationLetter()
    {
        SendTextJob::dispatch(Auth::id())->onQueue('sendText');

        return redirect("confirmation-board")->withSuccess('Письмо было отправлено успешно.');
    }

    public function verifyEmail(string $token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();

            return redirect('profile')->withSuccess('Email successfully verified!');
        }

        return redirect('register')->with('Invalid verification link.');
    }

    public function getProfileBoard()
    {
        return view('profile_board');
    }

    public function getConfirmationBoard()
    {
        return view('confirmation_board');
    }

}
