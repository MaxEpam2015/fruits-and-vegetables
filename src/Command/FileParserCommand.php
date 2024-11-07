<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\FileParser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'file:parse',
    description: 'Parse file and store data',
    hidden: false
)]
class FileParserCommand extends Command
{
    public function __construct(protected FileParser $fileParser)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyOutput = new SymfonyStyle($input, $output);
        $response = $this->fileParser->perform($symfonyOutput);

        if (false === $response) {
            $symfonyOutput->error('File parsing failed');

            return Command::FAILURE;
        }

        $symfonyOutput->info('File has been parsed successfully');

        return Command::SUCCESS;
    }
}
