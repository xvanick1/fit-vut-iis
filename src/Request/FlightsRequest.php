<?php

namespace App\Request;


use AppBundle\Request\AbstractRequest;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightsRequest extends AbstractRequest
{
    public $departureDate;
    public $departureTime;
    public $flightID;
    public $terminalID;
    public $gateID;
    public $destination;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefined(
            [
                'departureDate',
                'departureTime',
                'flightID',
                'terminalID',
                'gateID',
                'destination'
            ]
        );

        $resolver->addAllowedTypes('departureDate', 'DateTime');
        $resolver->addAllowedTypes('departureTime', 'string');
        $resolver->addAllowedTypes('flightID', 'numeric');
        $resolver->addAllowedValues('flightID', $this->isPositive);
        $resolver->addAllowedTypes('terminalID', 'numeric');
        $resolver->addAllowedValues('terminalID', $this->isPositive);
        $resolver->addAllowedTypes('gateID', 'numeric');
        $resolver->addAllowedValues('gateID', $this->isPositive);
        $resolver->addAllowedTypes('destination', 'string');
    }
}
