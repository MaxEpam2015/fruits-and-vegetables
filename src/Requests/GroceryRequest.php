<?php

declare(strict_types=1);

namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class GroceryRequest
{
    #[Assert\NotBlank]
    #[Assert\Type("string")]
    public $name;

    #[Assert\NotBlank]
    #[Assert\Type("string")]
    public $type;

    #[Assert\NotBlank]
    #[Assert\Type("integer")]
    #[Assert\Positive]
    public $quantity;

//    #[Assert\NotBlank]
//    #[Assert\IsNull]
    #[Assert\Type(type: ['string', 'null'])]
    public $unit;

}