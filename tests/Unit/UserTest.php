<?php

use App\Entities\User;
use App\Enums\TypeUserEnum;
use App\ValuesObjects\Email;
use App\ValuesObjects\Name;
use App\ValuesObjects\Register;


test('OK - get balance', function () {
    $user = new User(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::Person,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
        balance: 120.20,
        fantasy_name: ''
    );
    expect($user->getBalance())->toBeFloat();
});

test('OK - Usuario é Payer', function () {
    $user = new User(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::Person,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
        balance: 120.20,
        fantasy_name: ''
    );
    expect($user->isPayer())->toBeTrue();
});

test('Fail - Usuario não pode ser Payer', function () {
    $user = new User(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::LegalPerson,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
        balance: 120.20,
        fantasy_name: ''
    );
    expect($user->isPayer())->toBeFalse();
});


