<?php

namespace Lime\UserBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use Lime\UserBundle\Events;
use Lime\UserBundle\Event\UserEvent;

/**
 * @author Derek Stobbe <djstobbe@gmail.com>
 */
class RegistrationFormHandler extends BaseHandler
{
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher, Form $form, Request $request, UserManagerInterface $userManager, MailerInterface $mailer)
    {
        $this->dispatcher = $dispatcher;
        parent::__construct($form, $request, $userManager, $mailer);
    }

    protected function onSuccess(UserInterface $user, $confirmation)
    {
        $this->dispatcher->dispatch(Events::USER_PRE_REGISTER, new UserEvent($user, $confirmation));
        parent::onSuccess($user, $confirmation);
        $this->dispatcher->dispatch(Events::USER_POST_REGISTER, new UserEvent($user, $confirmation));
    }
}
