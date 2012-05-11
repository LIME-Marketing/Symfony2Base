<?php

namespace Lime\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Lime\BaseBundle\Model\AbstractEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="lime_admin_messages")
 * @ORM\HasLifecycleCallbacks 
 */
class Message extends AbstractEntity
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="string")
     */
    protected $subject;

    /**
     * @ORM\Column(type="string")
     * @Gedmo\Slug(fields={"subject"})
     */
    protected $slug;

    /**
     * @ORM\Column(type="text")
     */
    protected $body;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $status_read;

    public function __construct()
    {
        $this->status_read = false;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set body
     *
     * @param text $body
     * @return Message
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Get body
     *
     * @return text 
     */
    public function getBody()
    {
        return $this->body;
    }

    public function read()
    {
        $this->status_read = true;
    }

    public function unread()
    {
        $this->status_read = false;
    }

    public function isRead()
    {
        return $this->status_read;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }
}