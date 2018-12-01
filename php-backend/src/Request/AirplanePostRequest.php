<?php

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class AirplanePostRequest extends AbstractRequest
{

    public $id;
    public $type;
    public $crewNumber;
    public $dateOfProduction;
    public $dateOfRevision;
    public $seats;
    public $updatedSeats;
    public $deletedSeats;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            'id',
            'type',
            'crewNumber',
            'dateOfProduction',
            'dateOfRevision',
            'seats',
            'updatedSeats',
            'deletedSeats'
        ]);

        $resolver->addAllowedTypes('id', 'numeric');
        $resolver->addAllowedValues('id', $this->isPositive);
        $resolver->addAllowedTypes('type', 'numeric');
        $resolver->addAllowedValues('type', $this->isPositive);
        $resolver->addAllowedTypes('crewNumber', 'numeric');
        $resolver->addAllowedValues('crewNumber', $this->isPositive);
        $resolver->addAllowedTypes('dateOfProduction', 'string');
        $resolver->addAllowedValues('dateOfProduction', $this->isDate);
        $resolver->addAllowedTypes('dateOfRevision', 'string');
        $resolver->addAllowedValues('dateOfRevision', $this->isDate);
        $resolver->addAllowedTypes('seats', 'array');
        $resolver->addAllowedTypes('deletedSeats', 'array');
        $resolver->addAllowedTypes('updatedSeats', 'array');
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setRequiredOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
           'crewNumber',
           'dateOfProduction',
           'dateOfRevision',
           'type'
        ]);
    }
}
