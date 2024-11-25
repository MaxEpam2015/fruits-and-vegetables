<?php

declare(strict_types=1);

namespace App\Tests\App\Controller;

use App\Entity\Grocery;
use App\Repository\GroceryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GroceryTest extends WebTestCase
{
    public const TYPE = 'fruit';

    public function testAddSuccess(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);
        $groceryRepository = static::getContainer()->get(GroceryRepository::class);
        $urlGenerator = self::getContainer()->get(UrlGeneratorInterface::class);
        $url = $urlGenerator->generate('api_grocery_add', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $expectedGroceryCount = count($groceryRepository->findAll());
        $data = [
            'name' => 'Apple',
            'quantity' => 200,
            'type' => self::TYPE,
        ];

        $client->request(
            'POST',
            $url,
            $data
        );

        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertResponseIsSuccessful();
        $this->assertGreaterThan($expectedGroceryCount, $actualGroceryCount);
    }

    public function testAddInvalidDataFormat(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        $groceryRepository = static::getContainer()->get(GroceryRepository::class);
        $urlGenerator = self::getContainer()->get(UrlGeneratorInterface::class);
        $url = $urlGenerator->generate('api_grocery_add', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $expectedGroceryCount = count($groceryRepository->findAll());
        $data = [
            'quantity' => 200,
            'type' => self::TYPE,
        ];
        $this->expectException(UnprocessableEntityHttpException::class);
        $client->request(
            'POST',
            $url,
            $data
        );

        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame($expectedGroceryCount, $actualGroceryCount);
    }

    public function testAddInvalidQuantityType(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        $groceryRepository = static::getContainer()->get(GroceryRepository::class);

        $urlGenerator = self::getContainer()->get(UrlGeneratorInterface::class);
        $url = $urlGenerator->generate('api_grocery_add', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $expectedGroceryCount = count($groceryRepository->findAll());
        $data = [
            'name' => 'Apple',
            'quantity' => 'invalidType',
            'type' => self::TYPE,
        ];
        $this->expectException(UnprocessableEntityHttpException::class);
        $client->request(
            'POST',
            $url,
            $data
        );

        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame($expectedGroceryCount, $actualGroceryCount);
    }

    public function testDeleteSuccess(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        $groceryRepository = static::getContainer()->get(GroceryRepository::class);

        $urlGenerator = self::getContainer()->get(UrlGeneratorInterface::class);

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

        $url = $urlGenerator->generate('api_grocery_delete', ['type' => $grocery->getType(), 'id' => $grocery->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        $client->request(
            'DELETE',
            $url
        );

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteNotFoundGrocery(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $client = static::createClient();
        $client->catchExceptions(false);

        $urlGenerator = self::getContainer()->get(UrlGeneratorInterface::class);
        $url = $urlGenerator->generate('api_grocery_delete', ['type' => 'fruit', 'id' => -1], UrlGeneratorInterface::ABSOLUTE_URL);

        $client->request(
            'DELETE',
            $url
        );

        $this->assertResponseStatusCodeSame(404);
    }

    public function testListSuccess(): void
    {
        $client = static::createClient();

        $urlGenerator = self::getContainer()->get(UrlGeneratorInterface::class);
        $url = $urlGenerator->generate('api_grocery_list', ['type' => 'fruit'], UrlGeneratorInterface::ABSOLUTE_URL);

        $client->request(
            'GET',
            $url
        );

        $this->assertResponseIsSuccessful();
    }
}
