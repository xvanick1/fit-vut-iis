<?php
/**
 * Created by PhpStorm.
 * User: pavelwitassek
 * Date: 23/11/2018
 * Time: 18:07
 */

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class TerminalPostRequest extends AbstractRequest
{
    public $id;
    public $name;
    public $gates;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
           'id',
           'name',
           'gates'
        ]);

        $resolver->addAllowedTypes('id', 'numeric');
        $resolver->addAllowedValues('id', $this->isPositive);
        $resolver->addAllowedTypes('name', 'string');
        $resolver->addAllowedTypes('gates', 'array');
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
