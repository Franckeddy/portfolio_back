<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
	 */
	public function putAction($id, Request $request, FormationRepository $formationRepository, EntityManagerInterface $em): View
	{
		$formation = $formationRepository->find($id);
		if (!$formation) {
			throw new HttpException(404, 'Formation not found');
		}
		$postdata = json_decode($request->getContent());
		$formation->setName($postdata->name);
		$formation->setStartDate($postdata->start_date);
		$formation->setEndDate($postdata->end_date);
		$em->persist($formation);
		$em->flush();
		return View::create($formation, Response::HTTP_OK, []);
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
