<?php

declare(strict_types=1);

namespace App\Tests\App\Bus\Command;

use App\Application\Query\Grocery\DTO\GetGroceryListQueryDTO;
use App\Application\Query\Grocery\Handler\GetGroceryListHandler;
use App\Domain\Entity\Grocery;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetGroceryListTest extends WebTestCase
{
    public const TYPE = 'fruit';

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
        $groceryListDTOQuery = new GetGroceryListQueryDTO(self::TYPE, 190, 210);
        $getGroceryListHandler = new GetGroceryListHandler();
        $groceryItems = $getGroceryListHandler->handle($groceryListDTOQuery, $groceryRepository);
        $this->assertGreaterThan(0, count($groceryItems));
    }
}
