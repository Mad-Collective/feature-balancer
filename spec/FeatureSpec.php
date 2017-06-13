<?php

namespace spec\Cmp\FeatureBalancer;

use Cmp\FeatureBalancer\Exception\InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class FeatureSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith("foo", [
            "abc" => 50,
            "def" => 50,
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Cmp\FeatureBalancer\Feature');
    }

    function it_fails_when_the_name_is_not_valid()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["", []]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [null, []]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [true, []]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [100, []]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [new \stdClass(), []]);
    }

    function it_fails_when_the_percentages_are_not_valid()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["foo", []]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["foo", [100 => 100]]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["foo", [true => 100]]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["foo", ["" => 100]]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["foo", ["abc" => 50, "abc" => 50]]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["foo", ["abc" => -1, "def" => 101]]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["foo", ["abc" => 101, "def" => 0]]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["foo", ["abc" => 50, "def" => 49]]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["foo", ["abc" => 50, "def" => 49.9]]);
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ["foo", ["abc" => 50, "def" => "50"]]);
    }
}
