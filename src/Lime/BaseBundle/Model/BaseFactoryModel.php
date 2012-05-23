<?php

namespace Lime\BaseBundle\Model;

use Lime\BaseBundle\Model\BaseFactoryInterface;
use Lime\BaseBundle\Model\BaseNamespaceParser;

/**
 * Description of BaseFactoryModel
 *
 * @author Michael Shattuck <ms2474@gmail.com>
 */
abstract class BaseFactoryModel implements BaseFactoryInterface
{
    /* @var $parser \Lime\BaseBundle\Model\BaseNamespaceParser */
    protected $parser;


    public function __construct()
    {
        $this->parser = new BaseNamespaceParser();
    }

    /**
     * {@inheritDoc}
     */
    abstract function get($class);
}