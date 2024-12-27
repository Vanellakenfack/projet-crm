<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Services\UserService; // Assurez-vous d'importer le UserService
use Tymon\JWTAuth\Facades\JWTAuth; // Assurez-vous d'importer JWTAuth

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService; // Correction ici
    }

    public function register(UserRequest $request)
    {
        $user = $this->userService->register($request->validated());
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        try {
            $user = $this->userService->login($request->only('email', 'password'));
            $token = JWTAuth::fromUser($user);
            return response()->json(compact('token', 'user'));
        } catch (CustomException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function profile()
    {
        $user = auth()->user();
        return new UserResource($user);
    }

    public function updateProfile(UserRequest $request)
    {
        $user = auth()->user();
        $this->userService->updateProfile($user, $request->validated());
        return response()->json(['message' => 'Profile updated successfully']);
    }
}