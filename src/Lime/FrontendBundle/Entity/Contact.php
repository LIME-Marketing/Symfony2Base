<?php

namespace Lime\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lime_contact")
 */
class Contact
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="text")
     */
    protected $message;

    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName( $name )
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail( $email )
    {
        $this->email = $email;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage( $message )
    {
        $this->message = $message;
    }

}
