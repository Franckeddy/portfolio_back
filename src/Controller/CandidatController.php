<?php

namespace App\Controller;

use App\Entity\Candidat;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;

class CandidatController extends AbstractController
{
	/**
	 * @Rest\Get(
	 *     path = "/candidats/{id}",
	 *     name = "app_article_show",
	 *     requirements = {"id"="\d+"}
	 * )
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
	 * @Rest\Post("/candidats")
	 * @Rest\View
	 * @ParamConverter("candidat", converter="fos_rest.request_body")
	 */
	public function createAction(Candidat $candidat)
	{
		dump($candidat); die;
	}
}
