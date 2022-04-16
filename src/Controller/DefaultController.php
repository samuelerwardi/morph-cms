<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Db;
use Pimcore\Model\DataObject\Breeding;
use Pimcore\Model\DataObject\Feedings;
use Pimcore\Model\DataObject\Measurement;
use Pimcore\Model\DataObject\Morph;
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
        $searchByMorph = $request->get("morph");
        $searchByGender = $request->get("gender");
        $searchByDob = $request->get("dob");
        $searchByStatus = $request->get("status");
        $data = new Product\Listing();
        if ($searchByStatus) {
//            dd($searchByStatus);
            $data->addConditionParam("status IN (?)", [$searchByStatus]);
        }
        if ($searchByDob) {
            $data->addConditionParam("dob IN (?)", [$searchByDob]);
        }
        if ($searchByGender) {
            $data->addConditionParam("sex IN (?)", [$searchByGender]);
        }
        if ($searchByMorph) {
            $query = "";
            $morphs = new Morph\Listing();
            $morphs->setCondition("name IN (?)", [$searchByMorph]);
            if ($morphs->getTotalCount() > 0) {
                foreach ($morphs->load() as $index => $value) {
                    $query .= " morph LIKE '%".$value->getId()."%'";
                    if ($index !== $morphs->getTotalCount() - 1) {
                        $query .= " OR";
                    }
                }
            }

//            dump($query);
            $data->addConditionParam($query);
        }
//        echo $data->getQueryBuilder()->getSQL();die;
//        dd($data->getQueryBuilder()->getParameters());
//        dd($data->load());
        $morphs = new Morph\Listing();
        $dob = Db::get()->query("SELECT dob from object_Product group by dob")->fetchAll();

        return $this->render("default/default-filter.html.twig",
            ["products" => $data->load(), "morphs" => $morphs->load(), "dobs" => $dob]);

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
            $measurements = new Measurement\Listing();
            $measurements->setCondition("product__id = ?", $product->getId());
            $measurements->setOrderKey("oo_id")->setOrder("DESC")->setLimit(1);
            $measurement = null;
            if ($measurements->getTotalCount() > 0) {
                $measurement = $measurements->load()[0];
            }

            return [
                "product" => $product,
                "breeding" => $breedings,
                "feedings" => $feedings->load(),
                "measurement" => $measurement,
            ];
        }

        return $this->redirect("/");
    }
}
