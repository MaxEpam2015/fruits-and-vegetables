<?php

declare(strict_types=1);

namespace App\Dto\Request;

readonly class GrocerySearchDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $type = null,
        public ?int $minQuantity = null,
        public ?int $maxQuantity = null,
    ) {
    }
}
