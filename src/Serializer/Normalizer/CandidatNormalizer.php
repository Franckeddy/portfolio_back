<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Candidat",
 *      description="Notre Candidat en détail",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="firstname", nullable="true"),
 *      @OA\Property(type="string", property="lastname", nullable="true"),
 *      @OA\Property(type="string", property="adress", nullable="true"),
 *      @OA\Property(type="string", property="town", nullable="true"),
 *      @OA\Property(type="integer", property="zipcode", nullable="true"),
 *      @OA\Property(type="string", property="email", nullable="true"),
 *      @OA\Property(type="string", format="date-time", property="date_of_birth", nullable="true"),
 *      @OA\Property(type="string", property="short_description", nullable="true"),
 *      @OA\Property(property="langues", @OA\Items(type="array", @OA\Items(ref="#/components/schemas/Langue"))),
 *      @OA\Property(property="licenses", @OA\Items(type="array", @OA\Items(ref="#/components/schemas/Permis"))),
 *      @OA\Property(property="schools", @OA\Items(type="array", @OA\Items(ref="#/components/schemas/Ecole"))),
 *      @OA\Property(property="companies", @OA\Items(type="array", @OA\Items(ref="#/components/schemas/Company"))),
 * )
 * @OA\Schema(
 *      schema="CandidatQuickView",
 *      description="Notre Candidat en résumé",
 *      @OA\Property(type="integer", property="id"),
 *      @OA\Property(type="string", property="firstname", nullable="true"),
 *      @OA\Property(type="string", property="lastname", nullable="true"),
 *      @OA\Property(type="string", property="short_description", nullable="true"),
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
