<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="LangueQuickView",
 *      description="Résume des langues",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name"),
 * )
 * @OA\Schema(
 *      @OA\Xml(name="Langue"),
 *      schema="Langue",
 *      description="Notre Langue",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="name"),
 *      @OA\Property(type="string", property="level"),
 * )
 */
class LangueNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
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
        return $data instanceof \App\Entity\Langue;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
