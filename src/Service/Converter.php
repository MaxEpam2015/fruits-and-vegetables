<?php

declare(strict_types=1);

namespace App\Service;

final class Converter
{

    public function convertKilogramsToGrams(int $kilograms): int
    {
        return $kilograms * 1000;
    }
}