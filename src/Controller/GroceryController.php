<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Request\GroceryAddDTO;
use App\DTO\Request\GroceryDeleteDTO;
use App\DTO\Request\GroceryListDTO;
use App\DTO\Request\GrocerySearchDTO;
use App\Service\GroceryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
final class GroceryController extends AbstractController
{
    public function __construct(
        protected GroceryService $groceryService,
    ) {
    }

    #[Route('/search', name: 'search', methods: ['get'])]
    public function search(#[MapQueryString] GrocerySearchDTO $grocerySearchDTO): JsonResponse
    {
        $response = $this->groceryService->search($grocerySearchDTO);

        return $this->json($response);
    }

    #[Route('/grocery', name: 'grocery_add', methods: ['post'])]
    public function add(#[MapRequestPayload] GroceryAddDTO $groceryAddDTO): JsonResponse
    {
        $responseMessage = $this->groceryService->add($groceryAddDTO);

        return $this->json($responseMessage);
    }

    #[Route('/grocery/', name: 'grocery_list', methods: ['get'])]
    public function list(#[MapQueryString] GroceryListDTO $groceryListDTO): JsonResponse
    {
        $filteredResults = $this->groceryService->list($groceryListDTO);

        return $this->json($filteredResults);
    }

    #[Route('/grocery', name: 'grocery_delete', methods: ['delete'])]
    public function delete(#[MapQueryString] GroceryDeleteDTO $groceryDeleteDTO): JsonResponse
    {
        $responseMessage = $this->groceryService->delete($groceryDeleteDTO);

        return $this->json($responseMessage);
    }
}
