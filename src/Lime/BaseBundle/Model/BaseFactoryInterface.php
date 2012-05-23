<?php

namespace Lime\BaseBundle\Model;

/**
 * Description of BaseFactoryInterface
 *
 * @author Michael Shattuck <ms2474@gmail.com>
 */
interface BaseFactoryInterface
{
    /**
     * Function for retreiving classes.
     *  
     * @param string $class Short namespace for
     * the class being requested.
     */
    function get($class);
}