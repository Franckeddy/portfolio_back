<?php

namespace App\Controller;

use App\Entity\Candidat;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\Response;

class CandidatController extends AbstractController
{
	/**
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
	 * @Rest\Post(
	 *     "/candidats"
	 * )
	 * @Rest\Put(
	 *     "/candidats"
	 * )
	 * @Rest\Patch(
	 *     "/candidats"
	 * )
	 * @ParamConverter(
	 *     "candidat",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
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

		return new Response('The Candidat is valid! Yes!');
	}

	//	TODO DELETE

}
