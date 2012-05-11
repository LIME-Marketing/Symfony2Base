<?php

namespace Lime\BaseBundle\Model;

use Lime\BaseBundle\Model\BaseNamespaceParser;

/**
 * Description of BaseFactoryModel
 *
 * @author Michael Shattuck <ms2474@gmail.com>
 */
abstract class BaseFactoryModel
{
    protected $parser;

    public function __construct()
    {
        $this->parser = new BaseNamespaceParser();
    }
    
    abstract function get($class);
}