<?php

namespace Lime\FrontendBundle\Form;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('message')
        ;
    }

    public function getName()
    {
        return 'lime_frontend_contact';
    }
}
