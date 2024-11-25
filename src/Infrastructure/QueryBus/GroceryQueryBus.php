<?php

declare(strict_types=1);

namespace App\Infrastructure\QueryBus;

use App\Application\Query\QueryDTO;
use App\Application\Query\QueryHandler;
use App\Repository\GroceryRepository;

final class GroceryQueryBus
{
    /**
     * @param array<class-string<QueryDTO>, QueryHandler> $handlers
     */
    public function __construct(protected array $handlers)
    {
    }

    public function __invoke(QueryDTO $query, GroceryRepository $groceryRepository): mixed
    {
        $queryClass = $query::class;

        if (!isset($this->handlers[$queryClass])) {
            throw new \InvalidArgumentException(sprintf('No handler found for query of type "%s".', $queryClass));
        }

        $handler = $this->handlers[$queryClass];

        return $handler->handle($query, $groceryRepository);
    }
}
