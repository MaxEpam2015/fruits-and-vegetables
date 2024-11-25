<?php

declare(strict_types=1);

namespace App\Application\Command\Grocery\DTO;

use App\Application\Command\CommandDTO;

final readonly class FileParserCommandDTO implements CommandDTO
{
    public function __construct(
        public string $filePath,
    ) {
    }
}
