<?php

use App\DTO\TransactionDTO;
use App\Entities\Transaction;
use App\Entities\User;
use App\Enums\TypeUserEnum;
use App\Repositories\Interfaces\AuthorizationRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\AuthorizationService;
use App\Services\NotificationService;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Utils\Exceptions\AuthorizationException;
use App\Utils\Exceptions\TransactionException;
use App\ValuesObjects\Email;
use App\ValuesObjects\Name;
use App\ValuesObjects\Register;

beforeEach(function () {
    $this->mockUserRepository = Mockery::mock(UserRepositoryInterface::class);
    $this->mockUserRepository->shouldReceive('findId')
        ->andReturn(3);
    $this->mockUserRepository->shouldReceive('updateBalance')
        ->andReturn(true);

    $this->payerMock = new User(
        name: new Name('Nicolas Gustavo Moraes'),
        type: TypeUserEnum::Person,
        register: new Register('63551362238'),
        email: new Email('nicolas_gustavo_moraes@bcconsult.com.br'),
        password: '123456',
        balance: 120,
        fantasy_name: ''
    );

    $this->payerMockTwo = new User(
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
    $this->payeeMockCompany = new User(
        name: new Name('Nicole e Marcela Adega Ltda'),
        type: TypeUserEnum::LegalPerson,
        register: new Register('41429041000185'),
        email: new Email('edson@jamal.com'),
        password: '123456',
        balance: 120,
        fantasy_name: 'Nicole e Marcela Adega Ltda'
    );
    $this->payeeZeroBalance = new User(
        name: new Name('Luna Vanessa Alves'),
        type: TypeUserEnum::Person,
        register: new Register('76062487103'),
        email: new Email('luna_alves@redacaofinal.com.br'),
        password: '123456',
        balance: 0,
        fantasy_name: ''
    );

    $this->mockUserRepository->shouldReceive('findUser')
        ->andReturn($this->payerMock, $this->payeeMock);

    $this->userService = new UserService($this->mockUserRepository);

    $mockAuthorizeRepository = Mockery::mock(AuthorizationRepositoryInterface::class);
    $mockAuthorizeRepository->shouldReceive('authorize')
        ->andReturn(true);
    $this->authorizationService = new AuthorizationService($mockAuthorizeRepository);

    $this->mockTransaction = new Transaction(
        $this->payerMock,
        $this->payeeMock,
        20
    );

    $mockNotificationRepository = Mockery::mock(NotificationRepositoryInterface::class);
    $mockNotificationRepository->shouldReceive('notify');
    $this->notificationService = new NotificationService($mockNotificationRepository);

});

it('Fail - Payer is not Payer', function () {
    $transactionRepositoryInterface = Mockery::mock(TransactionRepositoryInterface::class);
    $transactionRepositoryInterface->shouldReceive('beginTransaction');
    $transactionRepositoryInterface->shouldReceive('rollbackTransaction');
    $mockAuthorizeRepository = Mockery::mock(AuthorizationRepositoryInterface::class);
    $authorizationService = new AuthorizationService($mockAuthorizeRepository);
    $mockUserRepository = Mockery::mock(UserRepositoryInterface::class);
    $mockUserRepository->shouldReceive('findUser')
        ->andReturn($this->payeeMockCompany, $this->payerMock);

    $userService = new UserService($mockUserRepository);
    $transService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $transService->makeTransaction(new TransactionDTO(1, 2, 10));
})->throws(DomainException::class, 'Só Pessoas Físicas podem realizar transferências');

it('Fail - Payer is not Value', function () {
    $transactionRepositoryInterface = Mockery::mock(TransactionRepositoryInterface::class);
    $transactionRepositoryInterface->shouldReceive('beginTransaction');
    $transactionRepositoryInterface->shouldReceive('rollbackTransaction');
    $mockAuthorizeRepository = Mockery::mock(AuthorizationRepositoryInterface::class);
    $authorizationService = new AuthorizationService($mockAuthorizeRepository);
    $mockUserRepository = Mockery::mock(UserRepositoryInterface::class);
    $mockUserRepository->shouldReceive('findUser')
        ->andReturn($this->payeeZeroBalance, $this->payerMock);

    $userService = new UserService($mockUserRepository);
    $tansService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $tansService->makeTransaction(new TransactionDTO(1, 2, 10));
})->throws(DomainException::class, 'Saldo insuficiente');

it('Fail - Value equal 0', function () {
    $transactionRepositoryInterface = Mockery::mock(TransactionRepositoryInterface::class);
    $transactionRepositoryInterface->shouldReceive('beginTransaction');
    $transactionRepositoryInterface->shouldReceive('rollbackTransaction');
    $mockAuthorizeRepository = Mockery::mock(AuthorizationRepositoryInterface::class);
    $authorizationService = new AuthorizationService($mockAuthorizeRepository);
    $tansService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $this->userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $tansService->makeTransaction(new TransactionDTO(1, 2, 0));
})->throws(DomainException::class, 'Insira um valor válido');

it('Fail - Value equal users', function () {
    $transactionRepositoryInterface = Mockery::mock(TransactionRepositoryInterface::class);
    $transactionRepositoryInterface->shouldReceive('beginTransaction');
    $transactionRepositoryInterface->shouldReceive('rollbackTransaction');
    $mockAuthorizeRepository = Mockery::mock(AuthorizationRepositoryInterface::class);
    $authorizationService = new AuthorizationService($mockAuthorizeRepository);
    $mockUserRepository = Mockery::mock(UserRepositoryInterface::class);
    $mockUserRepository->shouldReceive('findUser')
        ->andReturn($this->payerMock, $this->payerMock);

    $userService = new UserService($mockUserRepository);
    $tansService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $tansService->makeTransaction(new TransactionDTO(1, 2, 10));
})->throws(DomainException::class, 'Pagador e receptor não podem ser iguais');

it('Fail - Authorize', function () {
    $transactionRepositoryInterface = Mockery::mock(TransactionRepositoryInterface::class);
    $transactionRepositoryInterface->shouldReceive('beginTransaction');
    $transactionRepositoryInterface->shouldReceive('rollbackTransaction');
    $mockAuthorizeRepository = Mockery::mock(AuthorizationRepositoryInterface::class);
    $mockAuthorizeRepository->shouldReceive('authorize')
        ->andReturn(false);
    $authorizationService = new AuthorizationService($mockAuthorizeRepository);
    $tansService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $this->userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $tansService->makeTransaction(new TransactionDTO(1, 2, 30));
})->throws(AuthorizationException::class, 'Transação não autorizada');

it('Fail - Debit', function () {
    $transactionRepositoryInterface = Mockery::mock(TransactionRepositoryInterface::class);
    $transactionRepositoryInterface->shouldReceive('beginTransaction');
    $transactionRepositoryInterface->shouldReceive('rollbackTransaction');
    $mockAuthorizeRepository = Mockery::mock(AuthorizationRepositoryInterface::class);
    $mockAuthorizeRepository->shouldReceive('authorize')
        ->andReturn(true);
    $authorizationService = new AuthorizationService($mockAuthorizeRepository);

    $userService = Mockery::mock(UserService::class);
    $userService->shouldReceive('find')
        ->andReturn($this->payerMock, $this->payeeMock);
    $userService->shouldReceive('debit')
        ->andThrow(DomainException::class, 'Falha ao atualizar o banco');
    $tansService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $tansService->makeTransaction(new TransactionDTO(1, 2, 30));
})->throws(DomainException::class, 'Falha ao atualizar o banco');

it('Fail - addTransaction', function () {
    $transactionRepositoryInterface = Mockery::mock(TransactionRepositoryInterface::class);
    $transactionRepositoryInterface->shouldReceive('beginTransaction');
    $transactionRepositoryInterface->shouldReceive('rollbackTransaction');
    $mockAuthorizeRepository = Mockery::mock(AuthorizationRepositoryInterface::class);
    $mockAuthorizeRepository->shouldReceive('authorize')
        ->andReturn(true);
    $authorizationService = new AuthorizationService($mockAuthorizeRepository);

    $userService = Mockery::mock(UserService::class);
    $userService->shouldReceive('find')
        ->andReturn($this->payerMock, $this->payeeMock);
    $userService->shouldReceive('debit')
        ->andReturn();
    $tansService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $transactionRepositoryInterface->shouldReceive('addTransaction')
    ->andThrow(TransactionException::class, 'Erro ao realizar transação');

    $tansService->makeTransaction(new TransactionDTO(1, 2, 30));
})->throws(TransactionException::class, 'Erro ao realizar transação');

it('Fail - credit', function () {
    $transactionRepositoryInterface = Mockery::mock(TransactionRepositoryInterface::class);
    $transactionRepositoryInterface->shouldReceive('beginTransaction');
    $transactionRepositoryInterface->shouldReceive('rollbackTransaction');
    $mockAuthorizeRepository = Mockery::mock(AuthorizationRepositoryInterface::class);
    $mockAuthorizeRepository->shouldReceive('authorize')
        ->andReturn(true);
    $authorizationService = new AuthorizationService($mockAuthorizeRepository);

    $userService = Mockery::mock(UserService::class);
    $userService->shouldReceive('find')
        ->andReturn($this->payerMock, $this->payeeMock);
    $userService->shouldReceive('debit')
        ->andReturn();
    $tansService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $transactionRepositoryInterface->shouldReceive('addTransaction')
        ->andReturn();

    $userService->shouldReceive('credit')
        ->andThrow(DomainException::class, 'Falha ao atualizar o banco');

    $tansService->makeTransaction(new TransactionDTO(1, 2, 30));
})->throws(DomainException::class, 'Falha ao atualizar o banco');

it('OK - makeTransaction', function () {
    $transactionRepositoryInterface = Mockery::mock(TransactionRepositoryInterface::class);
    $transactionRepositoryInterface->shouldReceive('beginTransaction');
    $transactionRepositoryInterface->shouldReceive('commitTransaction');
    $transactionRepositoryInterface->shouldReceive('rollbackTransaction');
    $mockAuthorizeRepository = Mockery::mock(AuthorizationRepositoryInterface::class);
    $mockAuthorizeRepository->shouldReceive('authorize')
        ->andReturn(true);
    $authorizationService = new AuthorizationService($mockAuthorizeRepository);

    $userService = Mockery::mock(UserService::class);
    $userService->shouldReceive('find')
        ->andReturn($this->payerMock, $this->payeeMock);
    $userService->shouldReceive('debit')
        ->andReturn();
    $tansService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $transactionRepositoryInterface->shouldReceive('addTransaction')
        ->andReturn();

    $userService->shouldReceive('credit')
        ->andReturn();

    $transaction = $tansService->makeTransaction(new TransactionDTO(1, 2, 30));
    expect($transaction)->toBeTrue();
});
