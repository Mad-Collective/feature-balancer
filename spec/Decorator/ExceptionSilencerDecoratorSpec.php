<?php

namespace spec\Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\BalancerInterface;
use Cmp\FeatureBalancer\Exception\OutOfBoundsException;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

class ExceptionSilencerDecoratorSpec extends ObjectBehavior
{
    function let(BalancerInterface $balancer, LoggerInterface $logger)
    {
        $this->beConstructedWith($balancer, $logger);
    }

    function it_silences_exceptions(BalancerInterface $balancer, LoggerInterface $logger)
    {
        $exception = new OutOfBoundsException("feature foo is not set");
        $balancer->get("foo", 123456)->willThrow($exception);

        $this->get("foo", 123456)->shouldBe("");

        $logger->error("Exception thrown balancing feature 'foo'", [
            "feature"   => "foo",
            "exception" => $exception,
        ])->shouldHaveBeenCalled();
    }
}
