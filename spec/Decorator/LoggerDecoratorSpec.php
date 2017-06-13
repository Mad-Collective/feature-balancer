<?php

namespace spec\Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\BalancerInterface;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class LoggerDecoratorSpec extends ObjectBehavior
{
    function let(BalancerInterface $balancer, LoggerInterface $logger)
    {
        $this->beConstructedWith($balancer, $logger, LogLevel::DEBUG);
    }

    function it_logs_when_a_new_feature_path_is_decided(BalancerInterface $balancer, LoggerInterface $logger)
    {
        $balancer->get("foo", null)->willReturn("bar");

        $this->get("foo", null)->shouldReturn("bar");

        $logger->log(LogLevel::DEBUG, "Feature path returned from the balancer: foo -> bar", [
            "feature" => "foo",
            "seed"    => "",
            "path"    => "bar",
        ])->shouldHaveBeenCalled();
    }
}
