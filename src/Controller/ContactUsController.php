<?php

namespace App\Controller;

use App\Helper\ObjectHelper;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\ContactUs;
use Pimcore\Model\WebsiteSetting;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class ContactUsController extends FrontendController
{
    private $basePath = "ContactUs";

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
     * @Route("/contact-us-store", name="contact_us_store")
     * @Method("POST")
     */
    public function storeAction(Request $request)
    {
        $firstName = $request->get("contact_first_name");
        $lastName = $request->get("contact_last_name");
        $email = $request->get("contact_email");
        $subject = $request->get("contact_subject");
        $message = $request->get("contact_message");

        $contactUs = new ContactUs();
        $contactUs->setKey(Uuid::uuid4());
        $contactUs->setParentId(ObjectHelper::generateBashPath($this->basePath)->getId());
        $contactUs->setFirstName($firstName);
        $contactUs->setLastName($lastName);
        $contactUs->setEmail($email);
        $contactUs->setSubject($subject);
        $contactUs->setMessage($message);
        $contactUs->setPublished(true);
        try {
            $result = $contactUs->save();
            return $this->redirect(WebsiteSetting::getByName("CONTACT_US_REDIRECT")->getData()->getFullPath() . "?success=true");
        } catch (\Exception $exception) {
            return $this->redirect(WebsiteSetting::getByName("CONTACT_US_REDIRECT")->getData()->getFullPath() . "?success=false");
        }


    }
}
