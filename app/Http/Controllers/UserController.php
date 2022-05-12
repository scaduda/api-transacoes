<?php

namespace App\Http\Controllers;

use App\Factories\UserFactory;
use App\Http\Requests\CreateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{


    public function __construct(
        private UserService $service
    )
    {
    }
    public function createUser(CreateUserRequest $request): JsonResponse
    {
        return response()->json($this->service->createUser(UserFactory::toDTO($request->all())))
            ->setStatusCode(Response::HTTP_CREATED);
    }

}
