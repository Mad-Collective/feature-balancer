<?php

namespace Cmp\FeatureBalancer;

class Seed
{
    /**
     * @var int
     */
    private $seed;

    /**
     * @param int|string $seed
     *
     * @throws \InvalidArgumentException When the seed is not valid
     */
    public function __construct($seed)
    {
        if (empty($seed) && $seed !== 0) {
            throw new \InvalidArgumentException("The seed cannot be empty");
        }

        if (is_numeric($seed)) {
            $this->seed = $this->fromNumber($seed);
        } elseif (is_string($seed)) {
            $this->seed = $this->fromString($seed);
        } else {
            throw new \InvalidArgumentException("The seed has to be either a string or and integer");
        }
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
}
