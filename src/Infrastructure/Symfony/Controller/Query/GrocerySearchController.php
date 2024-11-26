<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Query;

use App\Application\Query\Grocery\DTO\GrocerySearchQueryDTO;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;
use App\Infrastructure\QueryBus\GroceryQueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
final class GrocerySearchController extends AbstractController
{
    public function __construct(
        private readonly GroceryQueryBus $queryBus,
        private readonly GroceryRepository $groceryRepository,
    ) {
    }

    #[Route('/search', name: 'search', methods: ['get'])]
    public function search(#[MapQueryString] GrocerySearchQueryDTO $searchDTOQuery): JsonResponse
    {
        $groceryDTO = $this->queryBus->__invoke(
            $searchDTOQuery,
            $this->groceryRepository
        );

        return $this->json($groceryDTO);
    }
}
