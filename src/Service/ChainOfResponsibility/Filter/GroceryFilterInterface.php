<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Filter;

use App\Repository\GroceryRepository;
use Doctrine\ORM\QueryBuilder;

interface GroceryFilterInterface
{
    /**
     * @param array{type: ?string, minQuantity: ?int, maxQuantity: ?int} $criteria
     */
    public function handle(array $criteria, GroceryRepository $groceryRepository, QueryBuilder &$result): void;

    public function setNext(GroceryFilterInterface $nextField): GroceryFilterInterface;
}
