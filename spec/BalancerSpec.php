<?php

namespace spec\Cmp\FeatureBalancer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
        $this->get("foo", "bar")->shouldReturn("abc");
        $this->get("foo", "aaa")->shouldReturn("def");
    }

    function it_can_distribute_hits_across_features_without_seed()
    {
        $this->get("foo")->shouldMatch('/abc|def/');
    }
}
