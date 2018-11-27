<?php

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class AirplaneTypePostRequest extends AbstractRequest
{
    public $id;
    public $name;
    public $manufacturer;
    public $gates;
    public $deletedGates;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            'id',
            'name',
            'gates',
            'manufacturer',
            'deletedGates'
        ]);

        $resolver->addAllowedTypes('id', 'numeric');
        $resolver->addAllowedValues('id', $this->isPositive);
        $resolver->addAllowedTypes('name', 'string');
        $resolver->addAllowedTypes('gates', 'array');
        $resolver->addAllowedTypes('deletedGates', 'array');
        $resolver->addAllowedTypes('manufacturer', 'string');
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setRequiredOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name',
            'manufacturer'
        ]);
    }
}
