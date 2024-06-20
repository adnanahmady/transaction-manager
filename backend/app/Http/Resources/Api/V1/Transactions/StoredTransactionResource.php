<?php

namespace App\Http\Resources\Api\V1\Transactions;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoredTransactionResource extends JsonResource
{
    /**
     * @var Transaction
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'sender_card_number' => $this->resource
                ->{Transaction::SENDER_CARD},
            'receiver_card_number' => $this->resource
                ->{Transaction::RECEIVER_CARD},
            'amount' => $this->resource->{Transaction::AMOUNT},
            'status' => $this->resource->{Transaction::STATUS}->lowerName(),
            'fee' => $this->resource->{Transaction::FEE},
            'created_at' => $this->resource
                ->{Transaction::CREATED_AT}
                ->format('Y-m-d H:i:s'),
        ];
    }
}
