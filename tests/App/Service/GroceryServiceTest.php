<?php

declare(strict_types=1);

namespace App\Tests\App\Service;

use App\Dto\Request\GroceryAddDto;
use App\Entity\Grocery;
use App\Repository\GroceryRepository;
use App\Service\GroceryService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroceryServiceTest extends WebTestCase
{
    public const TYPE = 'fruit';

    public function testAddSuccess(): void
    {
        $groceryRepository = static::getContainer()->get(GroceryRepository::class);
        $groceryService = static::getContainer()->get(GroceryService::class);
        $expectedGroceryCount = count($groceryRepository->findAll());

        $grocery = new GroceryAddDto('Apple', self::TYPE, 200);
        $groceryService->add($grocery);
        $actualGroceryCount = count($groceryRepository->findAll());
        $this->assertGreaterThan($expectedGroceryCount, $actualGroceryCount);
    }

    public function testRemoveSuccess(): void
    {
        $groceryRepository = static::getContainer()->get(GroceryRepository::class);
        $groceryService = static::getContainer()->get(GroceryService::class);
        $data = [
            'name' => 'Apple',
            'quantity' => 200,
            'type' => self::TYPE,
            'unit' => 'kg',
        ];
        $grocery = new Grocery();
        $grocery->setName($data['name']);
        $grocery->setQuantity($data['quantity']);
        $grocery->setType($data['type']);
        $grocery->setUnit($data['unit']);
        $groceryRepository->add($grocery);
        $expectedGroceryCount = count($groceryRepository->findAll());
        $groceryService->remove($data['type'], $grocery->getId());
        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertLessThan($expectedGroceryCount, $actualGroceryCount);
    }

    public function testRemoveNotFoundGrocery(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $groceryService = static::getContainer()->get(GroceryService::class);
        $groceryService->remove('fruit', -1);
    }
}
