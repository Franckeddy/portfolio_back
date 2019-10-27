<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="FormationQuickView",
 *      description="Résume des Formations",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name"),
 * )
 * @OA\Schema(
 *      schema="Formation",
 *      description="Notre Formation",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name"),
 *      @OA\Property(type="string", format="date-time", property="start_date"),
 *      @OA\Property(type="string", format="date-time", property="end_date"),
 *      @OA\Property(property="diplomes", @OA\Items(type="array", @OA\Items(ref="#/components/schemas/Diplome"))),
 * )
 */
class FormationNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
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
        return $data instanceof \App\Entity\Formation;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
