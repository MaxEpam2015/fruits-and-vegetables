<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\GroceryAddDto;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Validator\Validator\ValidatorInterface;


readonly class Validator
{
    public function __construct(
        private ValidatorInterface $validator,
        private LoggerInterface $logger
    ) {
    }

    public function validate(GroceryAddDto $data): void
    {
        $errors = $this->validator->validate($data);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            $this->logger->error($errorsString);
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }

            throw new BadRequestException(json_encode($errorMessages));
        }
    }
}