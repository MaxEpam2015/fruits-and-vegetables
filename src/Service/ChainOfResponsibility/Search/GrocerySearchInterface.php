<?php

namespace App\Service\ChainOfResponsibility\Search;

use App\Dto\GrocerySearchDto;
use App\Repository\GroceryRepository;
use Doctrine\ORM\QueryBuilder;

interface GrocerySearchInterface
{
    public function setNext(GrocerySearchInterface $nextField): GrocerySearchInterface;

    public function handle(GrocerySearchDto $grocerySearchDto, GroceryRepository $groceryRepository, QueryBuilder &$result): void;
}
