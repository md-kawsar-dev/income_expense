<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService) {}
    public function register(UserStoreRequest $request)
    {
        $validated = $request->validated();
        try {
            $result = DB::transaction(function () use ($validated) {
                return $this->userService->create($validated);
            });
            $result->load('role');
            return success(new UserResource($result), 'User registered successfully', 200);
        } catch (\Exception $th) {
            return error('Registration failed: ' . $th->getMessage(), 500);
        }
    }

    public function login(Request $request)
    {
        // login username or email and password
        $credentials = $request->only('login', 'password');
        try {
            $user = $this->userService->authenticate($credentials);
            if (!$user) {
                return error('Invalid credentials', 401);
            }
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;
            $user->load('role');
            return success(new UserResource($user), 'User logged in successfully', 200);
        } catch (\Exception $th) {
            return error('Login failed: ' . $th->getMessage(), 500);
        }
    }
    public function profile()
    {
        return success(new UserResource(Auth::user()), 'User profile fetched successfully', 200);
    }
    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();
        return success(null, 'User logged out successfully', 200);
    }
}
