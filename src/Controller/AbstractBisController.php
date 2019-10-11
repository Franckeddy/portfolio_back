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
 * @OA\Response(
 *          response="201 - CREATED",
 *          description="Successful creation occurred",
 *          @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="Successful creation occurred (via either POST or PUT)"),
 *          )
 * )
 *  * @OA\Response(
 *          response="204 -  NO CONTENT",
 *          description="Indicates success but nothing is in the response body",
 *          @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="Indicates success but nothing is in the response body, often used for DELETE and PUT operations."),
 *          )
 * )
 * @OA\Response(
 *          response="400 - BAD REQUEST",
 *          description="The request would cause an invalid state",
 *          @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="The request would cause an invalid state, Domain validation errors, missing data."),
 *          )
 * )
 * @OA\Response(
 *          response="401 - UNAUTHORIZED",
 *          description="Authorization information is missing or invalid.",
 *          @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="Authorization information is missing or invalid."),
 *          )
 * )
 * @OA\Response(
 *          response="403 - FORBIDDEN",
 *          description="Error code for when the user is not authorized to perform the operation or the resource is unavailable for some reason.",
 *          @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="Error code for when the user is not authorized to perform the operation or the resource is unavailable for some reason"),
 *          )
 * )
 * @OA\Response(
 *          response="404 - NotFound",
 *          description="la resource n'existe pas",
 *          @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="le candidat n'éxiste pas"),
 *          )
 * )
 * @OA\Response(
 *          response="405 - METHOD NOT ALLOWED",
 *          description="Requested URL exists, but the requested HTTP method is not applicable.",
 *          @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="Requested URL exists, but the requested HTTP method is not applicable."),
 *          )
 * )
 * @OA\Response(
 *          response="409 - CONFLICT",
 *          description="Duplicate entries.",
 *          @OA\JsonContent(
 *                  @OA\Property(property="message", type="string", example="Duplicate entries."),
 *          )
 * )
 * @SecurityScheme(
 *          bearerFormat="JWT",
 *          type="apiKey",
 *          securityScheme="bearer",
 * )
 */
class AbstractBisController extends AbstractController
{

}
