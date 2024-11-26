<?php

declare(strict_types=1);

namespace App\Tests\App\Controller\Command;

use App\Infrastructure\Doctrine\Repository\GroceryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GroceryAddTest extends WebTestCase
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

        $groceryRepository = static::getContainer()->get(GroceryRepository::class);
        $urlGenerator = self::getContainer()->get(UrlGeneratorInterface::class);
        $url = $urlGenerator->generate('api_grocery_add', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $expectedGroceryCount = count($groceryRepository->findAll());
        $data = [
            'quantity' => 200,
            'type' => self::TYPE,
        ];
        $client->request(
            'POST',
            $url,
            $data
        );

        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertResponseStatusCodeSame(500);
        $this->assertSame($expectedGroceryCount, $actualGroceryCount);
    }

    public function testAddInvalidQuantityType(): void
    {
        $client = static::createClient();

        $groceryRepository = static::getContainer()->get(GroceryRepository::class);

        $urlGenerator = self::getContainer()->get(UrlGeneratorInterface::class);
        $url = $urlGenerator->generate('api_grocery_add', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $expectedGroceryCount = count($groceryRepository->findAll());
        $data = [
            'name' => 'Apple',
            'quantity' => 'invalidType',
            'type' => self::TYPE,
        ];
        $client->request(
            'POST',
            $url,
            $data
        );

        $actualGroceryCount = count($groceryRepository->findAll());

        $this->assertResponseStatusCodeSame(500);
        $this->assertSame($expectedGroceryCount, $actualGroceryCount);
    }
}