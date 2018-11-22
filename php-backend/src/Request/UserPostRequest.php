<?php

namespace App\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPostRequest extends AbstractRequest
{
    public $id;
    public $name;
    public $surname;
    public $username;
    public $password;
    public $role;
    public $isActive;

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(
            [
                'id',
                'name',
                'surname',
                'username',
                'password',
                'role',
                'isActive'
            ]
        );

        $resolver->addAllowedTypes('name', ['string', 'null']);
        $resolver->addAllowedTypes('surname', ['string', 'null']);
        $resolver->addAllowedTypes('username', 'string');
        $resolver->addAllowedTypes('password', ['string', 'null']);
        $resolver->addAllowedTypes('role', ['string', 'null']);
        $resolver->addAllowedValues('role', ['ROLE_ADMIN', 'ROLE_MANAGER', 'ROLE_USER']);
        $resolver->addAllowedTypes('isActive', ['bool', 'null']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setRequiredOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(
            [
                'username',
                'role',
                'isActive'
            ]
        );
    }
}
