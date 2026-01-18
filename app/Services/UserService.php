<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function list(array $filters = [])
    {
        $query = User::query()->where('scope_id', scope_id());

        // Apply filters if any
        foreach ($filters as $key => $value) {
            if (in_array($key, ['name', 'email', 'username', 'role_id'])) {
                $query->where($key, $value);
            }
        }
        return $query->get();
    }
    public function create(array $data)
    {
        $userName = strtolower(substr($data['name'], 0, 3)) . rand(1000, 9999);
        $data['username'] = $data['username'] ?? $userName;
        $data['password'] = Hash::make($data['password']);
        $data['role_id'] = $data['role_id'] ?? 2; // default role_id to 2 (user)
        $data['scope_id'] = $data['scope_id'] ?? scope_id();
        
        $user =  User::create($data);
        if($user->scope_id == null){
            $user->scope_id = $user->id;
            $user->save();
        }
        return $user;
    }

    public function update(User $user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $data['username'] = $data['username']??$user->username;
        $user->update($data);
        return $user;
    }
    public function authenticate(array $credentials)
    {
        $login = $credentials['login'];
        $password = $credentials['password'];

        $user = User::where('email', $login)
            ->orWhere('username', $login)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            return $user;
        }

        return null;
    }
    public function getById($id)
    {
        return User::findOrFail($id);
    }
}