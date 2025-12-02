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
        $this->authorize('viewAny', User::class);
        return UserResource::collection(User::latest()->paginate(Constant::PAGE_LIMIT));
    }
    public function store(UserStoreRequest $request)
    {
        $this->authorize('create', User::class);
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
}
