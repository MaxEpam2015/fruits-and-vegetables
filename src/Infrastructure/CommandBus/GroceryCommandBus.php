<?php

declare(strict_types=1);

namespace App\Infrastructure\CommandBus;

use App\Application\Command\CommandDTO;
use App\Application\Command\CommandHandler;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;

final readonly class GroceryCommandBus
{
    /**
     * @param array<class-string<CommandDTO>, CommandHandler> $handlers
     */
    public function __construct(private array $handlers)
    {
    }

    public function __invoke(
        CommandDTO $commandDTO,
        GroceryRepository $groceryRepository,
    ): string|bool {
        $commandClass = $commandDTO::class;
        if (!isset($this->handlers[$commandClass])) {
            throw new \InvalidArgumentException(sprintf('No handler found for command of type "%s".', $commandClass));
        }

        $handler = $this->handlers[$commandClass];

        return $handler->handle($commandDTO, $groceryRepository);
    }
}
