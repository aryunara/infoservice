<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function customLogin(LoginRequest $request)
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

    public function customRegistration(RegistrationRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        return redirect("register-board")->withSuccess('You have registered.');
    }

    public function getBoard()
    {
        return view('auth.register_board');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
