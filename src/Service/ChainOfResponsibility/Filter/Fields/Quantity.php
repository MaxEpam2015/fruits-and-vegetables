<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Filter\Fields;

use App\Dto\GroceryListDto;
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

    public function handle(GroceryListDto $groceryListDto, GroceryRepository $groceryRepository, QueryBuilder &$result): void
    {
        if (isset($groceryListDto->minQuantity)) {
            $result = $groceryRepository->setMinQuantityFilter($result, $groceryListDto->minQuantity);
        }

        if (isset($groceryListDto->maxQuantity)) {
            $result = $groceryRepository->setMaxQuantityFilter($result, $groceryListDto->maxQuantity);
        }

        $this->nextField?->handle($groceryListDto, $groceryRepository, $result);
    }
}
