<?php

namespace Lime\BaseBundle\Model;

/**
 * Description of BaseFactoryInterface
 *
 * @author Michael Shattuck <ms2474@gmail.com>
 */
interface BaseFactoryInterface
{
    /* @var $parser \Lime\BaseBundle\Model\BaseNamespaceParser */
    protected $parser;

    /**
     * Function for retreiving classes.
     *  
     * @param string $class Short namespace for
     * the class being requested.
     */
    function get($class);
}