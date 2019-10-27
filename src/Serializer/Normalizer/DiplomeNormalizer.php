<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="DiplomeQuickView",
 *      description="Résume des Diplomes",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name"),
 * )
 * @OA\Schema(
 *      schema="Diplome",
 *      description="Notre Diplome",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name"),
 *      @OA\Property(type="string", property="level"),
 *      @OA\Property(type="string", format="date-time", property="date_obtention"),
 * )
 */
class DiplomeNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
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
        return $data instanceof \App\Entity\Diplome;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
