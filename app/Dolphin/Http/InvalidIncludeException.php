<?php

namespace App\Dolphin\Http;

use RuntimeException;
use Throwable;

class InvalidIncludeException extends RuntimeException
{
    /**
     * InvalidIncludeException constructor.
     * @param  string  $message
     * @param  int  $code
     * @param  Throwable|null  $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param  string  $data
     * @return static
     */
    public static function init(string $data): self
    {
        $message = sprintf("The requested data: %s is now allowed.", $data);
        return new self($message);
    }
}
