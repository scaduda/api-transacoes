<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Entities\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\ValuesObjects\Email;
use App\ValuesObjects\Name;
use App\ValuesObjects\Register;
use DomainException;
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
    public function checkOfExists(string $register, string $email): void
    {
        $user = $this->userRepository->findUserByRegisterAndEmail($register, $email);

        if ($user) {
            throw new DomainException('Usuário já cadastrado');
        }
    }

    /**
     * @throws DomainException
     */
    public function debit(User $payer, float $value): bool
    {
        $payer->updateBalance($payer->getBalance() - $value);
        return $this->updateBalance($payer);
    }

    /**
     * @throws DomainException
     */
    public function credit(User $payee, float $value): bool
    {
        $payee->updateBalance($payee->getBalance() + $value);
        return $this->updateBalance($payee);
    }

    public function find(int $id): User
    {
        return $this->userRepository->findUser($id) ?? throw new \DomainException('Usuário não encontrado');
    }



    public function updateBalance(User $user): bool
    {
        $user_id = $this->userRepository->findId($user->register);
        $update  = $this->userRepository->updateBalance($user_id , $user->getBalance());
        if(false === $update){
            throw new DomainException('Falha ao atualizar o banco');
        }
        return $this->userRepository->updateBalance($user_id , $user->getBalance());
    }
}
