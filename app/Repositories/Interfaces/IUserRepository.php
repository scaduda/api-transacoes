<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function addUser(User $user): bool;

    public function findUser(int $id): User|null;

    public function findUserByRegisterAndEmail(string $register, string $email): User|null;

    public function updateBalance(int $id, float $value): bool;
}
