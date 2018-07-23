<?php

namespace spec\Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\ConfigurableBalancerInterface;
use Cmp\Monitoring\Monitor;
use PhpSpec\ObjectBehavior;

/**
 * @mixin \Cmp\FeatureBalancer\Decorator\MonitoringDecorator
 */
class MonitoringDecoratorSpec extends ObjectBehavior
{
    function let(ConfigurableBalancerInterface $balancer, Monitor $monitor)
    {
        $this->beConstructedWith($balancer, $monitor, "my_metric");
    }

    function it_logs_when_a_new_feature_path_is_decided(ConfigurableBalancerInterface $balancer, Monitor $monitor)
    {
        $balancer->get("foo", null)->willReturn("bar");

        $this->get("foo", null)->shouldReturn("bar");

        $monitor->increment("my_metric", [
            "feature" => "foo",
            "seed"    => false,
            "path"    => "bar",
        ])->shouldHaveBeenCalled();
    }

    function it_can_add_a_new_config(ConfigurableBalancerInterface $balancer)
    {
        $this->setConfig(["config"]);

        $balancer->setConfig(["config"])->shouldHaveBeenCalled();
    }
}
