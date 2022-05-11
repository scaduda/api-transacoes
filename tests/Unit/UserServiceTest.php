<?php

use App\Entities\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService;
use App\Enums\TypeUserEnum;
use App\ValuesObjects\Email;
use App\ValuesObjects\Name;
use App\ValuesObjects\Register;


test('Teste débito no payer', function () {
    $mockRepository = Mockery::mock(UserRepositoryInterface::class);
    $mockRepository->shouldReceive('findId')
        ->andReturn(3);
    $mockRepository->shouldReceive('updateBalance')
        ->andReturn(true);
    $service = new UserService($mockRepository);
    $valorEntrada = 120.20;
    $valorSaida = 20;
    $userMock  = new User(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::Person,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
        balance: $valorEntrada,
        fantasy_name: ''
    );
    $return = $service->debit($userMock,20);

    expect($return)->toBeTrue();
    expect($userMock->getBalance())->toBe($valorEntrada-$valorSaida);
});

