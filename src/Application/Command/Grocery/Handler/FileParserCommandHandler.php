<?php

declare(strict_types=1);

namespace App\Application\Command\Grocery\Handler;

use App\Application\Command\CommandDTO;
use App\Application\Command\CommandHandler;
use App\Application\Command\Grocery\DTO\FileParserCommandDTO;
use App\Repository\GroceryRepository;

final readonly class FileParserCommandHandler implements CommandHandler
{
    /** @param FileParserCommandDTO $commandDTO */
    public function handle(CommandDTO $commandDTO, GroceryRepository $groceryRepository): string|bool
    {
        $fileContent = file_get_contents($commandDTO->filePath);
        if (false === $fileContent) {
            return 'Unable to read JSON';
        }
        $data = json_decode($fileContent, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            return 'Invalid JSON: '.json_last_error_msg();
        }

        foreach ($data as $key => $item) {
            if ('kg' === $item['unit']) {
                $data[$key]['quantity'] = $this->convertKilogramsToGrams($item['quantity']);
            }
            unset($data[$key]['unit']);
        }
        $groceryRepository->addMultipleItems($data);

        return true;
    }

    public function convertKilogramsToGrams(int $kilograms): int
    {
        return $kilograms * 1000;
    }
}
