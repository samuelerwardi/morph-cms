<?php

namespace App\Controller;

use Pimcore\Model\DataObject\Product;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Breeding;
use Pimcore\Tool;
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
//        dd(\Pimcore\Tool::getHostUrl());
        $data = new Breeding\Listing();
//        dd($data->load()[0]->getImages()->getItems()[0]->getImage()->getFullPath());
        return ["breedings" => $data->load()];
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
//        dd($request->attributes);
        $key = $request->get("id");
        $breedings = new Breeding\Listing();
        $breedings->setCondition("o_key = ?", strtoupper($key));
        if ($breedings->getTotalCount() == 1) {
            $datas = $breedings->load()[0];
//            $products = new Product\Listing();
            $products = Product::getByClutch($datas);
            return ["breeding" => $datas, "products" => $products->load()];
        }
        return $this->redirect("/");
    }
}
