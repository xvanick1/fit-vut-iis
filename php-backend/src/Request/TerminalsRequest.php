<?php

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class TerminalsRequest extends AbstractRequest
{
    public $id;
    public $name;
    public $countOfGates;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            'id',
            'name',
            'countOfGates'
        ]);

        $resolver->addAllowedTypes('id','numeric');
        $resolver->addAllowedValues('id', $this->isPositive);
        $resolver->addAllowedTypes('name','string');
        $resolver->addAllowedTypes('countOfGates','numeric');
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setRequiredOptions(OptionsResolver $resolver) { }
}
