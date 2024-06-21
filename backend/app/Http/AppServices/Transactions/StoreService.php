<?php

namespace App\Http\AppServices\Transactions;

use App\Http\Requests\Api\V1\Transactions\TransferRequest;
use App\Models\Transaction;
use App\NotificationMessages\SuccessTransactionForReceiverMessage;
use App\NotificationMessages\SuccessTransactionForSenderMessage;
use App\Notifications\TransactionSucceedNotification;

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

        $this->notifySender($transaction);
        $this->notifyReceiver($transaction);

        return $transaction->refresh();
    }

    public function notifySender(Transaction $transaction): void
    {
        if ($sender = $transaction->findSender()) {
            $sender->notify(new TransactionSucceedNotification(
                new SuccessTransactionForSenderMessage($sender),
            ));
        }
    }

    public function notifyReceiver(Transaction $transaction): void
    {
        if ($receiver = $transaction->findReceiver()) {
            $receiver->notify(new TransactionSucceedNotification(
                new SuccessTransactionForReceiverMessage($receiver),
            ));
        }
    }
}
