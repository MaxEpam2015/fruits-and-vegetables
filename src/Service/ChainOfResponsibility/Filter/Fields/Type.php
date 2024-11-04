<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Filter\Fields;


use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Filter\GroceryFilterInterface;
use Doctrine\ORM\QueryBuilder;

class Type implements GroceryFilterInterface
{
    private ?GroceryFilterInterface $nextField = null;

    public function handle(array $criteria, GroceryRepository $groceryRepository, QueryBuilder &$result): void
    {
        if (isset($criteria['type'])) {
            $result =  $groceryRepository->setTypeFilter($result, $criteria['type']);
        }

        $this->nextField?->handle($criteria, $groceryRepository, $result);
    }

    public function setNext(GroceryFilterInterface $nextField): GroceryFilterInterface
    {
        $this->nextField = $nextField;
        return $nextField;
    }
}