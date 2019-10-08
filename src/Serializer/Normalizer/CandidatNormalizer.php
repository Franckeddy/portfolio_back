<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *      schema="Candidat",
 *      description="Notre Candidat",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="firstname", nullable="true"),
 *      @OA\Property(type="string", property="lastname", nullable="true"),
 *      @OA\Property(type="string", property="adress", nullable="true"),
 *      @OA\Property(type="string", property="town", nullable="true"),
 *      @OA\Property(type="integer", property="zipcode", nullable="true"),
 *      @OA\Property(type="string", property="email", nullable="true"),
 *      @OA\Property(type="string", format="date-time", property="date_of_birth", nullable="true"),
 * )
 * @OA\Schema(
 *      schema="CandidatSingle",
 *      description="Notre Candidat",
 *      allOf={@OA\Schema(ref="#/components/schemas/Candidat")}
 * )
 */
class CandidatNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
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
        return $data instanceof \App\Entity\BlogPost;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
