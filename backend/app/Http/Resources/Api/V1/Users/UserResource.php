<?php

namespace App\Http\Resources\Api\V1\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @var User
     */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->resource->{User::NAME},
            'email' => $this->resource->{User::EMAIL},
            'phone_nubmer' => $this->resource->{User::PHONE_NUMBER},
            'transactions' => $this->resource->transactions->map(
                fn($transaction) => new TransactionResource($transaction),
            ),
        ];
    }
}
