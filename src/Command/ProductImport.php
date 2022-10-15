<?php
/**
 * Created by PhpStorm.
 * User: Malik Al Ichsan <malik.ichsan@salt.co.id>
 */

namespace App\Command;

use App\Helper\Folder;
use App\Helper\GeneralHelper;
use App\Helper\ObjectHelper;
use DateTime;
use Exception;
use Pimcore\Console\AbstractCommand;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject\Data\Hotspotimage;
use Pimcore\Model\DataObject\Data\ImageGallery;
use Pimcore\Model\DataObject\Measurement;
use Pimcore\Model\DataObject\Morph;
use Pimcore\Model\DataObject\Product;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductImport extends AbstractCommand
{
    protected $uploadDir = '/public/var/assets';
    protected $folder = '/Dropbox/Image/';

    protected function configure()
    {
        $this->setName('product:import')
            ->setDescription('Product Import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Show when the script is launched
        $now = new DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y H:i:s') . ' </comment>');

        // Import CSV on DB
        $this->import($input, $output);

        // Show when the script is over
        $now = new DateTime();
        $output->writeln('');
        $output->writeln('<comment>End : ' . $now->format('d-m-Y H:i:s') . ' </comment>');
    }

    private function listOfMorph(string $morphs)
    {
        $result = [];
        $morphs = explode(",", $morphs);
        foreach ($morphs as $item) {
            $morph = Morph::getByName(ltrim(rtrim($item)), 1);
            $result[] = $morph;
        }
        return $result;
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        $fileName = Asset::getByPath("/Dropbox/morph-product.xlsx");
        $fileName = PIMCORE_PROJECT_ROOT . $this->uploadDir . $fileName;
        $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileName);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheets[$worksheet->getTitle()] = $worksheet->toArray();
        }
        foreach ($worksheets as $worksheet) {
            $progress = new ProgressBar($output, count($worksheet));
            $progress->start();
            foreach ($worksheet as $index => $item) {
                if ($index > 0) {
                    $assets = new Asset\Listing();
//                $kode = "21-M15 Pastel DG het Pied";
                    $kode = $item[0] . " " . GeneralHelper::clean($item[4]);
                    $assets->setCondition('filename LIKE ? AND path = ?', ["%" . $kode . "%", $this->folder]);
                    $asset = "";
                    if ($assets->getCount() == 0) {
                        $output->writeln("[image_not_found] filename : $kode ");
                    } else {
                        if ($assets->getCount() == 1) {
                            $asset = $assets->load()[0];
                        } else {
                            $output->writeln("[image_result_too_many] filename : $kode ");
                            $asset = $assets->load()[0];
                        }
                    }


                    $morphs = explode(",", $item[5]);
                    if (is_array($morphs) && !empty($morphs)) {
                        foreach ($morphs as $morph) {
                            $result = Morph::getByName(ltrim(rtrim($morph)));
                            if ($result->getCount() == 0 && !empty(ltrim(rtrim($morph)))) {
                                $morph_create = new Morph();
                                $folder = Folder::checkAndCreate('Morph');
                                $morph_create->setParentId($folder->getId());
                                $morph_create->setPublished(true);
                                $morph_create->setKey(ltrim(rtrim($morph)));
                                $morph_create->setName(ltrim(rtrim($morph)));
                                $morph_create->save();
                            }
                        }
                    }
                    /*
                     * 0 = Kode
                     * 1 = Year
                     * 2 = Weight
                     * 3 = Sex
                     * 4 = Name
                     * 5 = Morph
                     */
//                    dd($this->listOfMorph($item[5]));
                    $checkProduct = new Product\Listing();
                    $checkProduct->addConditionParam("name = ? AND identity = ?", [GeneralHelper::clean($item[4]), $item[0]]);
                    if ($checkProduct->getCount() == 0) {
                        $product = new Product();
                        $folder = Folder::checkAndCreate('Product');
                        $folderChild = Folder::checkAndCreate(GeneralHelper::clean($item[1]), $folder);
                        $product->setParentId($folderChild->getId());
                        $product->setPublished(true);
                        $product->setKey($item[0] . "-" . GeneralHelper::clean($item[4]));
                        $product->setName(GeneralHelper::clean($item[4]));
                        $product->setIdentity(ltrim(rtrim($item[0])));
                        $product->setSex(strtoupper($item[3]));
                        $product->setStatus("HOLD_BACK");
                        $product->setIdr(0);
                        $product->setUsd(0);
                        $product->setDob(GeneralHelper::clean($item[1]));
                        $product->setMorph($this->listOfMorph($item[5]));
                        if (!empty($asset)) {
                            $hotspotImage = new Hotspotimage();
                            $hotspotImage->setImage($asset);
                            $product->setImages(new ImageGallery([$hotspotImage]));
                        }
                        $productResult = $product->save();

                        /** insert weight */
                        $measurement = new Measurement();
                        $folder = Folder::checkAndCreate('Measurement');
                        $folderChild = Folder::checkAndCreate(date("Y-m-d H-i-s"), $folder);
                        $measurement->setParentId($folderChild->getId());
                        $measurement->setPublished(true);
                        $measurement->setKey($item[0]."-".GeneralHelper::clean($item[4]));
                        $measurement->setProduct($productResult);
                        $measurement->setWeight(floatval($item[2]));
                        $measurement->setUnit("GRAM");
                        $measurement->save();
                    } else {
                        $output->writeln("[product_is_exist][name] : '" . GeneralHelper::clean($item[4]) . "[identity] : '" . $item[0] . " ");
                    }
                }
//                if ($index == 3) {
//                    dump($this->listOfMorph($item[5]));
//                    die;
//                }

                // Ending the progress bar process
            }
            $progress->finish();
        }
    }
}
