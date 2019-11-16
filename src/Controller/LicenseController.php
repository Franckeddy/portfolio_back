<?php

namespace App\Controller;

use App\Entity\License;
use App\Repository\LicenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use OpenApi\Annotations as OA;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @Route("/api")
 */
class LicenseController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/licenses/{id}",
	 * 		tags={"Permis"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Permis",
	 * 				@OA\JsonContent(ref="#/components/schemas/License")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Get(
	 *     path = "/licenses/{id}",
	 *     name = "app_license_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(License $license)
	{
		return $license;
	}

	/**
	 * @OA\Post(
	 * 		path="/licenses/{id}",
	 * 		tags={"Permis"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\RequestBody(ref="#/components/requestBodies/UpdateLicense"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Permis",
	 * 				@OA\JsonContent(ref="#/components/schemas/License")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * @Rest\Post(
	 *     "/licenses/"
	 * )
	 * @ParamConverter(
	 *     "license",
	  *     class="App\Entity\License",
	 *     converter="fos_rest.request_body"
	 * )
	 */
	public function createAction(License $license ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('candidat/validation.html.twig', [
				'errors' => $violations,
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($license);
		$em->flush();

		return View::create($license, Response::HTTP_CREATED , []);
	}

	/**
	 * @OA\Put(
	 * 		path="/licenses/{id}",
	 * 		tags={"Permis"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Permis",
	 * 				@OA\JsonContent(ref="#/components/schemas/License")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * @Rest\Put(
	 *     "/licenses/{id}"
	 * )
	  * @ParamConverter(
	  *     "license",
	  *     class="App\Entity\License",
	  *     converter="fos_rest.request_body"
	  * )
	  */
	public function putAction($id, Request $request, LicenseRepository $licenseRepository, EntityManagerInterface $em): View
	{
		$license = $licenseRepository->find($id);
		if (!$license) {
			throw new HttpException(404, 'License not found');
		}
		$postdata = json_decode($request->getContent());
		$license->setName($postdata->name);
		$license->setDateObtention($postdata->date);
		$em->persist($license);
		$em->flush();
		return View::create($license, Response::HTTP_OK, []);
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/licenses/{id}",
	 * 		tags={"Permis"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Permis",
	 * 				@OA\JsonContent(ref="#/components/schemas/License")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Delete("/licenses/{id}")
	 */
	public function removeLicenseAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$license = $em->getRepository('App:License')
			->find($request->get('id'));

		if ($license) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($license);
			$em->flush();
		}
		return new Response('Delete !');
	}

	/**
	 * @OA\Get(
	 * 		path="/licenses/",
	 * 		tags={"Liste des licenses"},
	 * 		@OA\Parameter(ref="#/components/parameters/"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Liste des Licenses",
	 * 				@OA\JsonContent(ref="#/components/schemas/LicenseQuickView")
	 * 		),
	 * )
	 * @Rest\Get("/licenses", name="app_license_list")
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

		$repository = $this->getDoctrine()->getRepository(License::class);

		// query for a single Product by its primary key (usually "id")
		$license = $repository->findall();

		return View::create($license, Response::HTTP_OK , []);

	}
}
