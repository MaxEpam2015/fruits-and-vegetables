<?php

namespace App\Tests\App\Service;

use App\Service\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    public function testConverter(): void
    {
        $converter = new Converter();
        $twoKilogramsAsNumber = 2;
        $grams = $converter->convertKilogramsToGrams($twoKilogramsAsNumber);
        $this->assertIsInt($grams);
        $this->assertGreaterThan($twoKilogramsAsNumber, $grams);
        $this->assertSame($grams, 2000);
    }
}
