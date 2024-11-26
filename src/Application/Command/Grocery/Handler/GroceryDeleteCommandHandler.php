<?php

declare(strict_types=1);

namespace App\Application\Command\Grocery\Handler;

use App\Application\Command\CommandDTO;
use App\Application\Command\CommandHandler;
use App\Application\Command\Grocery\DTO\GroceryDeleteCommandDTO;
use App\Domain\Entity\Grocery;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class GroceryDeleteCommandHandler implements CommandHandler
{

    /** @param GroceryDeleteCommandDTO $commandDTO */
    public function handle(CommandDTO $commandDTO, GroceryRepository $groceryRepository): string
    {
        /** @var Grocery $grocery */
        $grocery = $groceryRepository->findOneBy(['type' => $commandDTO->type, 'id' => $commandDTO->id]);

        if (!$grocery) {
            throw new NotFoundHttpException('Not found grocery for id '.$commandDTO->id);
        }
        $groceryRepository->delete($grocery);

        return "Grocery id: {$commandDTO->id}, type: {$commandDTO->type} has been deleted successfully";
    }
}
