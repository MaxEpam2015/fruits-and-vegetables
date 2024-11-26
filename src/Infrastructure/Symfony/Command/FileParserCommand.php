<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Application\Command\CommandDTO as CommandInterface;
use App\Infrastructure\CommandBus\GroceryCommandBus;
use App\Infrastructure\Doctrine\Repository\GroceryRepository;
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
final class FileParserCommand extends Command
{
    public function __construct(
        protected GroceryCommandBus $commandBus,
        protected CommandInterface $command,
        protected GroceryRepository $groceryRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyOutput = new SymfonyStyle($input, $output);
        $response = $this->commandBus->__invoke(
            $this->command,
            $this->groceryRepository
        );
        if (is_string($response)) {
            $symfonyOutput->error($response);

            return Command::FAILURE;
        }

        $symfonyOutput->info('File has been parsed successfully');

        return Command::SUCCESS;
    }
}
