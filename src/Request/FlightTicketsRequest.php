<?php

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightTicketsRequest extends AbstractRequest
{
    public $ticketID;
    public $flightID;
    public $airplaneClass;
    public $surname;
    public $name;
    public $destination;
    public $checkout = false;
    public $departureDate;
    public $departureTime;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(
            [
                'ticketID',
                'flightID',
                'airplaneClass',
                'surname',
                'name',
                'destination',
                'checkout',
                'departureDate',
                'departureTime'
            ]
        );

        $resolver->addAllowedTypes('ticketID', 'numeric');
        $resolver->addAllowedValues('ticketID', $this->isPositive);
        $resolver->addAllowedTypes('flightID', 'numeric');
        $resolver->addAllowedValues('flightID', $this->isPositive);
        $resolver->addAllowedTypes('airplaneClass', 'string');
        $resolver->addAllowedTypes('surname', 'string');
        $resolver->addAllowedTypes('name', 'string');
        $resolver->addAllowedTypes('destination', 'string');
        $resolver->addAllowedTypes('checkout', 'string');
        $resolver->addAllowedValues('checkout', ['true','false']);
        $resolver->addAllowedTypes('departureDate', 'string');
        $resolver->addAllowedValues('departureDate', $this->isDate);
        $resolver->addAllowedTypes('departureTime', 'string');
        $resolver->addAllowedValues('departureTime', $this->isTime);
    }
}
