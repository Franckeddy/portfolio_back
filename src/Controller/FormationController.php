<?php

namespace App\Controller;

use App\Entity\Formation;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
	 * @Rest\Put(
	 *     "/formations"
	 * )
	 * @Rest\Patch(
	 *     "/formations"
	 * )
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

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * @Rest\Delete("/formations/{id}")
	 */
	public function removeFormationAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$formation = $em->getRepository('App:Formation')
			->find($request->get('id'));

		if ($formation) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($formation);
			$em->flush();
		}
	}}
