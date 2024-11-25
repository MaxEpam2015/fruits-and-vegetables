<?php

declare(strict_types=1);

namespace App\Application\Query\Grocery\DTO;

use App\Application\Query\QueryDTO;

final readonly class GetGroceryListQueryDTO implements QueryDTO
{
    public function __construct(
        public string $type,
        public ?int $minQuantity,
        public ?int $maxQuantity,
    ) {
    }
}
