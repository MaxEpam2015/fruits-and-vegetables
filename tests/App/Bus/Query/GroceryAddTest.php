<?php

declare(strict_types=1);

namespace App\Tests\App\Bus\Query;

use App\Application\Command\Grocery\DTO\GroceryAddCommandDTO;
use App\Application\Command\Grocery\Handler\GroceryAddCommandHandler;
use App\Domain\Exception\Repository\Grocery\GroceryDTONotFound;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GroceryAddTest extends WebTestCase
{
    public const TYPE = 'fruit';


    /**
     * @throws GroceryDTONotFound
     */
    public function testAddSuccess(): void
    {
        $groceryRepository = static::getContainer()->get(GroceryRepository::class);
        $groceryAddDTOQuery = new GroceryAddCommandDTO('Apple', self::TYPE, 10);
        $groceryAddCommandHandler = new GroceryAddCommandHandler();
        $expectedGroceryCount = count($groceryRepository->findAll());
        $groceryAddCommandHandler->handle($groceryAddDTOQuery, $groceryRepository);
        $actualGroceryCount = count($groceryRepository->findAll());
        $this->assertGreaterThan($expectedGroceryCount, $actualGroceryCount);
    }
}
