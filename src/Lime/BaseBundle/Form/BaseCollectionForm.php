<?php

namespace Lime\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class BaseCollectionForm extends AbstractType
{
    protected $fields;
    protected $name;
    protected $getFunction;
    protected $identifierFunction;

    /**
     *
     * @param array $fields
     * @param type $name
     * @param type $identifierFunction
     * @param type $getFunction 
     */
    public function __construct(array $fields, $name, $identifierFunction, $getFunction)
    {
        $this->fields             = $fields;
        $this->name               = $name;
        $this->identifierFunction = $identifierFunction;
        $this->getFunction        = $getFunction;
    }

    /**
     *
     * @param FormBuilder $builder
     * @param array $options 
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $identifierFunction = $this->identifierFunction;
        $getFunction        = $this->getFunction;

        foreach ($this->fields as $field) {
            $fieldName = $field->$identifierFunction();

            $builder->add((string)$fieldName, gettype($fieldName), array(
                'required' => false,
                'data'     => $field->$getFunction(),
            ));
        }
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
