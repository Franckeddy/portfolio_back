<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
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
class CompanyController extends AbstractBisController
{
	/**
	 * @OA\Get(
	 * 		path="/companies/{id}",
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
	 *     path = "/companies/{id}",
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
	 * 		path="/companies/{id}",
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
	 *     "/companies/"
	 * )
	 * )
	 * @ParamConverter(
	 *     "company",
	 *     	converter="fos_rest.request_body"
	 * )
	 */
	public function createAction(Company $company ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('candidat/validation.html.twig', [
				'errors' => $violations,
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($company);
		$em->flush();
		return View::create($company, Response::HTTP_CREATED , []);
	}

	/**
	 * @OA\Put(
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
	 * @Rest\Put(
	 *     "/companies/{id}"
	 * )
	 * @ParamConverter(	"company",
	 *     				class="App/Company[]",
	 *     				converter="fos_rest.request_body"
	 * )
	 */
	public function putAction($id, Request $request, CompanyRepository $companyRepository, EntityManagerInterface $em): View
	{
		$company = $companyRepository->find($id);
		if (!$company) {
			throw new HttpException(404, 'Company not found');
		}
		$postdata = json_decode($request->getContent());
		$company->setName($postdata->name);
		$company->setStartDate($postdata->start_date);
		$company->setEndDate($postdata->end_date);
		$em->persist($company);
		$em->flush();
		return View::create($company, Response::HTTP_OK, []);
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * 
	 * @OA\Delete(
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
	 * @Rest\Delete("/companies/{id}")
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
		return new Response('Delete !');
	}
	/**
	 * @OA\Get(
	 * 		path="/companies/",
	 * 		tags={"Liste des Entreprises"},
	 * 		@OA\Parameter(ref="#/components/parameters/"),
	 * 		@OA\Response(
	 * 				response="200",
	 * 				description="Notre Liste des Entreprises",
	 * 				@OA\JsonContent(ref="#/components/schemas/CompanyQuickView")
	 * 		),
	 * )
	 * @Rest\Get("/companies", name="app_company_list")
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
		$repository = $this->getDoctrine()->getRepository(Company::class);

		// query for a single Product by its primary key (usually "id")
		$company = $repository->findall();

		return View::create($company, Response::HTTP_OK , []);
	}
}
