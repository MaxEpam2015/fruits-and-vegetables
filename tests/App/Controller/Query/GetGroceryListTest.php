<?php

declare(strict_types=1);

namespace App\Tests\App\Controller\Query;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GetGroceryListTest extends WebTestCase
{
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
