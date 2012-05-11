<?php

namespace Lime\FrontendBundle\Controller;

use Lime\BaseBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Lime\FrontendBundle\Entity\Page;
use Lime\FrontendBundle\Form\PageType;
use Lime\FrontendBundle\Entity\Contact;
use Lime\FrontendBundle\Form\ContactType;

class PageController extends BaseController
{

    public function indexAction()
    {
        $this->container->get('base_service_factory');
        return $this->render("LimeFrontendBundle:Page:index.html.twig");
    }

    public function aboutAction()
    {
        return $this->render("LimeFrontendBundle:Page:about.html.twig");
    }

    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($contact);
                $em->flush();

                return $this->render("LimeFrontendBundle:Page:contact_success.html.twig");
            }

        }

        return $this->render("LimeFrontendBundle:Page:contact.html.twig", array('form' => $form->createView()));
    }

}

