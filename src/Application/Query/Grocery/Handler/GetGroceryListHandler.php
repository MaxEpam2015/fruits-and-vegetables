<?php

declare(strict_types=1);

namespace App\Application\Query\Grocery\Handler;

use App\Application\Query\QueryDTO;
use App\Application\Query\QueryHandler;
use App\Domain\Exception\Repository\Grocery\GroceryDTONotFound;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;

final readonly class GetGroceryListHandler implements QueryHandler
{

    /**
     * @throws GroceryDTONotFound
     */
    public function handle(QueryDTO $query, GroceryRepository $groceryRepository): array
    {
        if (null === $query->type) {
            throw GroceryDTONotFound::withGroceryType($query->type);
        }

        return $groceryRepository->getGroceriesList($query->type, $query->minQuantity, $query->maxQuantity);
    }
}
