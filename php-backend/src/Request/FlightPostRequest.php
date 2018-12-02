<?php

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightPostRequest extends AbstractRequest
{
    public $id;
    public $dateOfDeparture;
    public $timeOfDeparture;
    public $flightLength;
    public $destination;
    public $airplane;
    public $gate;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
           'id',
           'dateOfDeparture',
           'timeOfDeparture',
           'flightLength',
           'destination',
           'airplane',
           'gate'
        ]);

        $resolver->addAllowedTypes('id', 'numeric');
        $resolver->addAllowedValues('id', $this->isPositive);
        $resolver->addAllowedTypes('dateOfDeparture', 'string');
        $resolver->addAllowedValues('dateOfDeparture', $this->isDate);
        $resolver->addAllowedTypes('timeOfDeparture', 'string');
        $resolver->addAllowedValues('timeOfDeparture', $this->isTime);
        $resolver->addAllowedTypes('flightLength', 'string');
        $resolver->addAllowedValues('flightLength', $this->isTime);
        $resolver->addAllowedTypes('destination', 'string');
        $resolver->addAllowedTypes('airplane', 'numeric');
        $resolver->addAllowedValues('airplane', $this->isPositive);
        $resolver->addAllowedTypes('gate', 'numeric');
        $resolver->addAllowedValues('gate', $this->isPositive);
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setRequiredOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'dateOfDeparture',
            'timeOfDeparture',
            'flightLength',
            'destination',
            'airplane',
            'gate'
        ]);
    }
}
