<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\Query\Grocery\GetGroceryDTOByTypeQuery;
use App\Application\Query\Query;
//use App\Domain\DTO\Grocery\GroceryDTO;
use App\Infrastructure\QueryBus\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class GetGroceryController extends AbstractController
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    //    #[Route('/grocery/list', name: 'grocery_list', methods: ['get'])]
    //    public function grocery_list(
    //        #[MapQueryString] GetGroceryDTOByTypeQuery $groceryDTO,
    //    ): Response {
    //        /** @var Query $groceryDTO */
    //        $groceryList = $this->queryBus->__invoke(
    //            $groceryDTO
    //        );
    //
    //        return new JsonResponse(
    //            $groceryList
    //        );
    //    }

    #[Route('/grocery/list', name: 'grocery_list', methods: ['get'])]
//    /** @return list<GroceryDTO> */
    public function grocery_list(
        #[MapQueryString] GetGroceryDTOByTypeQuery $groceryDTO,
    ): array {
        return $this->queryBus->__invoke(
            $groceryDTO
//            new GetGroceryDTOByTypeQuery($groceryDTO->type, $groceryDTO->minQuantity, $groceryDTO->maxQuantity)
        );
    }
}
