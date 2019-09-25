<?php

namespace App\Controller;

use App\Entity\Diplome;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class DiplomeController extends AbstractController
{
	/**
	 * @Rest\Get(
	 *     path = "/diplomes/{id}",
	 *     name = "app_diplome_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(Diplome $diplome)
	{
		return $diplome;
	}

	/**
	 * @Rest\Post(
	 *     "/diplomes"
	 * )
	 *
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "diplome",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(Diplome $diplome ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('diplome/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($diplome);
		$em->flush();

		return new Response('The diplome is valid! Yes!');
	}

	//	TODO DELETE

	//	TODO PUT
}
