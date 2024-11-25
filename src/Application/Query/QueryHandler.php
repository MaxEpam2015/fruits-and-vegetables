<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Repository\GroceryRepository;

interface QueryHandler
{
    public function handle(QueryDTO $query, GroceryRepository $groceryRepository): mixed;
}
