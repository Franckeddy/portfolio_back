<?php

namespace App\Controller;

use App\Entity\Company;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
	 *
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

	//	TODO DELETE

	//	TODO PUT
}
