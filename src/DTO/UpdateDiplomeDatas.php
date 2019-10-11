<?php

namespace App\DTO;

use OpenApi\Annotations as OA;


/**
 * @OA\RequestBody(
 *      request="UpdateDiplome",
 *      required=true,
 *      @OA\JsonContent(
 *          @OA\Schema(ref="#/components/schemas/Diplome")
 *      )
 * )
 */
class UpdateDiplomeDatas{

}