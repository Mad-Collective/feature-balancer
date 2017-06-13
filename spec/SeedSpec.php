<?php

namespace spec\Cmp\FeatureBalancer;

use Cmp\FeatureBalancer\Exception\InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class SeedSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith("foo");
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Cmp\FeatureBalancer\Seed');
    }

    function it_is_valid_if_zero()
    {
        $this->beConstructedWith(0);
        $this->shouldHaveType('Cmp\FeatureBalancer\Seed');
    }

    function it_fails_when_the_seed_is_not_valid()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["", []]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [null, []]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [true, []]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [new \stdClass(), []]);
    }

    function it_can_determine_seed_from_strings()
    {
        $this->beConstructedWith("foo");
        $this->seed()->shouldReturn(24);
    }

    function it_can_determine_seed_from_numbers()
    {
        $this->beConstructedWith(10055);
        $this->seed()->shouldReturn(55);
    }

    function it_can_determine_seed_from_negative_numbers()
    {
        $this->beConstructedWith(-10055);
        $this->seed()->shouldReturn(55);
    }
}
