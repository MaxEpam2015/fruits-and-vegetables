<?php

declare(strict_types=1);

namespace App\ChainOfResponsibility\Search;

use App\ChainOfResponsibility\Search\Fields\Name;
use App\ChainOfResponsibility\Search\Fields\Quantity;
use App\ChainOfResponsibility\Search\Fields\Type;
use App\Interfaces\GrocerySearchInterface;
use App\Repository\GroceryRepository;

class GrocerySearchService
{
    protected GrocerySearchInterface $firstField;

    public function __construct(
        protected GroceryRepository $groceryRepository,
        Name $nameField,
        Type $typeField,
        Quantity $quantityField,
    )
    {
        $nameField->setNext($typeField)->setNext($quantityField);
        $this->firstField = $nameField;
    }

    public function perform(array $criteria): array
    {
        $result = $this->groceryRepository->createQueryBuilder('g');
        $this->firstField->handle($criteria , $this->groceryRepository, $result);

        return $this->groceryRepository->getResult($result);
    }
}