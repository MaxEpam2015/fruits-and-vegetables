<?php

declare(strict_types=1);

namespace App\Application\Query\Grocery;

use App\Application\Query\QueryHandler;
use App\Domain\Exception\Repository\Grocery\GroceryDTONotFound;
use App\Domain\ValueObject\Grocery\Type;
use App\Repository\GroceryRepository;
use App\Application\Query\Query;

final readonly class GetGroceryDTOByTypeQueryHandler implements QueryHandler
{
    public function __construct(
        private GroceryRepository $groceryRepository,
    ) {
    }

    /**
     * @throws GroceryDTONotFound
     */
    public function handle(Query $query): array
    {
        if (null === $query->type) {
            throw GroceryDTONotFound::withGroceryType($query->type);
        }
        $type = new Type($query->type);

        return $this->groceryRepository->getGroceriesList($type->type, $query->minQuantity, $query->maxQuantity);
    }
}
