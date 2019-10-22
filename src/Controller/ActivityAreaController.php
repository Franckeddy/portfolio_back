<?php

namespace App\Controller;

use App\Entity\ActivityArea;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Controller\AbstractBisController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

class ActivityAreaController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/activities/{id}",
	 * 		tags={"Secteur d'activité"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Secteur d'activité",
	 * 				@OA\JsonContent(ref="#/components/schemas/Secteur d'activité")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * @Rest\Get(
	 *     path = "/api/activities/{id}",
	 *     name = "app_activity_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(ActivityArea $activity)
	{
		return $activity;
	}

	/**
	 * @OA\Post(
	 * 		path="/api/activities/{id}",
	 * 		tags={"Secteur d'activité"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\RequestBody(ref="#/components/requestBodies/UpdateActivityArea"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Secteur d'activité",
	 * 				@OA\JsonContent(ref="#/components/schemas/Secteur d'activité")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Post(
	 *     "/api/activities"
	 * )
	 * 
	 * @OA\Put(
	 * 		path="/api/activities/{id}",
	 * 		tags={"Secteur d'activité"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Secteur d'activité",
	 * 				@OA\JsonContent(ref="#/components/schemas/Secteur d'activité")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Put(
	 *     "/api/activities"
	 * )
	 * 
	 * @OA\Patch(
	 * 		path="/api/activities/{id}",
	 * 		tags={"Secteur d'activité"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Secteur d'activité",
	 * 				@OA\JsonContent(ref="#/components/schemas/Secteur d'activité")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Patch(
	 *     "/api/activities"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "activity",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(ActivityArea $activity ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('activity_area/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($activity);
		$em->flush();

		return new Response('Your activity is valid! Yes!');
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/api/activities/{id}",
	 * 		tags={"Secteur d'activité"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Secteur d'activité",
	 * 				@OA\JsonContent(ref="#/components/schemas/Secteur d'activité")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Delete("/api/activities/{id}")
	 */
	public function removeActivityAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$activity = $em->getRepository('App:ActivityArea')
			->find($request->get('id'));

		if ($activity) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($activity);
			$em->flush();
		}
	}
}
