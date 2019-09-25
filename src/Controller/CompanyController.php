<?php

namespace App\Controller;

use App\Entity\Company;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class CompanyController extends AbstractController
{
	/**
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
	 * @Rest\Post(
	 *     "/companies"
	 * )
	 * @Rest\Put(
	 *     "/companies"
	 * )
	 * @Rest\Patch(
	 *     "/companies"
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
	 * @Rest\Delete("/companies/{id}")
	 */
	public function removeCompanyAction(Request $request)
	{
		$em = $this->get('doctrine.orm.entity_manager');
		$company = $em->getRepository('App:Company')
			->find($request->get('id'));

		if ($company) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($company);
			$em->flush();
		}
	}
}
