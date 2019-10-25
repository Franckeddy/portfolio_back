<?php

namespace App\Controller;

use App\Entity\School;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use JMS\Serializer\Annotation\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;
use OpenApi\Annotations as OA;

/**
 * @Route("/api")
 */
class SchoolController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/schools/{id}",
	 * 		tags={"Ecole"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Ecole",
	 * 				@OA\JsonContent(ref="#/components/schemas/Ecole")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * 
	 * )
	 * 
	 * @Rest\Get(
	 *     path = "/schools/{id}",
	 *     name = "app_school_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(School $school)
	{
		return $school;
	}

	/**
	 * @OA\Post(
	 * 		path="/schools/{id}",
	 * 		tags={"Ecole"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\RequestBody(ref="#/components/requestBodies/UpdateSchool"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Ecole",
	 * 				@OA\JsonContent(ref="#/components/schemas/Ecole")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Post(
	 *     "/schools/"
	 * )
	 * @ParamConverter(
	 *     "school",
	 *     converter="fos_rest.request_body"
	 * )
	 */
	public function createAction(School $school ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('candidat/validation.html.twig', [
				'errors' => $violations,
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($school);
		$em->flush();
		return View::create($school, Response::HTTP_CREATED , []);
	}

	/**
	 * @OA\Put(
	 * 		path="/schools/{id}",
	 * 		tags={"Ecole"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Ecole",
	 * 				@OA\JsonContent(ref="#/components/schemas/Ecole")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Put(
	 *     "/schools/{id}"
	 * )
	 * @ParamConverter(	"school",
	 *     				class="App/School[]",
	 *     				converter="fos_rest.request_body"
	 * )
	 * @throws \Doctrine\ORM\ORMException
	 */
	public function putAction(Request $request)
	{
		return $this->updateCandidat($request, true);
	}

	/**
	 * @OA\Patch(
	 * 		path="/schools/{id}",
	 * 		tags={"Ecole"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Ecole",
	 * 				@OA\JsonContent(ref="#/components/schemas/Ecole")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Patch(
	 *     "/schools/{id}"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "school",
	 *     class="App/School[]",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 * @Type("App\Entity\School")
	 */
	public function patchAction(Request $request)
	{
		return $this->updateSchool($request, false);
		// Le paramètre false dit à Symfony de garder les valeurs dans notre
		// entité si l'utilisateur n'en fournit pas une dans sa requête
	}

	private function updateSchool(Request $request, $clearMissing)
	{
		$school = $this->get('doctrine.orm.entity_manager')
			->getRepository('App:School')
			->find($request->get('id'));
		if (empty($school)) {
			return new JsonResponse(['message' => 'School not found'], Response::HTTP_NOT_FOUND);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($school);
		$em->flush();
		return new Response('The school is valid! Yes!');
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/schools/{id}",
	 * 		tags={"Ecole"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Ecole",
	 * 				@OA\JsonContent(ref="#/components/schemas/Ecole")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Delete("/schools/{id}")
	 */
	public function removeSchoolAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$school = $em->getRepository('App:School')
			->find($request->get('id'));

		if ($school) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($school);
			$em->flush();
		}
		return new Response('Delete !');
	}

	/**
	 * @OA\Get(
	 * 		path="/schools/",
	 * 		tags={"Liste des Ecoles"},
	 * 		@OA\Parameter(ref="#/components/parameters/"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Liste des Ecoles",
	 * 				@OA\JsonContent(ref="#/components/schemas/SchoolQuickView")
	 * 		),
	 * )
	 * @Rest\Get("/schools", name="app_school_list")
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
		$repository = $this->getDoctrine()->getRepository(School::class);

		// query for a single Product by its primary key (usually "id")
		$school = $repository->findall();

		return View::create($school, Response::HTTP_OK , []);
	}
}

