<?php

namespace Lime\AdminBundle\Constant;

class ConfigConstants
{
    //config fields
    protected $configArray;

    public function __construct(array $configArray)
    {
        $this->configArray = $configArray;
    }

    public function getConfigs()
    {
        return $this->configArray;
    }
}
