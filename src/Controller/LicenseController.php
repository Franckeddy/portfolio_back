<?php

namespace App\Controller;

use App\Entity\License;
use FOS\RestBundle\Controller\Annotations as Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use OpenApi\Annotations as OA;
use App\Controller\AbstractBisController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;

class LicenseController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/licenses/{id}",
	 * 		tags={"Permis"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Permis",
	 * 				@OA\JsonContent(ref="#/components/schemas/Permis")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Get(
	 *     path = "/licenses/{id}",
	 *     name = "app_license_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(License $license)
	{
		return $license;
	}

	/**
	 * @OA\Post(
	 * 		path="/licenses/{id}",
	 * 		tags={"Permis"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Permis",
	 * 				@OA\JsonContent(ref="#/components/schemas/Permis")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Post(
	 *     "/licenses"
	 * )
	 * 
	 * @OA\Put(
	 * 		path="/licenses/{id}",
	 * 		tags={"Permis"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Permis",
	 * 				@OA\JsonContent(ref="#/components/schemas/Permis")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Put(
	 *     "/licenses"
	 * )
	 * 
	 * @OA\Patch(
	 * 		path="/licenses/{id}",
	 * 		tags={"Permis"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Permis",
	 * 				@OA\JsonContent(ref="#/components/schemas/Permis")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Patch(
	 *     "/licenses"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "license",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(License $license ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('license/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($license);
		$em->flush();

		return new Response('The license is valid! Yes!');
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/licenses/{id}",
	 * 		tags={"Permis"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Permis",
	 * 				@OA\JsonContent(ref="#/components/schemas/Permis")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Delete("/licenses/{id}")
	 */
	public function removeLicenseAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$license = $em->getRepository('App:License')
			->find($request->get('id'));

		if ($license) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($license);
			$em->flush();
		}
	}
}
