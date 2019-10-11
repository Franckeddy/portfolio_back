<?php

namespace App\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(
 *      request="UpdateCompany",
 *      required=true,
 *      @OA\JsonContent(
 *          @OA\Schema(ref="#/components/schemas/Company")
 *      )
 * )
 */
class UpdateCompanyDatas{

}