<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\BadCredentialsResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\AuthService;
use http\Env\Request;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = Auth::user();

        if ($user) {
            return response()->json([
                'user' => new UserResource($user),
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        }

        return [
            'code'=> 401,
            'message' => 'Invalid credentials.',
        ];
    }

    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function register(RegisterUserRequest $request) : JsonResponse
    {
       $user = $this->authService->register($request->validate());
//       @todo Send email to user. Use Job for send email
       return response()->json([
           'user' => new UserResource($user),
           'message' => "User has been registered successfully!"
       ],201);
    }

    public function refresh() : JsonResponse
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function resetPassword() {

    }
}
