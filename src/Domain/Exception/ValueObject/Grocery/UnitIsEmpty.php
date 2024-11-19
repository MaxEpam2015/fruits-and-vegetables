<?php

declare(strict_types=1);

namespace App\Domain\Exception\ValueObject\Grocery;

final class UnitIsEmpty extends \Exception
{
    public function __construct(string $message = 'Unit cannot be empty.')
    {
        parent::__construct($message);
    }
}
