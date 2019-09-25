<?php

namespace App\Controller;

use App\Entity\Formation;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class FormationController extends AbstractController
{
	/**
	 * @Rest\Get(
	 *     path = "/formations/{id}",
	 *     name = "app_formation_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(Formation $formation)
	{
		return $formation;
	}

	/**
	 * @Rest\Post(
	 *     "/formations"
	 * )
	 *
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "formation",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(formation $formation ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('formation/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($formation);
		$em->flush();

		return new Response('The formation is valid! Yes!');
	}

	//	TODO DELETE

	//	TODO PUT
}
