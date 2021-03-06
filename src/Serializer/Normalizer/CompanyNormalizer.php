<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="CompanyQuickView",
 *      description="Résume des Entreprises",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name"),
 * )
 * @OA\Schema(
 *      schema="Company",
 *      description="Notre Entreprise",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name"),
 *      @OA\Property(type="string", format="date-time", property="start_date"),
 *      @OA\Property(type="string", format="date-time", property="end_date"),
 *      @OA\Property(property="activityAreas", @OA\Items(type="array", @OA\Items(ref="#/components/schemas/Activity"))),
 * )
 */
class CompanyNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
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
        return $data instanceof \App\Entity\Company;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
