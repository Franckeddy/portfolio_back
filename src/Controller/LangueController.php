<?php

namespace App\Controller;

use App\Entity\Langue;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;
use OpenApi\Annotations as OA;
use App\Controller\AbstractBisController;
class LangueController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/api/langues/{id}",
	 * 		tags={"Langue"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Langue",
	 * 				@OA\JsonContent(ref="#/components/schemas/Langue")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Get(
	 *     path = "/api/langues/{id}",
	 *     name = "app_langue_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(Langue $langue)
	{
		return $langue;
	}

	/**
	 * @OA\Post(
	 * 		path="/api/langues/{id}",
	 * 		tags={"Langue"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\RequestBody(ref="#/components/requestBodies/UpdateLangue"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Langue",
	 * 				@OA\JsonContent(ref="#/components/schemas/Langue")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Post(
	 *     "/api/langues"
	 * )
	 * 
	 * @OA\Put(
	 * 		path="/api/langues/{id}",
	 * 		tags={"Langue"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Langue",
	 * 				@OA\JsonContent(ref="#/components/schemas/Langue")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Put(
	 *     "/api/langues"
	 * )
	 * 
	 * @OA\Patch(
	 * 		path="/api/langues/{id}",
	 * 		tags={"Langue"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Langue",
	 * 				@OA\JsonContent(ref="#/components/schemas/Langue")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Patch(
	 *     "/api/langues"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "langue",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(Langue $langue ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('langue/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($langue);
		$em->flush();

		return new Response('The langue is valid! Yes!');
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/api/langues/{id}",
	 * 		tags={"Langue"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Langue",
	 * 				@OA\JsonContent(ref="#/components/schemas/Langue")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Delete("/api/langues/{id}")
	 */
	public function removeLangueAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$langue = $em->getRepository('App:Langue')
			->find($request->get('id'));

		if ($langue) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($langue);
			$em->flush();
		}
	}
}
