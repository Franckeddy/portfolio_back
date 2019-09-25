<?php

namespace App\Controller;

use App\Entity\School;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class SchoolController extends AbstractController
{
	/**
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
	 * @Rest\Post(
	 *     "/schools"
	 * )
	 * @Rest\Put(
	 *     "/schools"
	 * )
	 * @Rest\Patch(
	 *     "/schools"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "school",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(School $school ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('school/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($school);
		$em->flush();

		return new Response('The school is valid! Yes!');
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
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
	}
}
