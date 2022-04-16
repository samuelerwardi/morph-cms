<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
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
        $data->setOrderKey("o_id")->setOrder("DESC");
        $data->setCondition("status = ?", ["AVAILABLE"]);
        $data->setLimit(4);
        return ["products" => $data->load()];
    }
}
