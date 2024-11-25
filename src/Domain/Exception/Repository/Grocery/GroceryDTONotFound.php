<?php

declare(strict_types=1);

namespace App\Domain\Exception\Repository\Grocery;

use App\Domain\Exception\Repository\NotFound;

final class GroceryDTONotFound extends \Exception implements NotFound
{
    public static function withGroceryType(string $type): self
    {
        return new self(
            sprintf(
                'Grocery with type "%s" not found',
                $type,
            )
        );
    }
}
