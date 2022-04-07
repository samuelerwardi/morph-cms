<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class BreedingController extends FrontendController
{
    /**
     * @Template
     *
     * @param Request $request
     *
     * @return array
     */
    public function defaultAction(Request $request)
    {
        return [];
    }

    /**
     * @Template
     *
     * @param Request $request
     *
     * @return array
     */
    public function detailAction(Request $request)
    {
        return $this->render('breeding/detail.html.twig', ['param1' => 'value1']);
    }
}
