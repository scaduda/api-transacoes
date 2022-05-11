<?php

use App\Entities\Transaction;
use App\Entities\User;
use App\Enums\TypeUserEnum;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\TransactionRepository;
use App\ValuesObjects\Email;
use App\ValuesObjects\Name;
use App\ValuesObjects\Register;

beforeEach(function () {
    $this->mockUserRepository = Mockery::mock(UserRepositoryInterface::class);
    $this->mockUserRepository->shouldReceive('findId')
        ->andReturn(3);
    $this->transactionRepository = new TransactionRepository($this->mockUserRepository);

    $this->payerMock = new User(
        name: new Name('Analu Heloise Lúcia da Conceição'),
        type: TypeUserEnum::Person,
        register: new Register('66130122543'),
        email: new Email('analuheloisedaconceicao@saae.sp.gov.br'),
        password: '123456',
        balance: 100.6,
        fantasy_name: ''
    );

    $this->payeeMock = new User(
        name: new Name('Geraldo Diogo Raimundo Ferreira'),
        type: TypeUserEnum::Person,
        register: new Register('06682882998'),
        email: new Email('geraldo_ferreira@andrelam.com.br'),
        password: '123456',
        balance: 80,
        fantasy_name: ''
    );

    $this->transactionEntity = new Transaction(
        $this->payerMock,
        $this->payeeMock,
        20
    );

});

//it('OK - addTransaction', function () {
//    $response = $this->transactionRepository->addTransaction($this->transactionEntity);
//    expect($response)->toBeTrue();
//});


