<?php

declare(strict_types=1);

namespace App\Tests\App\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Exception\NamespaceNotFoundException;
use Symfony\Component\Console\Tester\CommandTester;

class FileParserTest extends KernelTestCase
{
    public function testExecuteSuccess(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('file:parse');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('File has been parsed successfully', $output);
    }

    public function testExecuteWrongCommand(): void
    {
        $this->expectException(NamespaceNotFoundException::class);

        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('wrong:command');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
    }
}
