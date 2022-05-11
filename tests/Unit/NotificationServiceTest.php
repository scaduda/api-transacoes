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

    $this->mockTransaction = new Transaction(
        $this->payerMock,
        $this->payeeMock,
        20
    );

    $mockNotificationRepository = Mockery::mock(NotificationRepositoryInterface::class);
    $mockNotificationRepository->shouldReceive('notify');
    $this->notificationService = new NotificationService($mockNotificationRepository);
});

it('OK - Notify', function () {
    $return = $this->notificationService->notify($this->mockTransaction);
    expect($return)->toBeEmpty();
});


