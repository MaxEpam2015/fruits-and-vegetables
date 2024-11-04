<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Search\Fields;

use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Search\GrocerySearchInterface;
use Doctrine\ORM\QueryBuilder;

class Name implements GrocerySearchInterface
{
    private ?GrocerySearchInterface $next = null;
    private ?GrocerySearchInterface $nextField = null;

    public function handle(array $criteria, GroceryRepository $groceryRepository, QueryBuilder &$result): void
    {
        if (isset($criteria['name'])) {
            $result = $groceryRepository->setNameFilter($result, $criteria['name']);
        }

        if ($this->nextField) {
            $this->nextField?->handle($criteria, $groceryRepository, $result);
        }
    }
    public function setNext(GrocerySearchInterface $nextField): GrocerySearchInterface
    {
        $this->nextField = $nextField;
        return $nextField;
    }


}
