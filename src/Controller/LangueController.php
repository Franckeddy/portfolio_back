<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Repository\LangueRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationList;
use OpenApi\Annotations as OA;

/**
 * @Route("/api")
 */
class LangueController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/langues/{id}",
	 * 		tags={"Langue"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Langue",
	 * 				@OA\JsonContent(ref="#/components/schemas/Langue")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
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
	 * @OA\Post(
	 * 		path="/langues/{id}",
	 * 		tags={"Langue"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\RequestBody(ref="#/components/requestBodies/UpdateLangue"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Langue",
	 * 				@OA\JsonContent(ref="#/components/schemas/Langue")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Post(
	 *     "/langues/"
	 * )
	 * @ParamConverter(
	 *     "langue",
	 *     converter="fos_rest.request_body"
	 * )
	 */
	public function createAction(Langue $langue ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('candidat/validation.html.twig', [
				'errors' => $violations,
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($langue);
		$em->flush();
		return View::create($langue, Response::HTTP_CREATED , []);
	}

	/**
	 * PUT permet de remplacer (ou créer) une ressource preferable à
	 * PATCH qui  permet de compléter ou corriger une ressource
	 *
	 * @OA\Put(
	 * 		path="/langues/{id}",
	 * 		tags={"Langue"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Langue",
	 * 				@OA\JsonContent(ref="#/components/schemas/Langue")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * @ParamConverter(	"Langue",
	 *     				class="App\Entity\Langue",
	 *     				converter="fos_rest.request_body"
	 * )
	 * @Rest\Put(
	 *     "/langues/{id}"
	 * )
	 */
	public function putAction($id, Request $request, LangueRepository $langueRepository, EntityManagerInterface $em): View
	{
		$langue = $langueRepository->find($id);
		if (!$langue) {
			throw new HttpException(404, 'Langue not found');
		}
		$postdata = json_decode($request->getContent());
		$langue->setName($postdata->name);
		$langue->setLevel($postdata->level);
		$em->persist($langue);
		$em->flush();
		return View::create($langue, Response::HTTP_OK, []);
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/langues/{id}",
	 * 		tags={"Langue"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Langue",
	 * 				@OA\JsonContent(ref="#/components/schemas/Langue")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
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
		return new Response('Delete !');
	}

	/**
	 * @OA\Get(
	 * 		path="/langues/",
	 * 		tags={"Liste des langues"},
	 * 		@OA\Parameter(ref="#/components/parameters/"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Liste des langues",
	 * 				@OA\JsonContent(ref="#/components/schemas/LangueQuickView")
	 * 		),
	 * )
	 * @Rest\Get("/langues", name="app_langue_list")
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
		$repository = $this->getDoctrine()->getRepository(Langue::class);

		// query for a single Product by its primary key (usually "id")
		$langue = $repository->findall();

		return View::create($langue, Response::HTTP_OK , []);
	}
}

