<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryBus;

use App\Application\Query\Query;

interface QueryBus
{
    public function __invoke(Query $query): mixed;
}