<?php

declare(strict_types=1);

namespace App\Interfaces;


use App\Repository\GroceryRepository;
use Doctrine\ORM\QueryBuilder;

interface GroceryFilterInterface
{
    public function handle(array $criteria, GroceryRepository $groceryRepository, QueryBuilder &$result): void;

    public function setNext(GroceryFilterInterface $nextField): GroceryFilterInterface;
}