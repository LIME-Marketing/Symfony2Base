<?php

namespace Lime\UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Lime\BaseBundle\Factory\BaseRepoFactory;
use Lime\UserBundle\Event\UserEvent;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class UserEventListener implements EventSubscriberInterface
{
    protected $profileRepo;

    /**
     *
     * @param BaseRepoFactory $baseRepo 
     */
    public function __construct(BaseRepoFactory $baseRepo)
    {
        $this->profileRepo = $baseRepo->get('LimeUserBundle:Profile');
    }

    /**
     * Creates the user profile upon registration
     * 
     * @param UserEvent $event 
     */
    public function createProfile(UserEvent $event)
    {
        $user    = $event->getUser();
        $profile = $this->profileRepo->create();

        $profile->setUser($user);
        $this->profileRepo->save($profile);
    }

    /**
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'lime_user.user.post_register' => 'createProfile',
        );
    }
}
