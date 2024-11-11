<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Search\Fields;

use App\Dto\GrocerySearchDto;
use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Search\GrocerySearchInterface;
use Doctrine\ORM\QueryBuilder;

class Quantity implements GrocerySearchInterface
{
    private ?GrocerySearchInterface $nextField = null;

    public function handle(GrocerySearchDto $grocerySearchDto, GroceryRepository $groceryRepository, QueryBuilder &$result): void
    {
        if (isset($grocerySearchDto->minQuantity)) {
            $result = $groceryRepository->setMinQuantityFilter($result, $grocerySearchDto->minQuantity);
        }

        if (isset($grocerySearchDto->maxQuantity)) {
            $result = $groceryRepository->setMaxQuantityFilter($result, $grocerySearchDto->maxQuantity);
        }

        $this->nextField?->handle($grocerySearchDto, $groceryRepository, $result);
    }

    public function setNext(GrocerySearchInterface $nextField): GrocerySearchInterface
    {
        $this->nextField = $nextField;

        return $nextField;
    }
}
