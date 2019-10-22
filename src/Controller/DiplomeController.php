<?php

namespace App\Controller;

use App\Entity\Diplome;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;
use OpenApi\Annotations as OA;
use App\Controller\AbstractBisController;
class DiplomeController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/api/diplomes/{id}",
	 * 		tags={"Diplome"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Diplome",
	 * 				@OA\JsonContent(ref="#/components/schemas/Diplome")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Get(
	 *     path = "/api/diplomes/{id}",
	 *     name = "app_diplome_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(Diplome $diplome)
	{
		return $diplome;
	}

	/**
	 * @OA\Post(
	 * 		path="/api/diplomes/{id}",
	 * 		tags={"Diplome"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\RequestBody(ref="#/components/requestBodies/UpdateDiplome"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Diplome",
	 * 				@OA\JsonContent(ref="#/components/schemas/Diplome")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Post(
	 *     "/api/diplomes"
	 * )
	 * 
	 * @OA\Put(
	 * 		path="/api/diplomes/{id}",
	 * 		tags={"Diplome"},	 
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Diplome",
	 * 				@OA\JsonContent(ref="#/components/schemas/Diplome")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * @Rest\Put(
	 *     "/api/diplomes"
	 * )
	 * 
	 * @OA\Patch(
	 * 		path="/api/diplomes/{id}",
	 * 		tags={"Diplome"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Diplome",
	 * 				@OA\JsonContent(ref="#/components/schemas/Diplome")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * @Rest\Patch(
	 *     "/api/diplomes"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "diplome",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(Diplome $diplome ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('diplome/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($diplome);
		$em->flush();

		return new Response('The diplome is valid! Yes!');
	}

	/**
 	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/api/diplomes/{id}",
	 * 		tags={"Diplome"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Diplome",
	 * 				@OA\JsonContent(ref="#/components/schemas/Diplome")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
 	 * @Rest\Delete("/api/diplomes/{id}")
 	 **/
	public function removeDiplomeAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$diplome = $em->getRepository('Diplome')
			->find($request->get('id'));

		if ($diplome) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($diplome);
			$em->flush();
		}
	}
}
