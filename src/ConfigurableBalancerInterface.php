<?php

namespace Cmp\FeatureBalancer;

use Cmp\FeatureBalancer\Exception\InvalidArgumentException;

interface ConfigurableBalancerInterface extends BalancerInterface, \JsonSerializable
{
    /**
     * Adds a new feature in the balancer
     *
     * @param string $name
     * @param array  $percentages
     *
     * @throws InvalidArgumentException When any parameter given is not acceptable
     */
    public function add($name, array $percentages);

    /**
     * Sets the features configuration
     *
     * @param array $config
     *
     * @throws InvalidArgumentException When any parameter given is not acceptable
     */
    public function setConfig(array $config);

    /**
     * Gets the features configuration
     *
     * @return array
     */
    public function getConfig();
}
