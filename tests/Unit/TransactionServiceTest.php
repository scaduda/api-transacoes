<?php

use App\Adapters\HttpClientInterface;
use App\DTO\TransactionDTO;
use App\Entities\Transaction;
use App\Entities\User;
use App\Enums\TypeUserEnum;
use App\Repositories\AuthorizationRepository;
use App\Repositories\Interfaces\AuthorizationRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\AuthorizationService;
use App\Services\NotificationService;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Utils\Exceptions\AuthorizationException;
use App\Utils\Exceptions\NotificationException;
use App\Utils\Exceptions\TransactionException;
use App\ValuesObjects\Email;
use App\ValuesObjects\Name;
use App\ValuesObjects\Register;
use Psr\Http\Message\ResponseInterface;

beforeEach(function () {
    $this->mockUserRepository = Mockery::mock(UserRepositoryInterface::class);
    $this->mockUserRepository->shouldReceive('findId')
        ->andReturn(3);
    $this->mockUserRepository->shouldReceive('updateBalance')
        ->andReturn(true);

    $this->payerMock = new User(
        name: new Name('Edson lima'),
        type: TypeUserEnum::Person,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
        balance: 120,
        fantasy_name: ''
    );
    $this->payeeMock = new User(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::Person,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
        balance: 120,
        fantasy_name: ''
    );
    $this->payeeMockCompany = new User(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::LegalPerson,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
        balance: 120,
        fantasy_name: ''
    );
    $this->payeeZeroBalance = new User(
        name: new Name('Samira Caduda'),
        type: TypeUserEnum::Person,
        register: new Register('046126565623'),
        email: new Email('edson@jamal.com'),
        password: 'public readonly string $password',
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

it('OK - Authorize', function () {
    $return = $this->authorizationService->authorize($this->mockTransaction);
    expect($return)->toBeTrue();
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
    $tansService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $tansService->makeTransaction(new TransactionDTO(1, 2, 10));
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
        ->andThrow(DomainException::class);
    $tansService = new TransactionService(
        transactionRepository: $transactionRepositoryInterface,
        userService: $userService,
        notificationService: $this->notificationService,
        autorizationService: $authorizationService
    );
    $tansService->makeTransaction(new TransactionDTO(1, 2, 30));
})->throws(DomainException::class);



it('Fail - Authorize3', function () {
    $response = Mockery::mock(ResponseInterface::class);
    $response->shouldReceive('getStatusCode')
        ->andReturn(400);
    $mockHttpClient = Mockery::mock(HttpClientInterface::class);
    $mockHttpClient->shouldReceive('get')
        ->andReturn($response);
    $authorizationService = new AuthorizationRepository($mockHttpClient);
    expect($authorizationService->authorize($this->mockTransaction))->toBeFalse();
});

it('Fail - Authorize4', function () {
    $response = Mockery::mock(ResponseInterface::class);
    $response->shouldReceive('getStatusCode')
        ->andReturn(200);
    $response->shouldReceive('getBody')
        ->andReturn(json_encode(['message' => 'nao autorizado']));
    $mockHttpClient = Mockery::mock(HttpClientInterface::class);
    $mockHttpClient->shouldReceive('get')
        ->andReturn($response);
    $authorizationService = new AuthorizationRepository($mockHttpClient);
    expect($authorizationService->authorize($this->mockTransaction))->toBeFalse();
});


it('OK - Notify', function () {
    $return = $this->notificationService->notify($this->mockTransaction);
    expect($return)->toBeEmpty();
});

