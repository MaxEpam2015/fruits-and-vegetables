<?php

declare(strict_types=1);

namespace App\Application\Query\Grocery\DTO;

use App\Application\Query\QueryDTO;

final readonly class GrocerySearchQueryDTO implements QueryDTO
{
    public function __construct(
        public string $name,
        public ?string $type = null,
        public ?int $minQuantity = null,
        public ?int $maxQuantity = null,
    ) {
    }
}
