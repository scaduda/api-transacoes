<?php

use App\DTO\UserDTO;
use App\Entities\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService;
use App\Enums\TypeUserEnum;
use App\ValuesObjects\Email;
use App\ValuesObjects\Name;
use App\ValuesObjects\Register;


it('Ok- Create User', function () {
    $mockRepository = Mockery::mock(UserRepositoryInterface::class);
    $mockRepository->shouldReceive('findId')
        ->andReturn(3);
    $mockRepository->shouldReceive('findUserByRegisterAndEmail')
    ->andReturnNull();
    $mockRepository->shouldReceive('addUser')
        ->andReturn(true);
    $service = new UserService($mockRepository);

    $valorEntrada = 120.20;
    $userMock  = new UserDTO(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::Person,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
        balance: $valorEntrada,
        fantasy_name: ''
    );
    $service->checkOfExists($userMock->register, $userMock->register);
    $return = $service->createUser($userMock);

    expect($return)->toBeTrue();
});

it('Fail - Create User - User exists', function () {
    $mockRepository = Mockery::mock(UserRepositoryInterface::class);
    $mockRepository->shouldReceive('findId')
        ->andReturn(3);
    $mockRepository->shouldReceive('addUser')
        ->andReturn(true);
    $service = new UserService($mockRepository);

    $valorEntrada = 120.20;
    $userMock  = new UserDTO(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::Person,
        register: new Register('046126565623'),
        email: new Email('samira@test.com'),
        password: '123456',
        balance: $valorEntrada,
        fantasy_name: ''
    );

    $userMockEntity  = new User(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::Person,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
        balance: $valorEntrada,
        fantasy_name: ''
    );
    $mockRepository->shouldReceive('findUserByRegisterAndEmail')
        ->andReturn($userMockEntity);
    $service->checkOfExists($userMock->register, $userMock->register);
    $return = $service->createUser($userMock);

    expect($return)->toBeTrue();
})->throws(DomainException::class, 'Usuário já cadastrado');

it('Ok - Debit payer', function () {
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

it('Fail - update balance', function () {
    $mockRepository = Mockery::mock(UserRepositoryInterface::class);
    $mockRepository->shouldReceive('findId')
        ->andReturn(3);
    $mockRepository->shouldReceive('updateBalance')
        ->andReturn(false);
    $service = new UserService($mockRepository);
    $userMock  = new User(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::Person,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
        balance: 200,
        fantasy_name: ''
    );
    $service->updateBalance($userMock);

})->throws(DomainException::class);

it('Ok - Credit payer', function () {
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
    $return = $service->credit($userMock,20);

    expect($return)->toBeTrue();
    expect($userMock->getBalance())->toBe($valorEntrada+$valorSaida);
});

