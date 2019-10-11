<?php

namespace App\DTO;

use OpenApi\Annotations as OA;


/**
 * @OA\RequestBody(
 *      request="UpdateLangue",
 *      required=true,
 *      @OA\JsonContent(
 *          @OA\Schema(ref="#/components/schemas/Langue")
 *      )
 * )
 */
class UpdateLangueDatas{

}