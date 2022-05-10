<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Entities\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\ValuesObjects\Email;
use App\ValuesObjects\Name;
use App\ValuesObjects\Register;
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

        return $this->userRepository->addUser(
            new User(
                new Name($user->name),
                $user->type,
                new Register($user->register),
                new Email($user->email),
                $user->password,
                $user->balance,
                $user->fantasy_name,
            )
        );
    }

    /**
     * @throws Exception
     */
    private function checkOfExists(string $register, string $email): void
    {
        $user = $this->userRepository->findUserByRegisterAndEmail($register, $email);

        if ($user) {
            throw new \DomainException('Usuário já cadastrado');
        }
    }

    /**
     * @throws Exception
     */
    public function debit(User $payer, float $value): bool
    {
        $newBalance = $payer->balance - $value;
        return $this->updateBalance($payer, $newBalance);
    }

    /**
     * @throws Exception
     */
    public function credit(User $payee, float $value): bool
    {
        $newBalance = $payee->balance + $value;
        return $this->updateBalance($payee, $newBalance);
    }

    public function find(int $id): User
    {
        return $this->userRepository->findUser($id) ?? throw new \DomainException('Usuário nãp encontrado');
    }


    /**
     * @throws Exception
     */
    private function updateBalance(User $user, float $value): bool
    {
        $user_id =$this->userRepository->findId($user->register);
        return $this->userRepository->updateBalance($user_id , $value);
    }
}
