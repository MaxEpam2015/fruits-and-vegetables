<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Infrastructure\Doctrine\Repository\GroceryRepository;

interface CommandHandler
{
    public function handle(CommandDTO $commandDTO, GroceryRepository $groceryRepository): mixed;
}
