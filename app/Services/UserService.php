<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(array $data)
    {
        $userName = strtolower(substr($data['name'], 0, 3)) . rand(1000, 9999);
        $data['username'] = $data['username'] ?? $userName;
        $data['password'] = Hash::make($data['password']);
        
        return User::create($data);
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
}