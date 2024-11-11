<?php

declare(strict_types=1);

namespace App\Tests\App\Service;

use App\Dto\GroceryAddDto;
use App\Service\Validator;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorTest extends TestCase
{
    private ValidatorInterface $validatorMock;
    private LoggerInterface $loggerMock;
    private Validator $service;

    protected function setUp(): void
    {
        $this->validatorMock = $this->createMock(ValidatorInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->service = new Validator($this->validatorMock, $this->loggerMock);
    }

    public function testValidateSuccess(): void
    {
        $dto = new GroceryAddDto('Apple', 'fruit', 100);
        $this->validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($dto)
            ->willReturn(new ConstraintViolationList());

        $this->service->validate($dto);
        $this->assertTrue(true);
    }

    public function testValidateFailure(): void
    {
        $violation = new ConstraintViolation(
            'This value should not be blank.',
            null,
            [],
            '',
            'name',
            null
        );
        $violations = new ConstraintViolationList([$violation]);

        $dto = new GroceryAddDto('Apple', 'fruit', 100);
        $this->validatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($dto)
            ->willReturn($violations);

        $this->loggerMock
            ->expects($this->once())
            ->method('error')
            ->with((string) $violations);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage(json_encode(['name: This value should not be blank.']));

        $this->service->validate($dto);
    }
}
