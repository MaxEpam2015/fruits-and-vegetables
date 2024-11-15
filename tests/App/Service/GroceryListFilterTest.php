<?php

declare(strict_types=1);

namespace App\Tests\App\Service;

use App\Dto\Request\GroceryListDto;
use App\Entity\Grocery;
use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Filter\GroceryListFilterService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GroceryListFilterTest extends WebTestCase
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
        $grocery = new GroceryListDto(self::TYPE, 190, 210);
        $groceryListFilterService = static::getContainer()->get(GroceryListFilterService::class);
        $groceryItems = $groceryListFilterService->perform($grocery);
        $this->assertGreaterThan(0, count($groceryItems));
    }
}
