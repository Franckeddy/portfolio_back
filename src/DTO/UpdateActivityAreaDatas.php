<?php

namespace App\DTO;

use OpenApi\Annotations as OA;


/**
 * @OA\RequestBody(
 *      request="UpdateActivityArea",
 *      required=true,
 *      @OA\JsonContent(
 *          @OA\Schema(ref="#/components/schemas/Secteur d'acivité")
 *      )
 * )
 */
class UpdateActivityAreaDatas{

}