<?php

declare(strict_types=1);

namespace App\Tests\App\Bus\Query;

use App\Application\Command\Grocery\DTO\GroceryDeleteCommandDTO;
use App\Application\Command\Grocery\Handler\GroceryDeleteCommandHandler;
use App\Entity\Grocery;
use App\Repository\GroceryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroceryDeleteTest extends WebTestCase
{
    public const TYPE = 'fruit';

//    protected function setUp(): void
//    {
//        $this->groceryRepository = $this->createMock(GroceryRepository::class);
//    }

    public function testDeleteSuccess(): void
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
        $expectedGroceryCount = count($groceryRepository->findAll());
        $groceryDeleteCommandDTO = new GroceryDeleteCommandDTO($data['type'], $grocery->getId());
        $groceryDeleteCommandHandler = new GroceryDeleteCommandHandler();
        $groceryDeleteCommandHandler->handle($groceryDeleteCommandDTO, $groceryRepository);
        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertLessThan($expectedGroceryCount, $actualGroceryCount);
    }

    public function testDeleteNotFoundGrocery(): void
    {
        $groceryRepository = $this->createMock(GroceryRepository::class);
        $this->expectException(NotFoundHttpException::class);
        $groceryDeleteCommandDTO = new GroceryDeleteCommandDTO(self::TYPE, -1);
        $groceryDeleteCommandHandler = new GroceryDeleteCommandHandler();
        $groceryDeleteCommandHandler->handle($groceryDeleteCommandDTO, $groceryRepository);
    }
}
