<?php

namespace App\Controller;

use App\Entity\Candidat;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
	public function showAction()
	{
		$candidat = new Candidat();
		$candidat->setFirstname('Toto');
		$candidat->setTown('Paris');

		return $candidat;

	}

	/**
	 * @Rest\Post(
	 *     "/candidats"
	 * )
	 *
	 * @Rest\View(
	 *     StatusCode=201
	 * )
	 *
	 * @ParamConverter(
	 *     "candidat",
	 *     converter="fos_rest.request_body")
	 */
	public function createAction(Candidat $candidat)
	{
		$em = $this->getDoctrine()->getManager();

		$em->persist($candidat);
		$em->flush();

		//return $this->redirectToRoute('app_candidat_show', ['max' => 10]);
	}
}
