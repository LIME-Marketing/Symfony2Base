<?php

namespace Lime\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Lime\UserBundle\Entity\User;

/**
 * @author Derek Stobbe <djstobbe@gmail.com>
 */
class  UserEvent extends Event
{
    protected $user;
    protected $confirmation;
    protected $fbdata;
    protected $isFacebookRegistration;

    public function __construct(User $user, $confirmation, $fbdata = null, $isFacebookRegistration = false)
    {
        $this->user = $user;
        $this->confirmation = $confirmation;
        $this->fbdata = $fbdata;
        $this->isFacebookRegistration = $isFacebookRegistration;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getConfirmation()
    {
        return $this->confirmation;
    }

    public function getFbdata()
    {
        return $this->fbdata;
    }

    public function isFacebookRegistration()
    {
        return $this->isFacebookRegistration;
    }
}
