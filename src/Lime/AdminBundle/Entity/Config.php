<?php

namespace Lime\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lime\BaseBundle\Model\AbstractEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="lime_admin_config") 
 */
class Config extends AbstractEntity
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string") 
     */
    protected $name;

    /**
     * @ORM\Column(type="string") 
     */
    protected $indexName;

    /**
     * @ORM\Column(type="string")  
     */
    protected $description;

    /**
     * @ORM\Column(type="string")  
     */
    protected $value;

    /**
     * Set config_id
     *
     * @param integer $configId
     * @return Config
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get config_id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Config
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set indexName
     *
     * @param string $indexName
     * @return Config
     */
    public function setIndexName($indexName)
    {
        $this->indexName = $indexName;
        return $this;
    }

    /**
     * Get indexName
     *
     * @return string 
     */
    public function getIndexName()
    {
        return $this->indexName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Config
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set value
     *
     * @param string|integer|boolean $value
     * @return Config
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value
     *
     * @return string|integer|boolean 
     */
    public function getValue()
    {
        return $this->value;
    }
}