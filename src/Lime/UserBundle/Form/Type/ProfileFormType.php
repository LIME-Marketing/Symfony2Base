<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lime\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProfileFormType extends AbstractType
{

    public function getDefaultOptions()
    {
        return array(
            'data_class' => 'Lime\UserBundle\Entity\Profile',
            'intention'  => 'profile',
        );
    }

    public function getName()
    {
        return 'fos_user_profile';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilder $builder
     * @param array       $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', array(
                'label' => 'First Name',
                'required' => false
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last Name',
                'required' => false
            ))
            ->add('phoneNumber', 'text', array(
                'label' => 'Phone Number',
                'required' => false
            ))
            ->add('address', 'text', array(
                'required' => false
            ))
            ->add('city', 'text', array(
                'required' => false
            ))
            ->add('state', 'text', array(
                'required' => false
            ))
            ->add('zip', 'text', array(
                'required' => false
            ))
        ;
    }
}
