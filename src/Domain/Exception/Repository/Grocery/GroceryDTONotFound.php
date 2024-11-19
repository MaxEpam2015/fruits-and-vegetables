<?php

declare(strict_types=1);

namespace App\Domain\Exception\Repository\Grocery;

use App\Domain\ValueObject\Grocery\Type;

final class GroceryDTONotFound extends \Exception
{
    public static function withGroceryType(Type $groceryType): self
    {
        return new self(
            sprintf(
                'Grocery with type "%s" not found',
                $groceryType,
            )
        );
    }
}
