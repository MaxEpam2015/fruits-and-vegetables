<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Subscriber;

use App\Domain\Exception\Repository\NotFound;
use App\Domain\Exception\ValueObject\InvalidValueObject;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class ExceptionResponseSubscriber implements EventSubscriberInterface
{
    private const EXCEPTION_RESPONSE_HTTP_CODE_MAP = [
        NotFound::class => Response::HTTP_NOT_FOUND,
        InvalidValueObject::class => Response::HTTP_UNPROCESSABLE_ENTITY,
    ];

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => ['__invoke']];
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        $response = new JsonResponse(
            [
                'error' => $throwable->getMessage(),
            ],
            $this->httpCode($throwable),
            [
                'Content-Type' => 'application/json',
            ]
        );

        $event->setResponse($response);
    }

    private function httpCode(\Throwable $throwable): int
    {
        /** @var class-string[] $interfaces */
        $interfaces = class_implements($throwable);

        foreach ($interfaces as $interface) {
            if (array_key_exists($interface, self::EXCEPTION_RESPONSE_HTTP_CODE_MAP)) {
                return self::EXCEPTION_RESPONSE_HTTP_CODE_MAP[$interface];
            }
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
