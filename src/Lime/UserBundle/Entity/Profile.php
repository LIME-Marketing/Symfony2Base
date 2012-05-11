<?php

namespace Lime\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Lime\BaseBundle\Model\AbstractEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="lime_profile")
 * @ORM\HasLifecycleCallbacks
 */
class Profile extends AbstractEntity
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="User", cascade={"persist"}, inversedBy="profile")
     */
    protected $user;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phoneNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $zip;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $location;

    public function __construct()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setzip($zip)
    {
        $this->zip = $zip;
    }

    public function getzip()
    {
        return $this->zip;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
