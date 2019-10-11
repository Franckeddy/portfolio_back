<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(
 *      request="UpdateCandidat",
 *      required=true,
 *      @OA\JsonContent(
 *          @OA\Schema(ref="#/components/schemas/CandidatQuickView")
 *      )
 * )
 */
class UpdateCandidatDatas{

}