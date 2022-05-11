<?php

namespace App\Repositories\Interfaces;

use App\Entities\User;

interface UserRepositoryInterface
{
    public function addUser(User $user): bool;

    public function findUser(int $id): ?User;

    public function findUserByRegisterAndEmail(string $register, string $email): ?User;

    public function updateBalance(int $id, float $value): bool;

    public function findId(string $register): int;
}
