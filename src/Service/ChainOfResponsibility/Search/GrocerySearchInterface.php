<?php

namespace App\Service\ChainOfResponsibility\Search;

use App\Repository\GroceryRepository;
use Doctrine\ORM\QueryBuilder;

interface GrocerySearchInterface
{
    public function setNext(GrocerySearchInterface $nextField): GrocerySearchInterface;

    /**
     * @param array{name: ?string, type: ?string, minQuantity: ?int, maxQuantity: ?int} $fields
     */
    public function handle(array $fields, GroceryRepository $groceryRepository, QueryBuilder &$result): void;
}
