<?php

namespace Lime\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Lime\BaseBundle\Controller\BaseController;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class DefaultController extends BaseController
{
    /**
     * @Route("/", name="lime.admin.default.index")
     * @Template
     */
    public function indexAction()
    {
    }

    /**
     * Twig helper for message count.
     */
    public function getUnreadMessagesAction()
    {
        $unread = count($this->getMessageRepo()->findBy(array(
            'status_read' => false
        )));

        return $this->render('LimeAdminBundle:Default:get-unread-messages.html.twig', array(
            'unread'   => $unread,
        ));
    }

    /**
     *
     * @return \Lime\BaseBundle\Repository\BaseRepository
     */
    protected function getMessageRepo()
    {
        return $this->getRepo('LimeAdminBundle:Message');
    }
}