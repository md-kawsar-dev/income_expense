<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Constant;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use AuthorizesRequests;
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }
    public function index(Request $request)
    {              
        $users = $this->userService->list($request->all());
        $users->load('role');
        return UserResource::collection($users);
    }
    public function store(UserStoreRequest $request)
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
    public function show($id)
    {
        $user = $this->userService->getById($id);
        $user->load('role');
        return success(new UserResource($user), 'User fetched successfully', 200);
    }
    public function update(UserStoreRequest $request,User $user)
    {
        $validated = $request->validated();
        try {
            $result = DB::transaction(function () use ($user, $validated) {
                return $this->userService->update($user, $validated);
            });
            $result->load('role');
            return success(new UserResource($result), 'User updated successfully', 200);
        } catch (\Exception $th) {
            return error('Update failed: ' . $th->getMessage(), 500);
        }
    }
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return success(null, 'User deleted successfully', 200);
        } catch (\Exception $th) {
            return error('Deletion failed: ' . $th->getMessage(), 500);
        }
    }
}
