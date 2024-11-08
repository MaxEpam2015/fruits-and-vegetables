<?php

declare(strict_types=1);

namespace App\Service\ChainOfResponsibility\Filter;

use App\Repository\GroceryRepository;
use Doctrine\ORM\QueryBuilder;

interface GroceryFilterInterface
{
    /**
     * @param array{type: ?string, minQuantity: ?int, maxQuantity: ?int} $fields
     */
    public function handle(array $fields, GroceryRepository $groceryRepository, QueryBuilder &$result): void;

    public function setNext(GroceryFilterInterface $nextField): GroceryFilterInterface;
}
