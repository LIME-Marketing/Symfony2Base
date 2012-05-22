<?php

namespace Lime\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Lime\BaseBundle\Controller\BaseController;
use Lime\AdminBundle\Entity\Message;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 * @Route("/messages")
 */
class MessageController extends BaseController
{
    /**
     *
     * @Route("/", name="lime.admin.message.list")
     * @Template
     */
    public function listAction()
    {
        return array(
            'messages' => $this->getMessageRepo()->findAll(),
        );
    }

    /**
     *
     * @Route("/{slug}", name="lime.admin.message.show")
     * @Template(vars={"message"})
     * @ParamConverter("message", class="LimeAdminBundle:Message")
     */
    public function showAction(Message $message)
    {
        if (!$message->isRead()) {
            $message->read();
            $this->getMessageRepo()->save($message);
        }
    }

    /**
     *
     * @Route("/{slug}", name="lime.admin.message.show")
     * @Template()
     * @ParamConverter("message", class="LimeAdminBundle:Message")
     */
    public function unreadAction(Message $message)
    {
        $messages = $this->getMessageRepo()->findAll();

        $message->unread();
        $this->getMessageRepo()->save($message);

        return array(
            'messages' => $messages,
        );
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