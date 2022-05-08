<?php

namespace App\Repositories\Database;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{

    public function addUser(User $user): bool
    {
        return $user->save();
    }

    public function findUser(int $id): User|null
    {
        return User::find($id);
    }

    public function findUserByRegisterAndEmail(string $register, string $email): User|null
    {
        return User::where('register', $register)
            ->orWhere('email', $email)
            ->first();
    }

    public function updateBalance(int $id, float $value): bool
    {
        $user = $this->findUser($id);
        return $user->update(['balance' => $value]);
    }
}
