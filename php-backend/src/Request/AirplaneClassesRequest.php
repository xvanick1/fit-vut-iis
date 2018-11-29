<?php

namespace App\Request;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AirplaneClassesRequest
 * @package App\Request
 */
class AirplaneClassesRequest extends AbstractRequest
{

    public $name;
    public $countOfSeats;
    public $countOfAirplanes;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(
            [
                'name',
                'countOfSeats',
                'countOfAirplanes',
            ]
        );

        $resolver->addAllowedTypes('name', 'string');
        $resolver->addAllowedTypes('countOfSeats', 'numeric');
        $resolver->addAllowedValues('countOfSeats', $this->isPositive);
        $resolver->addAllowedTypes('countOfAirplanes', 'numeric');
        $resolver->addAllowedValues('countOfAirplanes', $this->isPositive);
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setRequiredOptions(OptionsResolver $resolver) {}
}
