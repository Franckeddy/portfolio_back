<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="SchoolQuickView",
 *      description="Résume des langues",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name", nullable="true"),
 * )
 * @OA\Schema(
 *      schema="School",
 *      description="Notre Ecole",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name", nullable="true"),
 *      @OA\Property(type="string", format="date-time", property="start_date", nullable="true"),
 *      @OA\Property(type="string", format="date-time", property="end_date", nullable="true"),
 *      @OA\Property(property="formations", @OA\Items(type="array", @OA\Items(ref="#/components/schemas/Formation"))),
 * )
 */
class SchoolNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
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
        return $data instanceof \App\Entity\School;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
