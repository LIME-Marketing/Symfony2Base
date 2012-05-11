<?php

namespace Lime\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Lime\BaseBundle\Model\EntityInterface;

/**
 * @author Derek Stobbe <djstobbe@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser implements EntityInterface
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Profile", mappedBy="user", cascade={"persist"})
     */
    protected $profile;

    public function __construct()
    {
        parent::__construct();
    }

    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
