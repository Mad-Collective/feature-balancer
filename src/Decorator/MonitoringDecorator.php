<?php

namespace Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\BalancerInterface;
use Cmp\Monitoring\Monitor;

class MonitoringDecorator extends BalancerDecorator implements BalancerInterface
{
    /**
     * @var Monitor
     */
    private $monitor;

    /**
     * @var string
     */
    private $metric;

    /**
     * MonitoringDecorator constructor.
     *
     * @param BalancerInterface $balancer
     * @param Monitor           $monitor
     * @param string            $metric The name of the metric to increment when resolving a feature path
     */
    public function __construct(BalancerInterface $balancer, Monitor $monitor, $metric)
    {
        parent::__construct($balancer);
        $this->monitor = $monitor;
        $this->metric  = $metric;
    }

    /**
     * {@inheritdoc}
     */
    public function get($feature, $seed = null)
    {
        $path = $this->balancer->get($feature, $seed);

        $this->monitor->increment($this->metric, [
            "feature" => $feature,
            "seed"    => $seed !== null,
            "path"    => $path,
        ]);

        return $path;
    }
}
