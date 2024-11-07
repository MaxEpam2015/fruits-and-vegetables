<?php

namespace App\Tests\App\Service;

use App\Repository\GroceryRepository;
use App\Service\Converter;
use App\Service\FileParser;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Style\SymfonyStyle;

class FileParserTest extends KernelTestCase
{
    private MockObject|GroceryRepository $groceryRepository;
    private MockObject|Converter $converter;

    protected function setUp(): void
    {
        $this->groceryRepository = $this->createMock(GroceryRepository::class);
        $this->converter = $this->createMock(Converter::class);
    }

    public function testPerformWithValidData(): void
    {
        self::bootKernel();
        $projectRoot = self::$kernel->getProjectDir();
        $fileParser = new FileParser($this->groceryRepository, $this->converter, $projectRoot.'/request.json');
        $symfonyOutput = $this->createMock(SymfonyStyle::class);
        $this->groceryRepository
            ->expects($this->once())
            ->method('addMultipleItems');

        $this->assertTrue($fileParser->perform($symfonyOutput));
    }

    public function testPerformWithInvalidJson(): void
    {
        $symfonyOutput = $this->createMock(SymfonyStyle::class);
        $invalidJsonFile = tempnam(sys_get_temp_dir(), 'invalid_json');
        file_put_contents($invalidJsonFile, '{invalid json...');
        $fileParser = new FileParser($this->groceryRepository, $this->converter, $invalidJsonFile);
        $symfonyOutput->expects($this->once())->method('error')->with('Invalid JSON: Syntax error');
        $this->assertFalse($fileParser->perform($symfonyOutput));
        unlink($invalidJsonFile);
    }
}
