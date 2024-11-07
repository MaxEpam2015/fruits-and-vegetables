<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\GroceryRepository;
use Symfony\Component\Console\Style\SymfonyStyle;

class FileParser
{
    public function __construct(
        protected GroceryRepository $groceryRepository,
        protected Converter $converter,
        protected string $filePath,
    ) {
    }

    public function perform(SymfonyStyle $symfonyOutput): bool
    {
        $fileContent = file_get_contents($this->filePath);
        if (false === $fileContent) {
            $symfonyOutput->error('Unable to read JSON');

            return false;
        }
        $data = json_decode($fileContent, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            $symfonyOutput->error('Invalid JSON: '.json_last_error_msg());

            return false;
        }

        foreach ($data as $key => $item) {
            if ('kg' === $item['unit']) {
                $data[$key]['quantity'] = $this->converter->convertKilogramsToGrams($item['quantity']);
            }
            unset($data[$key]['unit']);
        }
        $this->groceryRepository->addMultipleItems($data);

        return true;
    }
}
