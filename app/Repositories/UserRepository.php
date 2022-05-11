<?php

namespace App\Repositories;

use App\Entities\User;
use \App\Models\User as UserModel;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Utils\Exceptions\UserException;
use App\ValuesObjects\Email;
use App\ValuesObjects\Name;
use App\ValuesObjects\Register;

class UserRepository implements UserRepositoryInterface
{

    public function addUser(User $user): bool
    {
        $userModel = new UserModel([
                "name" => new Name($user->name),
                "type" => $user->type,
                "register" => new Register($user->register),
                "email" => new Email($user->email),
                "password" => $user->password,
                "balance" => $user->getBalance(),
                "fantasy_name" => $user->fantasy_name,
        ]);
        return $userModel->save();
    }

    public function findUser(int $id): ?User
    {
        try {
            $userBanco = UserModel::findOrFail($id);
            return $this->returnEntity($userBanco);
        } catch (\Exception) {
            throw new UserException('Usuário não encontrado');
        }

    }

    private function returnEntity(UserModel $user): ?User
    {
        return new User(
            new Name($user->name),
            $user->type,
            new Register($user->register),
            new Email($user->email),
            $user->password,
            $user->balance,
            $user->fantasy_name,
        );
    }

    public function findUserByRegisterAndEmail(string $register, string $email): ?User
    {
        $userModel = UserModel::where('register', $register)
            ->orWhere('email', $email)
            ->first();

        if ($userModel) {
            return $this->returnEntity($userModel);
        }

       return null;
    }

    public function updateBalance(int $id, float $value): bool
    {
        $user = UserModel::find($id);
        return (bool) $user->update(['balance' => $value]);
    }

    public function findId(string $register): int
    {
        return (UserModel::where('register', $register)->first())->id;
    }
}
