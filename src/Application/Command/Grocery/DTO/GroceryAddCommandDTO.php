<?php

declare(strict_types=1);

namespace App\Application\Command\Grocery\DTO;

use App\Application\Command\CommandDTO;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class GroceryAddCommandDTO implements CommandDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public string $type,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public int $quantity,
    ) {
    }
}
