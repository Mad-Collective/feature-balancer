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
    private function fromScalar($seed)
    {
        $total = 0;
        $hash  = md5((string) $seed);
        foreach (str_split($hash) as $char) {
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
        return abs($seed) % 100;
    }

    /**
     * @param string|int $seed
     *
     * @return int
     */
    private function calculateSeed($seed)
    {
        if (is_int($seed)) {
            return $this->fromNumber($seed);
        }

        if (is_scalar($seed) && !is_bool($seed)) {
            return $this->fromScalar($seed);
        }

        throw new InvalidArgumentException("The seed has to be either a string or a number");
    }
}
