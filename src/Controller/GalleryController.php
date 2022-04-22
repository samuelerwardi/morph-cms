<?php

namespace App\Controller;

use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\GalleryFacilities;
use Pimcore\Model\DataObject\GallerySnacks;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;

class GalleryController extends FrontendController
{
    /**
     * @Template
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return array
     */
    public function defaultAction(Request $request, PaginatorInterface $paginator, PaginatorInterface $paginatorSnack)
    {
        $galleryFacilities = (new GalleryFacilities\Listing());
        $gallerySnacks = new GallerySnacks\Listing();
//        dd($gallerySnacks->load());
        $paginator = $paginator->paginate(
            $galleryFacilities,
            $request->get('page', 1),
            3
        );

        $paginatorSnack = $paginatorSnack->paginate(
            $gallerySnacks,
            $request->get('page_snack', 1),
            3
        );


        return ["gallerySnacks" => $gallerySnacks,
            "galleryFacilities" => $galleryFacilities,
            'paginator' => $paginator,
            'paginationVariables' => $paginator->getPaginationData(),
            'paginatorSnacks' => $paginatorSnack,
            'paginationSnacks' => $paginatorSnack->getPaginationData(),
        ];
    }
}
