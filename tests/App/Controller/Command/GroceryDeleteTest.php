<?php

declare(strict_types=1);

namespace App\Tests\App\Controller\Command;

use App\Domain\Entity\Grocery;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GroceryDeleteTest extends WebTestCase
{
    public const TYPE = 'fruit';

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
}
