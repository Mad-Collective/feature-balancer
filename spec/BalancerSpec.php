<?php

namespace spec\Cmp\FeatureBalancer;

use Cmp\FeatureBalancer\Exception\OutOfBoundsException;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\Assert;

class BalancerSpec extends ObjectBehavior
{
    function let()
    {
        $this->add("foo", [
            "abc" => 80,
            "def" => 20,
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Cmp\FeatureBalancer\Balancer');
        $this->shouldImplement('Cmp\FeatureBalancer\BalancerInterface');
        $this->shouldImplement('Cmp\FeatureBalancer\ConfigurableBalancerInterface');
    }

    function it_can_distribute_hits_across_features_based_on_numeric_seeds()
    {
        $this->get("foo", 0)->shouldReturn("abc");
        $this->get("foo", 1)->shouldReturn("abc");
        $this->get("foo", 79)->shouldReturn("abc");

        $this->get("foo", 80)->shouldReturn("def");
        $this->get("foo", 99)->shouldReturn("def");

        $this->get("foo", 100)->shouldReturn("abc");
    }

    function it_can_distribute_hits_across_features_based_on_string_seeds()
    {
        $this->get("foo", "bar")->shouldReturn("def");
        $this->get("foo", "foo")->shouldReturn("abc");
    }

    function it_can_distribute_hits_across_features_without_seed()
    {
        $this->get("foo")->shouldMatch('/abc|def/');
    }

    function it_fails_if_the_requested_feature_has_not_been_added()
    {
        $this->shouldThrow(OutOfBoundsException::class)->duringGet("bar");
    }

    function it_can_be_json_serialized()
    {
        $json = json_encode($this->jsonSerialize()->getWrappedObject());
        Assert::eq($json, '{"foo":{"abc":80,"def":20}}');
    }
}
