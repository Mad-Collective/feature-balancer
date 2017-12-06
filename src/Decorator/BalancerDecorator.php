<?php

namespace Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\BalancerInterface;

abstract class BalancerDecorator implements BalancerInterface
{
    /**
     * @var BalancerInterface
     */
    protected $balancer;

    /**
     * @param BalancerInterface $balancer
     */
    public function __construct(BalancerInterface $balancer)
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
