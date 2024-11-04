<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GroceryAddDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type("string")]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Type("string")]
        public string $type,

        #[Assert\NotBlank]
        #[Assert\Type("integer")]
        #[Assert\Positive]
        public int $quantity,
    ) {
    }
}
