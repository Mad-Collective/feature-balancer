<?php

namespace Cmp\FeatureBalancer;

use Cmp\FeatureBalancer\Exception\InvalidArgumentException;
use Cmp\FeatureBalancer\Exception\OutOfBoundsException;

interface BalancerInterface
{
    /**
     * Adds a new feature in the balancer
     *
     * @param string $name
     * @param array  $percentages
     */
    public function add($name, array $percentages);

    /**
     * Gets the path that a seed has to follow for a given feature 
     *
     * @param string     $feature
     * @param string|int $seed
     *
     * @return string
     * 
     * @throws InvalidArgumentException When the seed is not valid
     * @throws OutOfBoundsException When the feature has not been configured
     */
    public function get($feature, $seed = null);
}
