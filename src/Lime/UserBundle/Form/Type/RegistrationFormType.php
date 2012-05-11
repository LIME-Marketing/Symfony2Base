<?php

namespace Lime\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilder;

/**
 * @author Derek Stobbe <djstobbe@gmail.com>
 */
class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'attr' => array(
                    'placeholder' => 'username',
                    'class' => 'span4'
                ),
            ))
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'email',
                    'class' => 'span4'
                ),
            ))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array(
                    'attr' => array(
                        'class' => 'span4',
                        'placeholder' => 'password'
                    ),
                )
            ))
        ;
    }
}
