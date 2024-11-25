<?php

declare(strict_types=1);

namespace App\DTO\Request;

class GroceryDeleteDTO
{
    public function __construct(
        public string $type,
        public int|string $id,
    ) {
    }
}
