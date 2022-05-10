<?php

namespace App\Repositories\Database;

use App\Entities\User;
use App\Enums\TypeUserEnum;
use \App\Models\User as UserModel;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\ValuesObjects\Email;
use App\ValuesObjects\Register;

class UserRepository implements UserRepositoryInterface
{

    public function addUser(User $user): bool
    {
        return $user->save();
    }

    public function findUser(int $id): User
    {
        $userBanco = UserModel::find($id);
        return new User(
            $userBanco->name,
            $userBanco->type,
            new Register($userBanco->register),
            new Email($userBanco->email),
            $userBanco->password,
            $userBanco->balance,
            $userBanco->fantasy_name,
        );
    }

    public function findUserByRegisterAndEmail(string $register, string $email): User|null
    {
        return User::where('register', $register)
            ->orWhere('email', $email)
            ->first();
    }

    public function updateBalance(int $id, float $value): bool
    {
        $user = UserModel::find($id);
        return $user->update(['balance' => $value]);
    }

    public function findId(string $register): int
    {
        return (UserModel::where('register', $register)->first())->id;
    }
}
