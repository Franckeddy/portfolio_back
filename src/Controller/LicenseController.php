<?php

namespace App\Controller;

use App\Entity\License;
use FOS\RestBundle\Controller\Annotations as Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;

class LicenseController extends AbstractController
{
	/**
	 * @Rest\Get(
	 *     path = "/licenses/{id}",
	 *     name = "app_license_show",
	 *     requirements = {"id"="\d+"}
	 * )
	 *
	 * @Rest\View(
	 *     statusCode = 201,
	 * )
	 */
	public function showAction(License $license)
	{
		return $license;
	}

	/**
	 * @Rest\Post(
	 *     "/licenses"
	 * )
	 * @Rest\Put(
	 *     "/licenses"
	 * )
	 * @Rest\Patch(
	 *     "/licenses"
	 * )
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "license",
	 *     converter="fos_rest.request_body",
	 *     options={"validator"={ "groups"="Create"}
	 *	 }
	 * )
	 */
	public function createAction(License $license ,ConstraintViolationList $violations)
	{
		if (count($violations) > 0) {
			return $this->render('license/validation.html.twig', [
				'errors' => $violations,
			]);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($license);
		$em->flush();

		return new Response('The license is valid! Yes!');
	}

	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * @Rest\Delete("/licenses/{id}")
	 */
	public function removeLicenseAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$license = $em->getRepository('App:License')
			->find($request->get('id'));

		if ($license) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($license);
			$em->flush();
		}
	}
}
