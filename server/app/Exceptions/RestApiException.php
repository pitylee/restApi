<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class RestApiException extends Exception
{
    /**
     * RestApiException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
