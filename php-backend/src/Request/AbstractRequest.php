<?php

namespace App\Request;


use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractRequest
 * @package AppBundle\Request
 */
abstract class AbstractRequest
{
    protected $options;
    protected $isPositive;
    protected $isDate;
    protected $isTime;

    /**
     * AbstractRequest constructor.
     * @param array $options
     * @param bool $required
     * @throws HttpException
     */
    public function __construct(array $options = [], bool $required = false)
    {
        $resolver = new OptionsResolver();
        $this->setUpMethods();
        $this->setDefaultOptions($resolver);
        if ($required) {
            $this->setRequiredOptions($resolver);
        }

        try {
            $this->options = $resolver->resolve($options);
        } catch (\Exception $exception) {
            throw new HttpException(400, $exception->getMessage());
        }

        foreach ($this->options as $key => $value) {
            $this->$key = $value;
        }
    }

    private function setUpMethods()
    {
        $this->isPositive = function ($value) {
            return (bool)intval($value) > 0 && (is_int($value) || ctype_digit($value));
        };
        $this->isDate = function ($value) {
            return preg_match('/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/', $value) === 1;
        };
        $this->isTime = function ($value) {
            return preg_match('/^(([01][0-9])|(2[0-3])):[0-5][0-9]$/', $value) === 1;
        };
    }

    /**
     * @param OptionsResolver $resolver
     */
    abstract protected function setDefaultOptions(OptionsResolver $resolver);

    /**
     * @param OptionsResolver $resolver
     */
    abstract protected function setRequiredOptions(OptionsResolver $resolver);

}
