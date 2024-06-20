<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ForbiddenToSetFeeException extends HttpException
{
    public function __construct(
        string $message = null,
        ?\Throwable $previous = null,
        array $headers = [],
        int $code = 0,
    ) {
        $message = $message ?? __('You can not set the fee of a transaction');
        parent::__construct(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $message,
            $previous,
            $headers,
            $code,
        );
    }
}
