<?php

declare(strict_types=1);

namespace App\Application\Query\Grocery;

use App\Application\Query\Query;

final readonly class GetGroceryDTOByTypeQuery implements Query
{
    public function __construct(
        public string $type,
        public ?int $minQuantity,
        public ?int $maxQuantity,
    ) {
    }
}
