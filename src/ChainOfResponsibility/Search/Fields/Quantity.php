<?php

declare(strict_types=1);

namespace App\ChainOfResponsibility\Search\Fields;

use App\Interfaces\GrocerySearchInterface;
use App\Repository\GroceryRepository;
use Doctrine\ORM\QueryBuilder;

class Quantity implements GrocerySearchInterface
{
    private ?GrocerySearchInterface $nextField = null;

    public function handle(array $criteria, GroceryRepository $groceryRepository, QueryBuilder &$result): void
    {
        if (isset($criteria['minQuantity'])) {

            $result =  $groceryRepository->setMinQuantityFilter($result, $criteria['minQuantity']);


        }

        if (isset($criteria['maxQuantity'])) {
            $result = $groceryRepository->setMaxQuantityFilter($result, $criteria['maxQuantity']);
        }

        $this->nextField?->handle($criteria, $groceryRepository, $result);
    }

    public function setNext(GrocerySearchInterface $nextField): GrocerySearchInterface
    {
        $this->nextField = $nextField;
        return $nextField;
    }


}
