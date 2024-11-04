<?php

namespace App\Service\ChainOfResponsibility\Search;

use App\Repository\GroceryRepository;
use Doctrine\ORM\QueryBuilder;

interface GrocerySearchInterface
{
    public function setNext(GrocerySearchInterface $nextField): GrocerySearchInterface;

    public function handle(array $criteria, GroceryRepository $groceryRepository, QueryBuilder &$result): void;

}