<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserService
{
    public function __construct(
        private IUserRepository $userRepository
    )
    {
    }

    public function createUser(UserDTO $user)
    {
        $userExists = $this->checkOfExists($user->register, $user->email);
        //TODO: RETIRAR ISSO DEPOIS DE TRATAR OS ERROS
        if ($userExists) {
            return ['Esse usuário já existe'];
        }

        $name = $this->validateFullName($user->name);
        if (!$name) {
            return ['Nome incompleto'];
        }

        return $this->userRepository->addUser(
            new User($user->toArray())
        );
    }

    private function validateFullName(string $name): bool
    {
        //TODO: TROCAR ISSO DEPOIS DE TRATAR OS ERROS
        return str_word_count($name) > 1;
    }

    private function checkOfExists(string $register, string $email): bool
    {
        $user = $this->userRepository->findUserByRegisterAndEmail($register, $email);

        if ($user) {
            //TODO: TROCAR ISSO DEPOIS DE TRATAR OS ERROS
            return true;
        }
        return false;
    }

    private function checkOfExistsById(int $id): User|null
    {
        $user = $this->userRepository->findUser($id);

        if (!$user) {
            //TODO: TROCAR ISSO DEPOIS DE TRATAR OS ERROS
            return null;
        }
        return $user;
    }

    public function checkBalance(int $id): float
    {
        $userExists = $this->checkOfExistsById($id);
        return $userExists->balance;
    }


    public function updateBalance(int $id, float $value): bool
    {
        $balance = $this->checkBalance($id);
        $newBalance = $balance + $value;
        return $this->userRepository->updateBalance($id, $newBalance);
    }
}
