<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\GroceryAddDto;
use App\Response\ApiResponse;
use App\Service\ChainOfResponsibility\Filter\GroceryListFilterService;
use App\Service\ChainOfResponsibility\Search\GrocerySearchService;
use App\Service\GroceryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'api_')]
final class GroceryController extends AbstractController
{
    public function __construct(
        protected GrocerySearchService $grocerySearchService,
        protected GroceryListFilterService $groceryListFilterService,
        protected GroceryService $groceryService,
        protected SerializerInterface $serializer
    ) {
    }

    #[Route('/search', name: 'search', methods:['get'] )]
    public function search(Request $request): JsonResponse
    {
        $filters = [
            'name' => $request->query->get('name'),
            'type' => $request->query->get('type'),
            'minQuantity' => $request->query->get('minQuantity'),
            'maxQuantity' => $request->query->get('maxQuantity'),
        ];
        $response = $this->grocerySearchService->perform($filters);
        $apiResponse = new ApiResponse('Success', data: $response);

        return $this->json($apiResponse->toArray());
    }

    #[Route('/grocery', name: 'grocery_add', methods:['post'] )]
    public function add(
        #[MapRequestPayload] GroceryAddDto $groceryAddDto
    ): JsonResponse
    {
        $responseMessage = $this->groceryService->add($groceryAddDto);
        $apiResponse = new ApiResponse('Success', message: $responseMessage);

        return $this->json($apiResponse->toArray());
    }

    #[Route('/grocery/', name: 'grocery_list', methods:['get'])]
    public function list(Request $request): JsonResponse
    {
        $criteria = [
            'type' => $request->query->get('type'),
            'minQuantity' => $request->query->get('minQuantity'),
            'maxQuantity' => $request->query->get('maxQuantity'),
        ];
        $filteredResults = $this->groceryListFilterService->perform($criteria);
        $apiResponse = new ApiResponse('Success', data: $filteredResults);

        return $this->json($apiResponse->toArray());
    }

    #[Route('/grocery/{type}/{id}', name: 'grocery_delete', methods:['delete'])]
    public function remove(string $type, int $id): JsonResponse
    {
        $responseMessage = $this->groceryService->remove($type, $id);
        $apiResponse = new ApiResponse('Success', message: $responseMessage);

        return $this->json($apiResponse->toArray());
    }
}