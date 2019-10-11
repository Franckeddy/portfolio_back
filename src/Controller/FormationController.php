<?php

namespace App\Controller;

use App\Entity\Formation;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use OpenApi\Annotations as OA;
use App\Controller\AbstractBisController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class FormationController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/formations/{id}",
	 * 		tags={"Formation"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Formation",
	 * 				@OA\JsonContent(ref="#/components/schemas/Formation")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Get(
	 *     path = "/formations/{id}",
	 *     name = "app_formation_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(Formation $formation)
	{
		return $formation;
	}

	/**
	 * @OA\Post(
	 * 		path="/formations/{id}",
	 * 		tags={"Formation"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\RequestBody(ref="#/components/requestBodies/UpdateFormation"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Formation",
	 * 				@OA\JsonContent(ref="#/components/schemas/Formation")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Post(
	 *     "/formations"
	 * )
	 * 
	 * @OA\Put(
	 * 		path="/formations/{id}",
	 * 		tags={"Formation"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Formation",
	 * 				@OA\JsonContent(ref="#/components/schemas/Formation")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Put(
	 *     "/formations"
	 * )
	 * 
	 * @OA\Patch(
	 * 		path="/formations/{id}",
	 * 		tags={"Formation"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Formation",
	 * 				@OA\JsonContent(ref="#/components/schemas/Formation")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Patch(
	 *     "/formations"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "formation",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(formation $formation ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('formation/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($formation);
		$em->flush();

		return new Response('The formation is valid! Yes!');
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/formations/{id}",
	 * 		tags={"Formation"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Formation",
	 * 				@OA\JsonContent(ref="#/components/schemas/Formation")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Delete("/formations/{id}")
	 */
	public function removeFormationAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$formation = $em->getRepository('App:Formation')
			->find($request->get('id'));

		if ($formation) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($formation);
			$em->flush();
		}
	}}
