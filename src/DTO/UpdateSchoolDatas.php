<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(
 *      request="UpdateSchool",
 *      required=true,
 *      @OA\JsonContent(
 *          @OA\Schema(ref="#/components/schemas/School")
 *      )
 * )
 */
class UpdateSchoolDatas{

}