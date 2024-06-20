<?php

namespace App\Http\AppServices\Transactions;

use App\Http\Requests\Api\V1\Transactions\TransferRequest;
use App\Models\Transaction;

class StoreService
{
    public function __construct(private readonly TransferRequest $request) {}

    public function store(): Transaction
    {
        $transaction = new Transaction();
        $transaction->setSender($this->request->getSender());
        $transaction->setReceiver($this->request->getReceiver());
        $transaction->setAmount($this->request->getAmount());
        $transaction->markAsSuccess();
        $transaction->save();

        return $transaction->refresh();
    }
}
