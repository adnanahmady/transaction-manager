<?php

namespace App\Http\Requests\Api\V1\Transactions;

use App\Http\Requests\BaseFormRequest;
use App\Rules\ValidCreditCardRule;

class TransferRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sender_card_number' => [
                'required',
                new ValidCreditCardRule(),
            ],
            'receiver_card_number' => [
                'required',
                new ValidCreditCardRule(),
            ],
            'amount' => [
                'required',
                'integer',
                'min:' . 10_000,
                'max:' . 500_000_000,
            ],
        ];
    }

    public function getSender(): string
    {
        return $this->input('sender_card_number');
    }

    public function getReceiver(): string
    {
        return $this->input('receiver_card_number');
    }

    public function getAmount(): int
    {
        return $this->input('amount');
    }
}
