<?php

namespace Cmp\FeatureBalancer\Config;

use Cmp\FeatureBalancer\Exception\InvalidArgumentException;

/**
 * Class Percentage
 */
class Percentage implements \JsonSerializable
{
    /**
     * @var int
     */
    private $number;

    /**
     * @param int $number
     *
     * @throws \InvalidArgumentException If the percentage is not valid
     */
    public function __construct($number)
    {
        if (!is_int($number)) {
            throw new InvalidArgumentException("The percentage is not a valid integer");
        }

        if ($number < 0) {
            throw new InvalidArgumentException("The percentage cannot be less than zero");
        }

        if ($number > 100) {
            throw new InvalidArgumentException("The percentage cannot be greater than one hundred");
        }

        $this->number = $number;
    }

    /**
     * @return int
     */
    public function number()
    {
        return $this->number;
    }

    /**
     * @return int
     */
    function jsonSerialize()
    {
        return $this->number();
    }
}
