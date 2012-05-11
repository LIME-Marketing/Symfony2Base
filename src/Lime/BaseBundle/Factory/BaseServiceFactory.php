<?php

namespace Lime\BaseBundle\Factory;

use Symfony\Component\DependencyInjection\Container;
use Lime\BaseBundle\Model\BaseFactoryModel;

/**
 * Class for generating services using given class names. 
 * 
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class BaseServiceFactory extends BaseFactoryModel
{
    protected $container;
    protected $services;

    /**
     *
     * @param Container $container 
     */
    public function __construct(Container $container)
    {
        parent::__construct();
        $this->container = $container;
        $this->services  = array();
    }

    /**
     * Creates and returns a Service class.
     *
     * @example $this->get('AcmeTestBundle:TestService');
     * @param string $class The short namespace of 
     * service class requested.
     * 
     * @return Service
     * @throws InvalidArgumentException 
     */
    public function get($class)
    {
        if (array_key_exists($class, $this->services)) {
            return $this->services[$class];
        }

        $path = $this->parser->getPath($class, 'Service', 'Service');
        $this->service[$class] = new $path($this->container);

        return $this->service[$class];
    }
}