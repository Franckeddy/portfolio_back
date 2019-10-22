<?php

namespace App\Controller;

use App\Entity\Company;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;
use OpenApi\Annotations as OA;
use App\Controller\AbstractBisController;
class CompanyController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/api/companies/{id}",
	 * 		tags={"Entreprise"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Entreprise",
	 * 				@OA\JsonContent(ref="#/components/schemas/Company")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Get(
	 *     path = "/api/companies/{id}",
	 *     name = "app_company_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(Company $company)
	{
		return $company;
	}

	/**
	 * @OA\Post(
	 * 		path="/api/companies/{id}",
	 * 		tags={"Entreprise"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\RequestBody(ref="#/components/requestBodies/UpdateCompany"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Company",
	 * 				@OA\JsonContent(ref="#/components/schemas/Company")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Post(
	 *     "/api/companies"
	 * )
	 * 
	 * @OA\Put(
	 * 		path="/api/companies/{id}",
	 * 		tags={"Entreprise"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Company",
	 * 				@OA\JsonContent(ref="#/components/schemas/Company")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Put(
	 *     "/api/companies"
	 * )
	 * 
	 * @OA\Patch(
	 * 		path="/companies/{id}",
	 * 		tags={"Entreprise"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Company",
	 * 				@OA\JsonContent(ref="#/components/schemas/Company")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Patch(
	 *     "/api/companies"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "company",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(Company $company ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('company/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($company);
		$em->flush();

		return new Response('The company is valid! Yes!');
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
	 * 		path="/api/companies/{id}",
	 * 		tags={"Entreprise"},
	 * 		@OA\Parameter(ref="#/components/parameters/id"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Company",
	 * 				@OA\JsonContent(ref="#/components/schemas/Company")
	 * 		),
	 * 		@OA\Response(response="404", ref="#/components/responses/404 - NotFound")
	 * )
	 * 
	 * @Rest\Delete("/api/companies/{id}")
	 */
	public function removeCompanyAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$company = $em->getRepository('App:Company')
			->find($request->get('id'));

		if ($company) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($company);
			$em->flush();
		}
	}
}
