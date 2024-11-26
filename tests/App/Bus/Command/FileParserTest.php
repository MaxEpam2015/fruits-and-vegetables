<?php

namespace App\Tests\App\Bus\Command;

use App\Application\Command\Grocery\DTO\FileParserCommandDTO;
use App\Application\Command\Grocery\Handler\FileParserCommandHandler;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FileParserTest extends KernelTestCase
{
    private MockObject|GroceryRepository $groceryRepository;

    protected function setUp(): void
    {
        $this->groceryRepository = $this->createMock(GroceryRepository::class);
    }

    public function testHandleWithValidData(): void
    {
        self::bootKernel();
        $projectRoot = self::$kernel->getProjectDir();
        $this->groceryRepository
            ->expects($this->once())
            ->method('addMultipleItems');
        $fileParserCommandHandler = new FileParserCommandHandler();
        $fileParserCommand = new FileParserCommandDTO($projectRoot.'/request.json');
        $this->assertTrue($fileParserCommandHandler->handle($fileParserCommand, $this->groceryRepository));
    }

    public function testConverter(): void
    {
        $fileParserCommandHandler = static::getContainer()->get(FileParserCommandHandler::class);
        $twoKilogramsAsNumber = 2;
        $grams = $fileParserCommandHandler->convertKilogramsToGrams($twoKilogramsAsNumber);
        $this->assertIsInt($grams);
        $this->assertGreaterThan($twoKilogramsAsNumber, $grams);
        $this->assertSame($grams, 2000);
    }

    public function testHandleWithInvalidJson(): void
    {
        $invalidJsonFile = tempnam(sys_get_temp_dir(), 'invalid_json');
        file_put_contents($invalidJsonFile, '{invalid json...');
        $fileParserCommandHandler = new FileParserCommandHandler();
        $fileParserCommand = new FileParserCommandDTO($invalidJsonFile);
        $this->assertSame('Invalid JSON: Syntax error', $fileParserCommandHandler->handle($fileParserCommand, $this->groceryRepository));
        unlink($invalidJsonFile);
    }
}
