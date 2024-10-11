<?php

declare(strict_types=1);

namespace App\Controller;

use App\ChainOfResponsibility\Search\GrocerySearchService;
use App\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class GroceryController extends AbstractController
{
    public function __construct(
        protected GrocerySearchService $grocerySearchService,
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
}