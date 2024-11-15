<?php

declare(strict_types=1);

namespace App\Tests\App\Service;

use App\Dto\Request\GrocerySearchDto;
use App\Entity\Grocery;
use App\Repository\GroceryRepository;
use App\Service\ChainOfResponsibility\Search\GrocerySearchService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GrocerySearchTest extends WebTestCase
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
        $grocery = new GrocerySearchDto($data['name'], self::TYPE, 190, 210);
        $grocerySearchService = static::getContainer()->get(GrocerySearchService::class);
        $groceryItems = $grocerySearchService->perform($grocery);
        $this->assertGreaterThan(0, count($groceryItems));
    }
}
