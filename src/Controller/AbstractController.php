<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 * 			name="id",
 * 			in="path",
 * 			description="ID du candidat",
 * 			required=true,
 * 			@OA\Schema(type="integer")
 * )
 * 
 * 
 * @OA\Response(
 *          response="NotFound",
 *          description="la resource n'existe pas",
 *          @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="le candidat n'éxiste pas"),
 *          )
 * )
 */
class AbstractController extends AbstractController
{

}
