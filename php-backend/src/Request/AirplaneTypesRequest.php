<?php

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class AirplaneTypesRequest extends AbstractRequest
{
    public $name;
    public $manufacturer;
    public $countOfAirplanes;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            'name',
            'manufacturer',
            'countOfAirplanes'
        ]);

        $resolver->addAllowedTypes('name', 'string');
        $resolver->addAllowedTypes('manufacturer', 'string');
        $resolver->addAllowedTypes('countOfAirplanes', 'numeric');
        $resolver->addAllowedValues('countOfAirplanes', $this->isPositive);
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setRequiredOptions(OptionsResolver $resolver) {}
}
