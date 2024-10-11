<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Grocery;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class GroceryNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = []): array
    {
        if (!$object instanceof Grocery) {
            return [];
        }

        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'type' => $object->getType(),
            'quantity' => $object->getQuantity(),
            'unit' => $object->getUnit(),
        ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Grocery;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Grocery::class => true,
        ];
    }
}