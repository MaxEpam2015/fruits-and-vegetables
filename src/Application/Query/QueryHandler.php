<?php

declare(strict_types=1);

namespace App\Application\Query;

interface QueryHandler
{
    public function handle(Query $query): mixed;
}