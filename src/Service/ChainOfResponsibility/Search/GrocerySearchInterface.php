<?php

namespace App\Service\ChainOfResponsibility\Search;

use App\Repository\GroceryRepository;
use Doctrine\ORM\QueryBuilder;

interface GrocerySearchInterface
{
    public function setNext(GrocerySearchInterface $nextField): GrocerySearchInterface;

    /**
     * @param array{name: ?string, type: ?string, minQuantity: ?int, maxQuantity: ?int} $criteria
     */
    public function handle(array $criteria, GroceryRepository $groceryRepository, QueryBuilder &$result): void;
}
