<?php

namespace Lime\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Lime\UserBundle\Entity\User;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class  UserEvent extends Event
{
    protected $user;
    protected $confirmation;

    /**
     *
     * @param User $user
     * @param type $confirmation 
     */
    public function __construct(User $user, $confirmation)
    {
        $this->user         = $user;
        $this->confirmation = $confirmation;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return wild
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }
}
