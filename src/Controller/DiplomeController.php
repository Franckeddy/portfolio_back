<?php

namespace App\Controller;

use App\Entity\Diplome;
use App\Repository\DiplomeRepository;
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
class DiplomeController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/diplomes/{id}",
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
	 *     path = "/diplomes/{id}",
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
	 * 		path="/diplomes/{id}",
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
	 *     "/diplomes"
	 * )
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
	 * @OA\Put(
	 * 		path="/diplomes/{id}",
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
	 *     "/diplomes/{id}"
	 * )
	 *
	 * @ParamConverter(	"diplome",
	 *     				class="App\Entity\Diplome",
	 *     				converter="fos_rest.request_body"
	 * )
	 * )
	 */
	public function putAction($id, Request $request, DiplomeRepository $diplomeRepository, EntityManagerInterface $em): View
	{
		$diplome = $diplomeRepository->find($id);
		if (!$diplome) {
			throw new HttpException(404, 'License not found');
		}
		$postdata = json_decode($request->getContent());
		$diplome->setName($postdata->name);
		$diplome->setLevel($postdata->level);
		$diplome->setDateObtention($postdata->date);
		$em->persist($diplome);
		$em->flush();
		return View::create($diplome, Response::HTTP_OK, []);
	}

	/**
 	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/diplomes/{id}",
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
 	 * @Rest\Delete("/diplomes/{id}")
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
		return new Response('Delete !');
	}

	/**
	 * @OA\Get(
	 * 		path="/diplomes/",
	 * 		tags={"Liste des diplomes"},
	 * 		@OA\Parameter(ref="#/components/parameters/"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Liste des diplomes",
	 * 				@OA\JsonContent(ref="#/components/schemas/DiplomeQuickView")
	 * 		),
	 * )
	 * @Rest\Get("/diplomes", name="app_diplome_list")
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

		$repository = $this->getDoctrine()->getRepository(Diplome::class);

		// query for a single Product by its primary key (usually "id")
		$diplome = $repository->findall();

		return View::create($diplome, Response::HTTP_OK , []);

	}
}

