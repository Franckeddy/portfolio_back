<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="LicenseQuickView",
 *      description="Résume des licenses",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name"),
 * )
 * @OA\Schema(
 *      schema="License",
 *      description="Notre Permis",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name"),
 *      @OA\Property(type="string", format="date-time", property="date_obtention"),
 * )
 */
class LicenseNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    private $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($object, $format = null, array $context = array()): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        // Here: add, edit, or delete some data

        return $data;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof \App\Entity\License;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
