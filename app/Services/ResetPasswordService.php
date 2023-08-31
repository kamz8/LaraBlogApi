<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordService
{
    protected string $resetPasswordTable;

    public function __construct()
    {
        $this->resetPasswordTable = config('auth.passwords.users.table');
    }

    public function emailExist($email): User
    {
        return User::where('email', $email)->first();
    }
    public function createToken($email) : string
    {
        $oldToken = DB::table($this->resetPasswordTable)->where('email', $email)->first();

        if ($oldToken) {
            return $oldToken->token;
        }

        $token = Hash::make(Str::random(60));
        $this->saveToken($token, $email);
        return $token;
    }

    public function saveToken($token, $email): void
    {
        DB::table($this->resetPasswordTable)->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);
    }

    public function updatePassword($email, $newPassword): void
    {
        $user = User::where('email', $email)->first();
        $user->update([
            'password' => bcrypt($newPassword)
        ]);
    }

    public function deleteToken($email): void
    {
        DB::table($this->resetPasswordTable)->where('email', $email)->delete();
    }

    public function validateEmailAndToken($email, $token): bool
    {
        return DB::table($this->resetPasswordTable)
            ->where('email', $email)
            ->where('token', $token)
            ->exists();
    }
}