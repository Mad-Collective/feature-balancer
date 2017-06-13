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

    /**
     * @dataProvider seedConversionExamples
     */
    function it_can_determine_the_seed($inputValue, $expectedValue)
    {
        $this->beConstructedWith($inputValue);
        $this->seed()->shouldReturn($expectedValue);
    }

    public function seedConversionExamples()
    {
        return [
            ["1234à", 84],
            ["1234è", 88],
            ["foo", 26],
            [10055, 55],
            [-10055, 55],
            [1.1, 84],
            [1.2, 26],
        ];
    }
}
