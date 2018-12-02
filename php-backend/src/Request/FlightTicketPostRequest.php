<?php

namespace App\Request;

use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightTicketPostRequest extends AbstractRequest
{
    public $name;
    public $surname;
    public $seat;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
           'name',
           'surname',
           'seat'
        ]);

        $resolver->addAllowedTypes('name', 'string');
        $resolver->addAllowedTypes('surname', 'string');
        $resolver->addAllowedTypes('seat', 'numeric');
        $resolver->addAllowedValues('seat', $this->isPositive);
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setRequiredOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
           'name',
           'surname',
           'seat'
        ]);
    }
}
