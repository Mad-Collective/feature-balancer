<?php

namespace spec\Cmp\FeatureBalancer;

use Cmp\FeatureBalancer\BalancerBuilder;
use Cmp\FeatureBalancer\BalancerInterface;
use Cmp\Monitoring\Monitor;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

class BalancerBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cmp\FeatureBalancer\BalancerBuilder');
    }

    function it_can_build_the_balancer(Monitor $monitor, LoggerInterface $logger)
    {
        $this->withLogger($logger)->shouldReturnAnInstanceOf(BalancerBuilder::class);
        $this->withMonitor($monitor, "foo")->shouldReturnAnInstanceOf(BalancerBuilder::class);
        $this->withoutExceptions()->shouldReturnAnInstanceOf(BalancerBuilder::class);
        $this->create([
            "feature_1" => ["foo" => 50, "off" => 50],
            "feature_2" => ["bar" => 20, "rab" => 40, "arb" => 40]
        ])->shouldImplement(BalancerInterface::class);
    }
}
