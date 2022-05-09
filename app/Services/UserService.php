<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Enums\TypeUserEnum;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Exception;

class UserService
{
    public function __construct(
        private IUserRepository $userRepository
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

    /**
     * @throws Exception
     */
    private function checkOfExistsById(int $id): User
    {
        $user = $this->userRepository->findUser($id);

        if (empty($user)) {
            //TODO: TROCAR ISSO DEPOIS DE TRATAR OS ERROS
            throw new Exception();
        }
        return $user;
    }

    /**
     * @throws Exception
     */
    public function validateUsers(int $payer_id, int $payee)
    {
        $payer = $this->userRepository->findUser($payer_id);
        if(empty($payer)) {
            //TODO: TROCAR ISSO DEPOIS DE TRATAR OS ERROS
            throw new Exception();
        }

        $payee = $this->userRepository->findUser($payer_id);
        if(empty($payee)) {
            //TODO: TROCAR ISSO DEPOIS DE TRATAR OS ERROS
            throw new Exception();
        }

        if ($payer->type == TypeUserEnum::PessoaJuridica) {
            //TODO: TROCAR ISSO DEPOIS DE TRATAR OS ERROS PESSOA JURÍDICA SÓ RECEBE
            throw new Exception();
        }
    }


    /**
     * @throws Exception
     */
    public function checkBalance(int $id): float
    {
        $userExists = $this->checkOfExistsById($id);
        return $userExists->balance;
    }


    /**
     * @throws Exception
     */
    public function updateBalance(int $id, float $value): bool
    {
        $balance = $this->checkBalance($id);
        $newBalance = $balance + $value;
        return $this->userRepository->updateBalance($id, $newBalance);
    }
}
