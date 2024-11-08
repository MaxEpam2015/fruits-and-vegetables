<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Filter\Fields;

use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Filter\GroceryFilterInterface;
use Doctrine\ORM\QueryBuilder;

class Type implements GroceryFilterInterface
{
    private ?GroceryFilterInterface $nextField = null;

    public function handle(array $fields, GroceryRepository $groceryRepository, QueryBuilder &$result): void
    {
        if (isset($fields['type'])) {
            $result = $groceryRepository->setTypeFilter($result, $fields['type']);
        }

        $this->nextField?->handle($fields, $groceryRepository, $result);
    }

    public function setNext(GroceryFilterInterface $nextField): GroceryFilterInterface
    {
        $this->nextField = $nextField;

        return $nextField;
    }
}
