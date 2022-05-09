<?php

namespace App\Http\Controllers;

use App\Factories\TransactionFactory;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $service
    )
    {
    }

    public function makeTransaction(TransactionRequest $request)
    {
        return response()->json($this->service->makeTransaction(TransactionFactory::toDTO($request->all())));
    }
}
