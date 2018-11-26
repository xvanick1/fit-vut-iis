<?php

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class TerminalPostRequest extends AbstractRequest
{
    public $id;
    public $name;
    public $gates;
    public $deletedGates;
    public $updatedGates;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            'id',
            'name',
            'gates',
            'deletedGates',
            'updatedGates'
        ]);

        $resolver->addAllowedTypes('id', 'numeric');
        $resolver->addAllowedValues('id', $this->isPositive);
        $resolver->addAllowedTypes('name', 'string');
        $resolver->addAllowedTypes('gates', 'array');
        $resolver->addAllowedTypes('deletedGates', 'array');
        $resolver->addAllowedTypes('updatedGates', 'array');
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setRequiredOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name'
        ]);
    }
}
