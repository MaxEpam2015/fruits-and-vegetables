<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Grocery;
use App\Repository\GroceryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VegetableTest extends WebTestCase
{

    const URI = '/api/vegetable';
    const TYPE = 'vegetable';


    public function testAddSuccess()
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        $groceryRepository = static::getContainer()->get(GroceryRepository::class);

        $expectedGroceryCount = count($groceryRepository->findAll());
        $data = [
            "name" => "Apple",
            "quantity" => 200,
            "type" => self::TYPE,
        ];

        $client->request(
            'POST',
            self::URI,
            content: json_encode($data)
        );

        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertResponseIsSuccessful();
        $this->assertGreaterThan($expectedGroceryCount, $actualGroceryCount);
    }

    public function testAddInvalidDataFormat()
    {
        $client = static::createClient();

        $groceryRepository = static::getContainer()->get(GroceryRepository::class);

        $expectedGroceryCount = count($groceryRepository->findAll());
        $data = [
            "quantity" => 200,
            "type" => self::TYPE,
        ];
        $client->request(
            'POST',
            self::URI,
            content: json_encode($data)
        );

        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertResponseStatusCodeSame(400);
        $this->assertSame($expectedGroceryCount, $actualGroceryCount);
    }


    public function testAddInvalidQuantityType()
    {
        $client = static::createClient();

        $groceryRepository = static::getContainer()->get(GroceryRepository::class);

        $expectedGroceryCount = count($groceryRepository->findAll());
        $data = [
            "name" => "Apple",
            "quantity" => "invalidType",
            "type" => self::TYPE,
        ];
        $client->request(
            'POST',
            self::URI,
            content: json_encode($data)
        );

        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertResponseStatusCodeSame(400);
        $this->assertSame($expectedGroceryCount, $actualGroceryCount);
    }

    public function testRemoveSuccess()
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        $groceryRepository = static::getContainer()->get(GroceryRepository::class);

        $data = [
            "name" => "Cabbage",
            "quantity" => 200,
            "type" => self::TYPE,
        ];
        $grocery = new Grocery();
        $grocery->setName($data['name']);
        $grocery->setQuantity($data['quantity']);
        $grocery->setType($data['type']);
        $grocery->setUnit($data['unit'] ?? '');
        $groceryRepository->add($grocery);
        $client->request(
            'DELETE',
            self::URI . '/' . $grocery->getId(),
        );

        $this->assertResponseIsSuccessful();
    }

    public function testRemoveNotFoundGrocery()
    {
        $this->expectException(NotFoundHttpException::class);
        $client = static::createClient();
        $client->catchExceptions(false);

        $client->request(
            'DELETE',
            self::URI . '/-1',
        );

        $this->assertResponseStatusCodeSame(404);
    }

    public function testListSuccess()
    {

        $client = static::createClient();
        $client->request(
            'GET',
            self::URI . '/'
        );

        $this->assertResponseIsSuccessful();
    }
}
