<?php

namespace Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\ConfigurableBalancerInterface;

abstract class BalancerDecorator implements ConfigurableBalancerInterface
{
    /**
     * @var ConfigurableBalancerInterface
     */
    protected $balancer;

    /**
     * @param ConfigurableBalancerInterface $balancer
     */
    public function __construct(ConfigurableBalancerInterface $balancer)
    {
        $this->balancer = $balancer;
    }

    /**
     * {@inheritdoc}
     */
    public function add($name, array $percentages)
    {
        $this->balancer->add($name, $percentages);
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig(array $config)
    {
        $this->balancer->config($config);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->balancer->getConfig();
    }

    /**
     * {@inheritdoc}
     */
    public function get($feature, $seed = null)
    {
        return $this->balancer->get($feature, $seed);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->balancer->jsonSerialize();
    }
}
