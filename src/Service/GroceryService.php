<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\GroceryAddDto;
use App\Entity\Grocery;
use App\Repository\GroceryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroceryService
{
    public function __construct(
        protected GroceryRepository $groceryRepository,
        protected Validator $validator,
    ) {
    }

    public function add(GroceryAddDto $data): string
    {
        $this->validator->validate($data);
        $grocery = new Grocery();
        $grocery->setName($data->name);
        $grocery->setQuantity($data->quantity);
        $grocery->setType($data->type);
        $grocery->setUnit($data->unit ?? '');
        $this->groceryRepository->add($grocery);

        return $data->name.' has been added successfully';
    }

    public function remove(string $type, int|string $id): string
    {
        $grocery = $this->groceryRepository->findOneBy(['type' => $type, 'id' => $id]);

        if (!$grocery) {
            throw new NotFoundHttpException('Not found grocery for id '.$id);
        }
        $this->groceryRepository->remove($grocery);

        return "Grocery id: {$id}, type: {$type} has been removed successfully";
    }
}
