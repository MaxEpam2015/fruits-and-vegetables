<?php

declare(strict_types=1);

namespace App\Dto;

readonly class GroceryListDto
{
    public function __construct(
        public string $type,
        public ?int $minQuantity = null,
        public ?int $maxQuantity = null,
    ) {
    }
}
