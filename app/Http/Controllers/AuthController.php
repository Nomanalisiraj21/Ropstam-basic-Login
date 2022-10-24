<?php

namespace App\Http\Controllers;

use App\Events\SendUserRegisteredMail;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;


class AuthController extends Controller
{
    use ApiResponser;
    protected $authservice;

    public function __construct(AuthService $authservice)
    {
        $this->authservice = $authservice;
    }

    public function register(RegisterUserRequest $request)
    {
        $registerUser = $this->authservice->Register($request);
        event(new SendUserRegisteredMail($registerUser));
        return $this->success([
            'message' => "User Register Successfully"
        ]);
    }

    public function login(LoginUserRequest $request)
    {
        if ($this->authservice->login($request)) {
            return $this->success([
                'token' => auth()->user()->createToken('API Token')->plainTextToken
            ], 200);
        }
        return $this->error('Credentials not match', 401);;
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
