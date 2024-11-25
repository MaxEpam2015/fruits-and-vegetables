<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Request\GroceryAddDTO;
use App\DTO\Request\GroceryDeleteDTO;
use App\DTO\Request\GroceryListDTO;
use App\DTO\Request\GrocerySearchDTO;
use App\Entity\Grocery;
use App\Repository\GroceryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroceryService
{
    public function __construct(
        protected GroceryRepository $groceryRepository,
    ) {
    }

    public function add(GroceryAddDTO $groceryAddDTO): string
    {
        if (null === $groceryAddDTO->type) {
            throw new NotFoundHttpException($groceryAddDTO->type);
        }

        $grocery = new Grocery();
        $grocery->setName($groceryAddDTO->name);
        $grocery->setQuantity($groceryAddDTO->quantity);
        $grocery->setType($groceryAddDTO->type);
        $grocery->setUnit($groceryAddDTO->unit ?? '');
        $this->groceryRepository->add($grocery);

        return $groceryAddDTO->name.' has been added successfully';
    }

    public function delete(GroceryDeleteDTO $groceryDeleteDTO): string
    {
        /** @var Grocery $grocery */
        $grocery = $this->groceryRepository->findOneBy(['type' => $groceryDeleteDTO->type, 'id' => $groceryDeleteDTO->id]);

        if (!$grocery) {
            throw new NotFoundHttpException('Not found grocery for id '.$groceryDeleteDTO->id);
        }
        $this->groceryRepository->delete($grocery);

        return "Grocery id: {$groceryDeleteDTO->id}, type: {$groceryDeleteDTO->type} has been deleted successfully";
    }

    public function list(GroceryListDTO $groceryListDTO): array
    {
        if (null === $groceryListDTO->type) {
            throw new NotFoundHttpException($groceryListDTO->type);
        }

        return $this->groceryRepository->getGroceriesList($groceryListDTO->type, $groceryListDTO->minQuantity, $groceryListDTO->maxQuantity);
    }

    public function search(GrocerySearchDTO $grocerySearchDTO): array
    {
        return $this->groceryRepository->search($grocerySearchDTO->name, $grocerySearchDTO->type, $grocerySearchDTO->minQuantity, $grocerySearchDTO->maxQuantity);
    }
}
