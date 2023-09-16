<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserSession;

class UserRepository
{

    public function findOne(int $id): ?User
    {
        return User::find($id);
    }

    public function create(array $userData): User
    {
        return User::create($userData);
    }

    public function update(User $user, array $userData): ?User
    {
        if ($user->update($userData)) {
            return $user;
        }
    }

    public function setAccessToken(User $user, string $token): ?bool
    {
        return !!UserSession::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'user_id' => $user->id,
                'access_token' => $token
            ]
        );
    }
}
