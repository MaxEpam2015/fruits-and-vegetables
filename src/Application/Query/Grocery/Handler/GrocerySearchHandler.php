<?php

declare(strict_types=1);

namespace App\Application\Query\Grocery\Handler;

use App\Application\Query\QueryDTO;
use App\Application\Query\QueryHandler;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;

final readonly class GrocerySearchHandler implements QueryHandler
{
    public function handle(QueryDTO $query, GroceryRepository $groceryRepository): array
    {
        return $groceryRepository->search($query->name, $query->type, $query->minQuantity, $query->maxQuantity);
    }
}
