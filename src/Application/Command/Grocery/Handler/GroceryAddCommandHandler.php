<?php

declare(strict_types=1);

namespace App\Application\Command\Grocery\Handler;

use App\Application\Command\CommandDTO;
use App\Application\Command\CommandHandler;
use App\Domain\Entity\Grocery;
use App\Domain\Exception\Repository\Grocery\GroceryDTONotFound;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;

final readonly class GroceryAddCommandHandler implements CommandHandler
{
    /**
     * @param CommandDTO $commandDTO
     * @param GroceryRepository $groceryRepository
     * @return string
     * @throws GroceryDTONotFound
     */
    public function handle(CommandDTO $commandDTO, GroceryRepository $groceryRepository): string
    {
        if (null === $commandDTO->type) {
            throw GroceryDTONotFound::withGroceryType($commandDTO->type);
        }

        $grocery = new Grocery();
        $grocery->setName($commandDTO->name);
        $grocery->setQuantity($commandDTO->quantity);
        $grocery->setType($commandDTO->type);
        $grocery->setUnit($commandDTO->unit ?? '');
        $groceryRepository->add($grocery);

        return $commandDTO->name.' has been added successfully';
    }
}
