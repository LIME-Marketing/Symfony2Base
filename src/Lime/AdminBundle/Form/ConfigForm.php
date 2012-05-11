<?php

namespace Lime\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ConfigForm extends AbstractType
{
    protected $configs;

    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        foreach ($this->configs as $config) 
        {
            $builder->add((string)$config->getConfigId(), 'integer', array(
                'required' => true,
                'data'     => $config->getValue(),
            ));
        }
    }

    public function getName()
    {
        return 'lime_admin_config_form';
    }
}
