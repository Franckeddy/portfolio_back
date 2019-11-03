<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Repository\CandidatRepository;
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
class CandidatController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path = "/candidats/{id}",
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
	 *     path = "/candidats/{id}",
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
	 * 		path="/candidats/{id}",
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
	 * @Rest\Post(path=
	 *     "/candidats/",
	 *     name = "app_candidat_create",
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
		return View::create($candidat, Response::HTTP_CREATED , []);
	}

	/**
	 * @OA\Put(
	 *        path="/candidats/{id}",
	 *        tags={"Candidat"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 *                response="200",
	 *                description="Notre Candidat",
	 * 				@OA\JsonContent(ref="#/components/schemas/Candidat")
	 *        ),
	 * 		@OA\Response(response="204", ref="#/components/responses/204 -  NO CONTENT"),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 *
	 * @Rest\Put(path=
	 *     "/candidats/{id}",
	 *     name = "app_candidat_put",
	 * )
	 * @ParamConverter(	"candidat",
	 *     				class="App\Entity\Candidat",
	 *     				converter="fos_rest.request_body"
	 * )
	 * @return View
	 */
	public function putAction($id, Request $request, CandidatRepository $candidatRepository, EntityManagerInterface $em): View
	{
		$candidat = $candidatRepository->find($id);
		if (!$candidat) {
			throw new HttpException(404, 'Candidat not found');
		}
		$postdata = json_decode($request->getContent());
		$candidat->setLastname($postdata->lastname);
		$candidat->setFirstname($postdata->firstname);
		$candidat->setEmail($postdata->email);
		$candidat->setAdress($postdata->adress);
		$candidat->setTown($postdata->town);
		$candidat->setZipcode($postdata->zipcode);
		$candidat->setDateOfBirth(new \DateTime($postdata->date_of_birth));
		$candidat->setShortDescription($postdata->short_description);
		$em->persist($candidat);
		$em->flush();
		return View::create($candidat, Response::HTTP_OK, []);
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/candidats/{id}",
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
	 * @Rest\Delete(path="/candidats/{id}")
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
		return new Response('Delete !');
	}

	/**
	 * @OA\Get(
	 * 		path="/candidats/",
	 * 		tags={"Liste des Candidat"},
	 * 		@OA\Parameter(ref="#/components/parameters/"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Liste de Candidat",
	 * 				@OA\JsonContent(ref="#/components/schemas/CandidatQuickView")
	 * 		),
	 * )
	 * @Rest\Get(path="/candidats", name="app_candidat_list")
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
		$repository = $this->getDoctrine()->getRepository(Candidat::class);

		// query for a single Product by its primary key (usually "id")
		$candidat = $repository->findall();

		return View::create($candidat, Response::HTTP_OK , []);
	}
}
