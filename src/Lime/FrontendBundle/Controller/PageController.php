<?php

namespace Lime\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Lime\BaseBundle\Controller\BaseController;
use Lime\FrontendBundle\Entity\Page;
use Lime\FrontendBundle\Form\PageType;
use Lime\FrontendBundle\Entity\Contact;
use Lime\FrontendBundle\Form\ContactType;

/**
 * Controller for static pages.
 */
class PageController extends BaseController
{

    /**
     * Front Page
     * 
     * @Route("/", name="lime.frontend.page.index")
     * @Template
     */
    public function indexAction()
    {
    }

    /**
     * About Page
     * 
     * @Route("/about", name="lime.frontend.page.about")
     * @Template
     */
    public function aboutAction()
    {
    }

    /**
     * Contact Page
     * 
     * @Route("/contact", name="lime.frontend.page.contact")
     * @Template
     */
    public function contactAction(Request $request)
    {
        $contact = $this->getContactRepo()->create();
        $form    = $this->createForm(new ContactType(), $contact);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()){
                $this->getContactRepo()->save($contact);

                return $this->render("LimeFrontendBundle:Page:contact_success.html.twig");
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     *
     * @return \Lime\BaseBundle\Repository\BaseRepository
     */
    public function getContactRepo()
    {
        return $this->getRepo('LimeFrontendBundle:Contact');
    }
}

