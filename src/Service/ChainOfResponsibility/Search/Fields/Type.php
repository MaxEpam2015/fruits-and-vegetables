<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Search\Fields;

use App\Dto\Request\GrocerySearchDto;
use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Search\GrocerySearchInterface;
use Doctrine\ORM\QueryBuilder;

class Type implements GrocerySearchInterface
{
    private ?GrocerySearchInterface $nextField = null;

    public function handle(GrocerySearchDto $grocerySearchDto, GroceryRepository $groceryRepository, QueryBuilder &$result): void
    {
        if (isset($grocerySearchDto->type)) {
            $result = $groceryRepository->setTypeFilter($result, $grocerySearchDto->type);
        }

        if ($this->nextField) {
            $this->nextField->handle($grocerySearchDto, $groceryRepository, $result);
        }
    }

    public function setNext(GrocerySearchInterface $nextField): GrocerySearchInterface
    {
        $this->nextField = $nextField;

        return $nextField;
    }
}
