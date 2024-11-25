<?php

declare(strict_types=1);

namespace App\DTO\Request;

readonly class GroceryListDTO
{
    public function __construct(
        public string $type,
        public ?int $minQuantity = null,
        public ?int $maxQuantity = null,
    ) {
    }
}
