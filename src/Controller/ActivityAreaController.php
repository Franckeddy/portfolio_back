<?php

namespace App\Controller;

use App\Entity\ActivityArea;
use App\Repository\ActivityAreaRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

/**
 * @Route("/api")
 */
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
	 * 				@OA\JsonContent(ref="#/components/schemas/Activity")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * @Rest\Get(
	 *     path = "/activities/{id}",
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
	 * 		path="/activities/{id}",
	 * 		tags={"Secteur d'activité"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\RequestBody(ref="#/components/requestBodies/UpdateActivityArea"),
	 * 		@OA\Response(
	 * 				response="201",
	 * 				description="Notre Secteur d'activité",
	 * 				@OA\JsonContent(ref="#/components/schemas/Activity")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Post(
	 *     "/activities/"
	 * )
	 * @ParamConverter(
	 *     "activity_area",
	 *     converter="fos_rest.request_body"
	 * )
	 */
	public function createAction(ActivityArea $activity ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('candidat/validation.html.twig', [
				'errors' => $violations,
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($activity);
		$em->flush();
		return View::create($activity, Response::HTTP_CREATED , []);
	}

	/**
	 * @OA\Put(
	 * 		path="/activities/{id}",
	 * 		tags={"Secteur d'activité"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Secteur d'activité",
	 * 				@OA\JsonContent(ref="#/components/schemas/Activity")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Put(
	 *     "/activities/{id}"
	 * )
	 * @ParamConverter(	"activity_area",
	 *     				class="App\Entity\ActivityArea",
	 *     				converter="fos_rest.request_body"
	 * )
	 */
	public function putAction($id, Request $request, ActivityAreaRepository $ActivityRepository, EntityManagerInterface $em): View
	{
		$activity = $ActivityRepository->find($id);
		if (!$activity) {
			throw new HttpException(404, 'Activity not found');
		}
		$postdata = json_decode($request->getContent());
		$activity->setName($postdata->name);
		$em->persist($activity);
		$em->flush();
		return View::create($activity, Response::HTTP_OK, []);
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/activities/{id}",
	 * 		tags={"Secteur d'activité"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Secteur d'activité",
	 * 				@OA\JsonContent(ref="#/components/schemas/Activity")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Delete("/activities/{id}")
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
		return new Response('Delete !');
	}

	/**
	 * @OA\Get(
	 * 		path="/activities/",
	 * 		tags={"Liste des Secteurs d'activité"},
	 * 		@OA\Parameter(ref="#/components/parameters/"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Résume des Secteurs d'activité",
	 * 				@OA\JsonContent(ref="#/components/schemas/ActivityQuickView")
	 * 		),
	 * )
	 * @Rest\Get("/activities", name="app_activity_list")
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
		$repository = $this->getDoctrine()->getRepository(ActivityArea::class);

		// query for a single Product by its primary key (usually "id")
		$activity = $repository->findall();

		return View::create($activity, Response::HTTP_OK , []);
	}
}

