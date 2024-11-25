<?php

declare(strict_types=1);

namespace App\Tests\App\Service;

use App\DTO\Request\GroceryAddDTO;
use App\DTO\Request\GroceryDeleteDTO;
use App\DTO\Request\GroceryListDTO;
use App\DTO\Request\GrocerySearchDTO;
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

        $grocery = new GroceryAddDTO('Apple', self::TYPE, 200);
        $groceryService->add($grocery);
        $actualGroceryCount = count($groceryRepository->findAll());
        $this->assertGreaterThan($expectedGroceryCount, $actualGroceryCount);
    }

    public function testDeleteSuccess(): void
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
        $groceryDTO = new GroceryDeleteDTO($data['type'], $grocery->getId());
        $groceryService->delete($groceryDTO);
        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertLessThan($expectedGroceryCount, $actualGroceryCount);
    }

    public function testDeleteNotFoundGrocery(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $groceryService = static::getContainer()->get(GroceryService::class);
        $groceryDTO = new GroceryDeleteDTO('fruit', -1);
        $groceryService->delete($groceryDTO);
    }

    public function testGetListSuccess(): void
    {
        $groceryRepository = static::getContainer()->get(GroceryRepository::class);
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
        $groceryDTO = new GroceryListDTO(self::TYPE, 190, 210);
        $groceryService = static::getContainer()->get(GroceryService::class);
        $groceryItems = $groceryService->list($groceryDTO);
        $this->assertGreaterThan(0, count($groceryItems));
    }

    public function testSearchSuccess(): void
    {
        $groceryRepository = static::getContainer()->get(GroceryRepository::class);
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
        $groceryDTO = new GrocerySearchDTO($data['name'], self::TYPE, 190, 210);
        $groceryService = static::getContainer()->get(GroceryService::class);
        $groceryItems = $groceryService->search($groceryDTO);
        $this->assertGreaterThan(0, count($groceryItems));
    }
}
