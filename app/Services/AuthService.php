<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    use ApiResponser;

    public function Register($request)
    {
        $random_string= Str::random(8);
        $hash_random_string = Hash::make($random_string);
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($hash_random_string),
            'email' => $request->email
        ]);
        $user["password"]=$random_string;
        return $user;
    }

    public function login($request)
    {
        if (Auth::attempt(["email"=>$request->email,"password"=>$request->password])) {
            return true;
        }
    }
}
