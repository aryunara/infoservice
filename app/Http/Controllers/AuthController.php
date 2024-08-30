<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Jobs\SendTextJob;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $validated = $request->validated();

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (Auth::attempt($credentials)) {
            return redirect('leads');
        }

        return redirect()->back()->withErrors([
            'email' => 'Incorrect login information entered.',
        ]);
    }

    public function registration()
    {
        return view('auth.register');
    }

    public function postRegistration(RegistrationRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated) {
                $user = User::create([
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'email_verification_token' => Str::random(32),
                ]);

                SendTextJob::dispatch($user['id'])->onQueue('sendText');
            }, 2);

            return redirect("register-board")->withSuccess('Регистрация прошла успешно.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect("register-board")->with('Во время регистрации возникла ошибка на сервере.');
        }
    }

    public function getBoard()
    {
        return view('auth.register_board');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
}
