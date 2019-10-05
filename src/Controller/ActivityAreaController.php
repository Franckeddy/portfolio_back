<?php

namespace App\Controller;

use App\Entity\ActivityArea;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\Response;

class ActivityAreaController extends AbstractController
{
	/**
	 * @Rest\Get(
	 *     path = "/activities/{id}",
	 *     name = "app_activity_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(ActivityArea $activity)
	{
		return $activity;
	}

	/**
	 * @Rest\Post(
	 *     "/activities"
	 * )
	 * @Rest\Put(
	 *     "/activities"
	 * )
	 * @Rest\Patch(
	 *     "/activities"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "activity",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(ActivityArea $activity ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('activity_area/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($activity);
		$em->flush();

		return new Response('Your activity is valid! Yes!');
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * @Rest\Delete("/activities/{id}")
	 */
	public function removeActivityAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$activity = $em->getRepository('App:ActivityArea')
			->find($request->get('id'));

		if ($activity) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($activity);
			$em->flush();
		}
	}
}
