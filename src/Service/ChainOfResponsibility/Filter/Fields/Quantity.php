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

    public function handle(array $fields, GroceryRepository $groceryRepository, QueryBuilder &$result): void
    {
        if (isset($fields['minQuantity'])) {
            $result = $groceryRepository->setMinQuantityFilter($result, $fields['minQuantity']);
        }

        if (isset($fields['maxQuantity'])) {
            $result = $groceryRepository->setMaxQuantityFilter($result, $fields['maxQuantity']);
        }

        $this->nextField?->handle($fields, $groceryRepository, $result);
    }
}
