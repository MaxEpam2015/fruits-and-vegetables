<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryBus;

use App\Application\Query\Query;
use App\Application\Query\QueryHandler;

final class GroceryQueryBus implements QueryBus
{
    /**
     * @var array<class-string<Query>, QueryHandler>
     */
    private array $handlers;

    /**
     * @param array<class-string<Query>, QueryHandler> $handlers
     */
    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function __invoke(Query $query): mixed
    {
        $queryClass = $query::class;

        if (!isset($this->handlers[$queryClass])) {
            throw new \InvalidArgumentException(sprintf('No handler found for query of type "%s".', $queryClass));
        }

        $handler = $this->handlers[$queryClass];

        return $handler->handle($query);
    }
}
