<?php

namespace App\Controller;

use App\Entity\Formation;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use JMS\Serializer\Annotation\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @Route("/api")
 */
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
	 *     "/formations/"
	 * )
	 * @ParamConverter(
	 *     "formation",
	 *     converter="fos_rest.request_body"
	 * )
	 */
	public function createAction(Formation $formation ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('candidat/validation.html.twig', [
				'errors' => $violations,
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($formation);
		$em->flush();
		return View::create($formation, Response::HTTP_CREATED , []);
	}

	/**
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
	 *     "/formations/{id}"
	 * )
	 * @throws \Doctrine\ORM\ORMException
	 */
	public function putAction(Request $request)
	{
		return $this->updateFormation($request, true);
	}

	/**
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
	 *     "/formations/{id}"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "formation",
	 *     	class="App/Formation[]",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 * @Type("App\Entity\Formation")
	 */
	public function patchAction(Request $request)
	{
		return $this->updateFormation($request, false);
		// Le paramètre false dit à Symfony de garder les valeurs dans notre
		// entité si l'utilisateur n'en fournit pas une dans sa requête
	}

	private function updateFormation(Request $request, $clearMissing)
	{
		$formation = $this->get('doctrine.orm.entity_manager')
			->getRepository('App:Formation')
			->find($request->get('id'));
		if (empty($formation)) {
			return new JsonResponse(['message' => 'Formation not found'], Response::HTTP_NOT_FOUND);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($formation);
		$em->flush();
		return new Response('The Formation is valid! Yes!');
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
		return new Response('Delete !');
	}
	/**
	 * @OA\Get(
	 * 		path="/formations/",
	 * 		tags={"Liste des Formations"},
	 * 		@OA\Parameter(ref="#/components/parameters/"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Liste des Formations",
	 * 				@OA\JsonContent(ref="#/components/schemas/FormationQuickView")
	 * 		),
	 * )
	 * @Rest\Get("/formations", name="app_formation_list")
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
	public function listAction()
	{
		$repository = $this->getDoctrine()->getRepository(Formation::class);

		// query for a single Product by its primary key (usually "id")
		$formation = $repository->findall();

		return View::create($formation, Response::HTTP_OK , []);
	}
}
