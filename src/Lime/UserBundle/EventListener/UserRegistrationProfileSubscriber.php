<?php

namespace Lime\UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Lime\UserBundle\Events;
use Lime\UserBundle\Event\UserEvent;
use Lime\UserBundle\Entity\Profile;

/**
 * @author Derek Stobbe <djstobbe@gmail.com>
 */
class UserRegistrationProfileSubscriber implements EventSubscriberInterface
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function createProfile(UserEvent $event)
    {
        $user = $event->getUser();
        $isFacebookRegistration = $event->isFacebookRegistration();

        $profile = new Profile();
        $profile->setUser($user);
        
        if ($isFacebookRegistration) {
            $fbdata = $event->getFbdata();
            if ($fbdata) {
                $profile->setFBData($fbdata);
            }
        }

        $this->em->persist($profile);
        $this->em->flush();
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::USER_POST_REGISTER => 'createProfile',
        );
    }
}
