<?php

namespace App\Services;

use App\Models\User;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register($request) : User {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->role()->assigne();
        return $user;

    }

    public function sendActivationEmail() {

    }
}
