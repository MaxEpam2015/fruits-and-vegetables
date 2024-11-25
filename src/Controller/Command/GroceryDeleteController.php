<?php

declare(strict_types=1);

namespace App\Controller\Command;

use App\Application\Command\Grocery\DTO\GroceryDeleteCommandDTO;
use App\Infrastructure\CommandBus\GroceryCommandBus;
use App\Repository\GroceryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
final class GroceryDeleteController extends AbstractController
{
    public function __construct(
        private readonly GroceryCommandBus $commandBus,
        private readonly GroceryRepository $groceryRepository,
    ) {
    }

    #[Route('/grocery', name: 'grocery_delete', methods: ['delete'])]
    public function __invoke(#[MapQueryString] GroceryDeleteCommandDTO $groceryDeleteDTOCommand): JsonResponse
    {
        $queryBusResponse = $this->commandBus->__invoke(
            $groceryDeleteDTOCommand,
            $this->groceryRepository
        );

        return $this->json($queryBusResponse);
    }
}
