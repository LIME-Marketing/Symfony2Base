<?php

namespace Lime\BaseBundle\Factory;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\MappingException;
use Lime\BaseBundle\Repository\BaseRepository;
use Lime\BaseBundle\Model\BaseFactoryModel;

/**
 * Class for generating repositories using given class names. 
 * 
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class BaseRepoFactory extends BaseFactoryModel
{
    protected $em;
    protected $dispatcher;
    protected $repositories;

    /**
     *
     * @param EventDispatcherInterface $dispatcher
     * @param EntityManager $em
     * @param Container $container 
     */
    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em)
    {
        parent::__construct();
        $this->em           = $em;
        $this->dispatcher   = $dispatcher;
        $this->repositories = array();
    }

    /**
     * Creates and returns a BaseRepository.
     *
     * @example $this->get('AcmeTestBundle:TestEntity');
     * @param string $class The short namespace of 
     * repository class requested.
     * @param boolean $custom Set to true if the repository
     * is an extension of the BaseRepository
     * 
     * @return BaseRepository|repoClass
     * @throws InvalidArgumentException 
     */
    public function get($class, $custom = false)
    {
        if (array_key_exists($class, $this->repositories)) {
            return $this->repositories[$class];
        }

        if ($custom) {
            $path = $this->parser->getPath($class, 'Repository', 'Repository');
            $this->repositories[$class] = new $path($this->dispatcher, $this->em);
        }
        else {
            $metadata  = $this->em->getClassMetadata($class);
            $repoClass = $metadata->rootEntityName;

            if (!class_exists($repoClass)) {
                throw new InvalidArgumentException('Invalid Class: The class "'.$class.'" could not be found!');
            }

            $this->repositories[$class] = new BaseRepository($this->dispatcher, $this->em, $repoClass);
        }

        return $this->repositories[$class];
    }
}