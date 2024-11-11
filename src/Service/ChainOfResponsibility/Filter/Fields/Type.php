<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Filter\Fields;

use App\Dto\GroceryListDto;
use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Filter\GroceryFilterInterface;
use Doctrine\ORM\QueryBuilder;

class Type implements GroceryFilterInterface
{
    private ?GroceryFilterInterface $nextField = null;

    public function handle(GroceryListDto $groceryListDto, GroceryRepository $groceryRepository, QueryBuilder &$result): void
    {
        if (isset($groceryListDto->type)) {
            $result = $groceryRepository->setTypeFilter($result, $groceryListDto->type);
        }

        $this->nextField?->handle($groceryListDto, $groceryRepository, $result);
    }

    public function setNext(GroceryFilterInterface $nextField): GroceryFilterInterface
    {
        $this->nextField = $nextField;

        return $nextField;
    }
}
