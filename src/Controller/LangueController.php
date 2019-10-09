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
	 * 		path="/langues/{id}",
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Langue",
	 * 				@OA\JsonContent(ref="#/components/schemas/Langue")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/NotFound")
	 * )
	 * 
	 * @Rest\Get(
	 *     path = "/langues/{id}",
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
	 * @Rest\Post(
	 *     "/langues"
	 * )
	 * @Rest\Put(
	 *     "/langues"
	 * )
	 * @Rest\Patch(
	 *     "/langues"
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
	 * @Rest\Delete("/langues/{id}")
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
