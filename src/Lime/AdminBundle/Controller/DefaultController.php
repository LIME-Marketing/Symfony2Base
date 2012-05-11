<?php

namespace Lime\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Lime\BaseBundle\Controller\BaseController;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        $repo   = $this->getMessageRepo();
        $unread = count($repo->findBy(array(
            'status_read' => false
        )));

        return $this->render('LimeAdminBundle:Default:index.html.twig', array(
            'unread'   => $unread,
        ));
    }

    public function getUnreadMessagesAction()
    {
        $repo   = $this->getMessageRepo();
        $unread = count($repo->findBy(array(
            'status_read' => false
        )));

        return $this->render('LimeAdminBundle:Default:get-unread-messages.html.twig', array(
            'unread'   => $unread,
        ));
    }

    protected function getMessageRepo()
    {
        return $this->getRepo('LimeAdminBundle:Message');
    }
}