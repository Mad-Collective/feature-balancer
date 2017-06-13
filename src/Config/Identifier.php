<?php

namespace Cmp\FeatureBalancer\Config;

use Cmp\FeatureBalancer\Exception\InvalidArgumentException;

/**
 * Class Identifier
 */
class Identifier
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException If the identifier is not valid
     */
    public function __construct($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException("The name identifier is not a valid string");
        }

        if (empty($name)) {
            throw new InvalidArgumentException("The name identifier cannot be empty");
        }

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name();
    }
}
