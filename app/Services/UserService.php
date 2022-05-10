<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Entities\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function createUser(UserDTO $user): bool
    {
        $this->checkOfExists($user->register, $user->email);
        $this->validateFullName($user->name);

        return $this->userRepository->addUser(
            new User($user->toArray())
        );
    }

    /**
     * @throws Exception
     */
    private function validateFullName(string $name): void
    {
        //TODO: TROCAR ISSO DEPOIS DE TRATAR OS ERROS
        if (!(str_word_count($name) > 1)) {
            throw new Exception();
        }
    }

    /**
     * @throws Exception
     */
    private function checkOfExists(string $register, string $email): void
    {
        $user = $this->userRepository->findUserByRegisterAndEmail($register, $email);

        if ($user) {
            //TODO: TROCAR ISSO DEPOIS DE TRATAR OS ERROS
            throw new Exception();
        }
    }

    public function debit(User $payer, float $value)
    {
        $algumacoisa = true;
        if ($algumacoisa != true) {
            throw new \DomainException('hj n');
        }
    }

    public function credit(User $payee, float $value)
    {
    }

    public function find(int $id): User
    {
        return $this->userRepository->findUser($id) ?? throw new \DomainException('Usuário nãp encontrado');
    }


    /**
     * @throws Exception
     */
    private function updateBalance(int $id, float $value): bool
    {
        $user = $this->find($id);
        $balance = $user->balance;
        $newBalance = $balance + $value;
        return $this->userRepository->updateBalance($id, $newBalance);
    }
}
