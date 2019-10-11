<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(
 *      request="UpdateLicense",
 *      required=true,
 *      @OA\JsonContent(
 *          @OA\Schema(ref="#/components/schemas/Permis")
 *      )
 * )
 */
class UpdateLicenseDatas{

}