<?php

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightTicketsRequest extends AbstractRequest
{
    public $ticketID;
    public $flightID;
    public $airplaneClassID;
    public $surname;
    public $name;
    public $destination;
    public $checkout;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(
            [
                'ticketID',
                'flightID',
                'airplaneClassID',
                'surname',
                'name',
                'destination',
                'checkout'
            ]
        );

        $resolver->addAllowedTypes('ticketID', 'numeric');
        $resolver->addAllowedValues('ticketID', $this->isPositive);
        $resolver->addAllowedTypes('flightID', 'numeric');
        $resolver->addAllowedValues('flightID', $this->isPositive);
        $resolver->addAllowedTypes('airplaneClassID', 'numeric');
        $resolver->addAllowedValues('airplaneClassID', $this->isPositive);
        $resolver->addAllowedTypes('surname', 'string');
        $resolver->addAllowedTypes('name', 'string');
        $resolver->addAllowedTypes('destination', 'string');
        $resolver->addAllowedTypes('checkout', 'bool');
    }
}
