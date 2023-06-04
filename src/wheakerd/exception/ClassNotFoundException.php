<?php
declare(strict_types=1);

namespace wheakerd\exception;

use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;
use Throwable;

class ClassNotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
    protected string $class;

    public function __construct(string $message, string $class = "", Throwable $previous = null)
    {
        $this->message = $message;
        $this->class = $class;

        parent::__construct($message, 0, $previous);
    }

    /**
     * 获取类名
     * @access public
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}