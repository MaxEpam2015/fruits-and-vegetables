<?php

declare(strict_types=1);

namespace App\Controller;

use App\ChainOfResponsibility\Filter\GroceryListFilterService;
use App\Interfaces\GroceryCrudInterface;
use App\Response\ApiResponse;
use App\Service\GroceryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class FruitController extends AbstractController implements GroceryCrudInterface
{
    public function __construct(
        protected GroceryListFilterService $groceryListFilterService,
        protected GroceryService $fruitService,
    ) {
    }

    #[Route('/fruit', name: 'fruit_add', methods:['post'] )]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Empty JSON'], 400);
        }
        $responseMessage = $this->fruitService->add($data);
        $apiResponse = new ApiResponse('Success', message: $responseMessage);

        return $this->json($apiResponse->toArray());
    }

    #[Route('/fruit/', name: 'fruit_list', methods:['get'])]
    public function list(Request $request): JsonResponse
    {
        $criteria = [
            'type' => 'fruit',
            'minQuantity' => $request->query->get('minQuantity'),
            'maxQuantity' => $request->query->get('maxQuantity'),
        ];
        $filteredResults = $this->groceryListFilterService->perform($criteria);
        $apiResponse = new ApiResponse('Success', data: $filteredResults);

        return $this->json($apiResponse->toArray());
    }

    #[Route('/fruit/{id}', name: 'fruit_delete', methods:['delete'])]
    public function remove(int $id): JsonResponse
    {
        $responseMessage = $this->fruitService->remove($id, 'fruit');
        $apiResponse = new ApiResponse('Success', message: $responseMessage);

        return $this->json($apiResponse->toArray());
    }
}