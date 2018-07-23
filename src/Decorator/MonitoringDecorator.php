<?php

namespace Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\ConfigurableBalancerInterface;
use Cmp\Monitoring\Monitor;

class MonitoringDecorator extends BalancerDecorator
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
     * @param ConfigurableBalancerInterface $balancer
     * @param Monitor                       $monitor
     * @param string                        $metric The name of the metric to increment when resolving a feature path
     */
    public function __construct(ConfigurableBalancerInterface $balancer, Monitor $monitor, $metric)
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
        $path = parent::get($feature, $seed);

        $this->monitor->increment($this->metric, [
            "feature" => $feature,
            "seed"    => $seed !== null,
            "path"    => $path,
        ]);

        return $path;
    }
}
