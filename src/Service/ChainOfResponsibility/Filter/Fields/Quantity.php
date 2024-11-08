<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Filter\Fields;

use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Filter\GroceryFilterInterface;
use Doctrine\ORM\QueryBuilder;

class Quantity implements GroceryFilterInterface
{
    private ?GroceryFilterInterface $nextField = null;

    public function setNext(GroceryFilterInterface $nextField): GroceryFilterInterface
    {
        $this->nextField = $nextField;

        return $nextField;
    }

    public function handle(array $criteria, GroceryRepository $groceryRepository, QueryBuilder &$result): void
    {
        if (isset($criteria['minQuantity'])) {
            $result = $groceryRepository->setMinQuantityFilter($result, $criteria['minQuantity']);
        }

        if (isset($criteria['maxQuantity'])) {
            $result = $groceryRepository->setMaxQuantityFilter($result, $criteria['maxQuantity']);
        }

        $this->nextField?->handle($criteria, $groceryRepository, $result);
    }
}
