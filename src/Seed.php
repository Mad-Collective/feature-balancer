<?php

namespace Cmp\FeatureBalancer;

use Cmp\FeatureBalancer\Exception\InvalidArgumentException;

class Seed
{
    /**
     * @var int
     */
    private $seed;

    /**
     * @param int|string $seed
     *
     * @throws InvalidArgumentException When the seed is not valid
     */
    public function __construct($seed)
    {
        if (empty($seed) && $seed !== 0) {
            throw new InvalidArgumentException("The seed cannot be empty");
        }

        $this->seed = $this->calculateSeed($seed);
    }

    /**
     * @return int
     */
    public function seed()
    {
        return $this->seed;
    }

    /**
     * @param string $seed
     *
     * @return int
     */
    private function fromString($seed)
    {
        $total = 0;
        foreach (str_split($seed) as $char) {
            $total += ord($char);
        }

        return $this->fromNumber($total);
    }

    /**
     * @param int $seed
     *
     * @return int
     */
    private function fromNumber($seed)
    {
        return abs((int) $seed) % 100;
    }

    /**
     * @param string|int $seed
     *
     * @return int
     */
    private function calculateSeed($seed)
    {
        if (is_numeric($seed)) {
            return $this->fromNumber($seed);
        }

        if (is_string($seed)) {
            return $this->fromString($seed);
        }

        throw new InvalidArgumentException("The seed has to be either a string or and integer");
    }
}
