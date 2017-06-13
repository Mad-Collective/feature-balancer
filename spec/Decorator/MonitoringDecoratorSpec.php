<?php

namespace spec\Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\BalancerInterface;
use Cmp\Monitoring\Monitor;
use PhpSpec\ObjectBehavior;

class MonitoringDecoratorSpec extends ObjectBehavior
{
    function let(BalancerInterface $balancer, Monitor $monitor)
    {
        $this->beConstructedWith($balancer, $monitor, "my_metric");
    }

    function it_logs_when_a_new_feature_path_is_decided(BalancerInterface $balancer, Monitor $monitor)
    {
        $balancer->get("foo", null)->willReturn("bar");

        $this->get("foo", null)->shouldReturn("bar");

        $monitor->increment("my_metric", [
            "feature" => "foo",
            "seed"    => false,
            "path"    => "bar",
        ])->shouldHaveBeenCalled();
    }
}
