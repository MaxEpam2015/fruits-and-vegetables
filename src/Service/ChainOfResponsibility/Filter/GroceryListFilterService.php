<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Filter;

use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Filter\Fields\Quantity;
use App\Service\ChainOfResponsibility\Filter\Fields\Type;

class GroceryListFilterService
{
    protected GroceryFilterInterface $firstField;

    public function __construct(
        protected GroceryRepository $groceryRepository,
        Type $typeField,
        Quantity $quantityField,
    ) {
        $typeField->setNext($quantityField);
        $this->firstField = $typeField;
    }

    /**
     * @param array{type: string, minQuantity: ?int, maxQuantity: ?int} $fields
     */
    public function perform(array $fields): mixed
    {
        $result = $this->groceryRepository->createQueryBuilder('g');
        $this->firstField->handle($fields, $this->groceryRepository, $result);

        return $this->groceryRepository->getResult($result);
    }
}
