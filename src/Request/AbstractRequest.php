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

    /**
     * AbstractRequest constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);

        try {
            $this->options = $resolver->resolve($options);
        } catch (\Exception $e) {
            throw new HttpException(400, $e->getMessage());
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
    }

    /**
     * @param OptionsResolver $resolver
     */
    abstract protected function setDefaultOptions(OptionsResolver $resolver);
}
