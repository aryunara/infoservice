<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordChangeRequest;
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

    public function getBoard()
    {
        return view('profile_board');
    }

}
