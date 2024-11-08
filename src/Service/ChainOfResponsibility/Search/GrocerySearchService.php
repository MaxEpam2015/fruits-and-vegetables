<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Search;

use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Search\Fields\Name;
use App\Service\ChainOfResponsibility\Search\Fields\Quantity;
use App\Service\ChainOfResponsibility\Search\Fields\Type;

class GrocerySearchService
{
    protected GrocerySearchInterface $firstField;

    public function __construct(
        protected GroceryRepository $groceryRepository,
        Name $nameField,
        Type $typeField,
        Quantity $quantityField,
    ) {
        $nameField->setNext($typeField)->setNext($quantityField);
        $this->firstField = $nameField;
    }

    /**
     * @param array{name: string, type: string, minQuantity: ?int, maxQuantity: ?int} $fields
     */
    public function perform(array $fields): mixed
    {
        $result = $this->groceryRepository->createQueryBuilder('g');
        $this->firstField->handle($fields, $this->groceryRepository, $result);

        return $this->groceryRepository->getResult($result);
    }
}
