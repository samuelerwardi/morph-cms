<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Breeding;
use Pimcore\Model\DataObject\Feedings;
use Pimcore\Model\DataObject\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends FrontendController
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
        $data = new Product\Listing();

        return ["products" => $data->load()];
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
        $products = new Product\Listing();
        $products->setCondition("o_key = ?", $key);
        $breedings = new Breeding\Listing();
        if ($products->getTotalCount() == 1) {
            $product = $products->load()[0];
            $breedings->setCondition("hatchLink like '%,object|".$product->getId().",%'");
            $feedings = new Feedings\Listing();
            $feedings->setCondition("product__id = ?", $product->getId());
            return ["product" => $product, "breeding" => $breedings, "feedings" => $feedings->load()];
        }

        return $this->redirect("/");
    }
}
