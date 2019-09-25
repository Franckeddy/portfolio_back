<?php

namespace App\Controller;

use App\Entity\Langue;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class LangueController extends AbstractController
{
	/**
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
	 * @Rest\Post(
	 *     "/langues"
	 * )
	 *
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "langue",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(Langue $langue ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('langue/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($langue);
		$em->flush();

		return new Response('The langue is valid! Yes!');
	}

	//	TODO DELETE

	//	TODO PUT
}
