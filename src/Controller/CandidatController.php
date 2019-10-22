<?php

namespace App\Controller;

use App\Entity\Candidat;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use App\Controller\AbstractBisController;

class CandidatController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path = "/api/candidats/{id}",
	 * 		tags = {"Candidat"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Candidat",
	 * 				@OA\JsonContent(ref="#/components/schemas/Candidat")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound"),
	 * )
	 * 
	 * @Rest\Get(
	 *     path = "/api/candidats/{id}",
	 *     name = "app_candidat_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(Candidat $candidat)
	{
		return $candidat;
	}

	/**
	 * @OA\Post(
	 * 		path="/api/candidats/{id}",
	 * 		tags={"Candidat"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\RequestBody(ref="#/components/requestBodies/UpdateCandidat"),
	 * 		@OA\Response(
	 * 				response="201",
	 * 				description="Notre Candidat",
	 * 				@OA\JsonContent(ref="#/components/schemas/Candidat")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound"),
	 * 		@OA\Response(response="409", ref="#/components/responses/409 - CONFLICT")
	 * )
	 * 
	 * @Rest\Post(
	 *     "/api/candidats/"
	 * )
	 * @ParamConverter(
	 *     "candidat",
	 *     converter="fos_rest.request_body"
	 * )
	 */
	public function createAction(Candidat $candidat ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('candidat/validation.html.twig', [
				'errors' => $violations,
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($candidat);
		$em->flush();
		return new Response('The Candidat is valid! Yes!');
	}

	/**
	 * @OA\Put(
	 * 		path="/api/candidats/{id}",
	 * 		tags={"Candidat"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Candidat",
	 * 				@OA\JsonContent(ref="#/components/schemas/Candidat")
	 * 		),
	 * 		@OA\Response(response="204", ref="#/components/responses/204 -  NO CONTENT"),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Put(
	 *     "/api/candidats/"
	 * )
	 * @ParamConverter(
	 *     "candidat",
	 *     converter="fos_rest.request_body"
	 * )
	 */
	public function PutAction(Candidat $candidat ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('candidat/validation.html.twig', [
				'errors' => $violations,
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($candidat);
		$em->flush();
		return new Response('The Candidat is valid! Yes!');
	}

	/**
	 * @OA\Patch(
	 * 		path="/api/candidats/{id}",
	 * 		tags={"Candidat"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Candidat",
	 * 				@OA\JsonContent(ref="#/components/schemas/Candidat")
	 * 		),
	 * 		@OA\Response(response="204", ref="#/components/responses/204 -  NO CONTENT"),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Patch(
	 *     "/api/candidats/{id}"
	 * )
	 * @ParamConverter(
	 *     "candidat",
	 *     converter="fos_rest.request_body"
	 * )
	 */
	public function PatchAction(Candidat $candidat ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('candidat/validation.html.twig', [
				'errors' => $violations,
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($candidat);
		$em->flush();
		return new Response('The Candidat is valid! Yes!');
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/api/candidats/{id}",
	 * 		tags={"Candidat"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Candidat",
	 * 				@OA\JsonContent(ref="#/components/schemas/Candidat")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Delete("/api/candidats/{id}")
	 */
	public function removeCandidatAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$candidat = $em->getRepository('App:Candidat')
			->find($request->get('id'));

		if ($candidat) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($candidat);
			$em->flush();
		}
	}

	/**
	 * @OA\Get(
	 * 		path="/api/candidats/",
	 * 		tags={"Liste des Candidat"},
	 * 		@OA\Parameter(ref="#/components/parameters/"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Liste de Candidat",
	 * 				@OA\JsonContent(ref="#/components/schemas/CandidatQuickView")
	 * 		),
	 * )
	 * @Rest\Get("/api/candidats", name="app_candidat_list")
	 * @Rest\QueryParam(
	 *     name="keyword",
	 *     requirements="[a-zA-Z0-9]",
	 *     nullable=true,
	 *     description="The keyword to search for."
	 * )
	 * @Rest\QueryParam(
	 *     name="order",
	 *     requirements="asc|desc",
	 *     default="asc",
	 *     description="Sort order (asc or desc)"
	 * )
	 * @Rest\QueryParam(
	 *     name="limit",
	 *     requirements="\d+",
	 *     default="15",
	 *     description="Max number of movies per page."
	 * )
	 * @Rest\QueryParam(
	 *     name="offset",
	 *     requirements="\d+",
	 *     default="0",
	 *     description="The pagination offset"
	 * )
	 * @Rest\View()
	 */
	public function listAction(ParamFetcherInterface $paramFetcher)
	{
		$pager = $this->getDoctrine()->getRepository('App:Candidat')->findAll();

		return new JsonResponse($pager);
	}
}
