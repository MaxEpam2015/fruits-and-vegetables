<?php

declare(strict_types=1);

namespace App\ChainOfResponsibility\Filter;

use App\ChainOfResponsibility\Filter\Fields\Quantity;
use App\ChainOfResponsibility\Filter\Fields\Type;
use App\Repository\GroceryRepository;

class GroceryListFilterService
{

    protected GroceryFilterInterface $firstField;
    public function __construct(
        protected GroceryRepository $groceryRepository,
        Type $typeField,
        Quantity $quantityField
    )
    {
        $typeField->setNext($quantityField);
        $this->firstField = $typeField;
    }

    public function perform(array $criteria): array
    {
        $result = $this->groceryRepository->createQueryBuilder('g');
        $this->firstField->handle($criteria , $this->groceryRepository, $result);

        return $this->groceryRepository->getResult($result);
    }
}
