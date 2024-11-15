<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Filter;

use App\Dto\Request\GroceryListDto;
use App\Repository\GroceryRepository;
use Doctrine\ORM\QueryBuilder;

interface GroceryFilterInterface
{

    public function handle(GroceryListDto $groceryListDto, GroceryRepository $groceryRepository, QueryBuilder &$result): void;

    public function setNext(GroceryFilterInterface $nextField): GroceryFilterInterface;
}
