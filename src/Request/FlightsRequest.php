<?php

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightsRequest extends AbstractRequest
{
    public $departureDate;
    public $departureTime;
    public $flightID;
    public $terminal;
    public $gate;
    public $destination;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(
            [
                'departureDate',
                'departureTime',
                'flightID',
                'terminal',
                'gate',
                'destination'
            ]
        );

        $resolver->addAllowedTypes('departureDate', 'string');
        $resolver->addAllowedValues('departureDate', $this->isDate);
        $resolver->addAllowedTypes('departureTime', 'string');
        $resolver->addAllowedValues('departureTime', $this->isTime);
        $resolver->addAllowedTypes('flightID', 'numeric');
        $resolver->addAllowedValues('flightID', $this->isPositive);
        $resolver->addAllowedTypes('terminal', 'string');
        $resolver->addAllowedTypes('gate', 'string');
        $resolver->addAllowedTypes('destination', 'string');
    }
}
