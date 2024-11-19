<?php

declare(strict_types=1);

namespace App\Domain\Exception\ValueObject\Grocery;

final class IdIsEmpty extends \Exception
{
    public function __construct(string $message = 'Id cannot be empty.')
    {
        parent::__construct($message);
    }
}
