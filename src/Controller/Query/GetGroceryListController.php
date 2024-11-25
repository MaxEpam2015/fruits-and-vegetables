<?php

declare(strict_types=1);

namespace App\Controller\Query;

use App\Application\Query\Grocery\DTO\GetGroceryListQueryDTO;
use App\Infrastructure\QueryBus\GroceryQueryBus;
use App\Repository\GroceryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
final class GetGroceryListController extends AbstractController
{
    public function __construct(
        private readonly GroceryQueryBus $queryBus,
        private readonly GroceryRepository $groceryRepository,
    ) {
    }

    #[Route('/grocery', name: 'grocery_list', methods: ['get'])]
    public function __invoke(
        #[MapQueryString] GetGroceryListQueryDTO $getGroceryListDTOQuery,
    ): JsonResponse {
        $queryBusResponse = $this->queryBus->__invoke(
            $getGroceryListDTOQuery,
            $this->groceryRepository
        );

        return $this->json($queryBusResponse);
    }
}
