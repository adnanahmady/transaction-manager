<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\AppServices\Transactions\StoreService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Transactions\StoredTransactionResource;

class TransactionController extends Controller
{
    public function store(StoreService $service): StoredTransactionResource
    {
        return new StoredTransactionResource($service->store());
    }
}
