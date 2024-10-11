<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Grocery;
use App\Repository\GroceryRepository;
use App\Requests\GroceryRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GroceryService
{

    public function __construct(
        protected GroceryRepository $groceryRepository,
        protected Validator $validator,
    ) {
    }

    public function add(array $data): string
    {
        if (empty($data['name']) || empty($data['type']) || empty($data['quantity'])) {
            throw new BadRequestException('name, type or quantity should not be empty');
        }
        $groceryRequest = new GroceryRequest();
        $groceryRequest->name = $data['name'];
        $groceryRequest->type = $data['type'];
        $groceryRequest->quantity = $data['quantity'];
        $groceryRequest->unit = $data['unit'] ?? null;

        $this->validator->validate($groceryRequest);

        $grocery = new Grocery();
        $grocery->setName($data['name']);
        $grocery->setQuantity($data['quantity']);
        $grocery->setType($data['type']);
        $grocery->setUnit($data['unit'] ?? '');
        $this->groceryRepository->add($grocery);

        return $data['name'] . ' has been added successfully';
    }

    public function remove(int|string $id, string $type): string
    {
        $grocery = $this->groceryRepository->findOneBy(['type' => $type, 'id' => $id]);

        if (!$grocery) {
            throw new NotFoundHttpException(
                'Not found grocery for id '. $id
            );
        }
        $this->groceryRepository->remove($grocery);

        return "Grocery id: {$id}, type: fruit has been removed successfully";
    }
}