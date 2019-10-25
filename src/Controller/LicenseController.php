<?php

namespace App\Controller;

use App\Entity\License;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use JMS\Serializer\Annotation\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use OpenApi\Annotations as OA;
use FOS\RestBundle\View\View;
use App\Controller\AbstractBisController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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
	  * @ParamConverter(	"license",
	  *     				class="App/License[]",
	  *     				converter="fos_rest.request_body"
	  * )
	  */
	public function putAction(Request $request)
	{
		return $this->updateLicense($request, true);
	}

	/**
	 * @OA\Patch(
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
	 * @Rest\Patch(
	 *     "/licenses/{id}"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 * @ParamConverter(
	 *     "license",
	 *     converter="fos_rest.request_body",
	 *     class="App/License[]",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 * @Type("App\Entity\License")
	 */
	public function PatchAction(Request $request)
	{
		return $this->updateLicense($request, false);
		// Le paramètre false dit à Symfony de garder les valeurs dans notre
		// entité si l'utilisateur n'en fournit pas une dans sa requête
	}
	private function updateLicense(Request $request, $clearMissing)
	{
		$candidat = $this->get('doctrine.orm.entity_manager')
			->getRepository('App:License')
			->find($request->get('id'));

		if (empty($license)) {
			return new JsonResponse(['message' => 'License not found'], Response::HTTP_NOT_FOUND);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($license);
		$em->flush();
		return new Response('The License is valid! Yes!');
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
