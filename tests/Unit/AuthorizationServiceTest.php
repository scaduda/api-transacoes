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

it('Fail - Authorize status 400', function () {
    $response = Mockery::mock(ResponseInterface::class);
    $response->shouldReceive('getStatusCode')
        ->andReturn(400);
    $mockHttpClient = Mockery::mock(HttpClientInterface::class);
    $mockHttpClient->shouldReceive('get')
        ->andReturn($response);
    $authorizationService = new AuthorizationRepository($mockHttpClient);
    expect($authorizationService->authorize($this->mockTransaction))->toBeFalse();
});

it('Fail - Authorize status 200 e mensagem não autorizado', function () {
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

