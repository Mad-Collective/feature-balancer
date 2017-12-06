<?php

namespace spec\Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\ConfigurableBalancerInterface;
use Cmp\FeatureBalancer\Exception\OutOfBoundsException;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Webmozart\Assert\Assert;

class ExceptionSilencerDecoratorSpec extends ObjectBehavior
{
    function let(ConfigurableBalancerInterface $balancer, LoggerInterface $logger)
    {
        $this->beConstructedWith($balancer, $logger);
    }

    function it_silences_exceptions(ConfigurableBalancerInterface $balancer, LoggerInterface $logger)
    {
        $exception = new OutOfBoundsException("feature foo is not set");
        $balancer->get("foo", 123456)->willThrow($exception);

        $this->get("foo", 123456)->shouldBe("");

        $logger->error("Exception thrown balancing feature 'foo'", [
            "feature"   => "foo",
            "exception" => $exception,
        ])->shouldHaveBeenCalled();
    }

    function it_can_be_json_serialized(ConfigurableBalancerInterface $balancer)
    {
        $balancer->jsonSerialize()->willReturn(["foo" => "bar"]);

        $json = json_encode($this->jsonSerialize()->getWrappedObject());

        Assert::eq($json, '{"foo":"bar"}');
    }
}
