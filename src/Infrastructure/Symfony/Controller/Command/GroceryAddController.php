<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Command;

use App\Application\Command\Grocery\DTO\GroceryAddCommandDTO;
use App\Infrastructure\CommandBus\GroceryCommandBus;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
final class GroceryAddController extends AbstractController
{
    public function __construct(
        private readonly GroceryCommandBus $commandBus,
        private readonly GroceryRepository $groceryRepository,
    ) {
    }

    #[Route('/grocery', name: 'grocery_add', methods: ['post'])]
    public function __invoke(#[MapRequestPayload] GroceryAddCommandDTO $groceryAddDTOCommand): JsonResponse
    {
        $queryBusResponse = $this->commandBus->__invoke(
            $groceryAddDTOCommand,
            $this->groceryRepository
        );

        return $this->json($queryBusResponse);
    }
}
