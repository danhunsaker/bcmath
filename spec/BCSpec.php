<?php

namespace spec\Danhunsaker;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BCSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Danhunsaker\BC');
    }

    public function it_should_have_extension_functions()
    {
        $this::add(1, 5)->shouldBeLike(6);
        $this::comp(1, 5)->shouldBeLike(-1);
        $this::div(1, 5)->shouldBeLike(0);
        $this::div(1, 5, 1)->shouldBeLike(0.2);
        $this::mod(1, 5)->shouldBeLike(1);
        $this::mul(1, 5)->shouldBeLike(5);
        $this::pow(1, 5)->shouldBeLike(1);
        $this::powmod(1, 5, 7)->shouldBeLike(1);
        $this::scale(0)->shouldEqual(true);
        $this::sqrt(1)->shouldBeLike(1);
        $this::sub(1, 5)->shouldBeLike(-4);
    }

    public function it_should_have_extended_functionality()
    {
        $this::scale(18);
        $this::epow(1)->shouldBeLike('2.7182818284590455');
        $this::fact(5)->shouldBeLike(120);
        $this::ln(1)->shouldBeLike(0);
        $this::log(1)->shouldBeLike(0);
        $this::max([5, 1, 7])->shouldBeLike(7);
        $this::min([5, 1, 7])->shouldBeLike(1);
        $this::modfrac(5.5, 1)->shouldBeLike(0.5);
        $this::powfrac(1, .5)->shouldBeLike(1);
        $this::root(1, 5)->shouldBeLike(1);
        $this::round('2.7182818284590455', 18)->shouldBeLike('2.7182818284590455');
        $this::round('2.7182818284590455', 7)->shouldBeLike('2.7182818');
        $this::round('2.7182818284590455', 6)->shouldBeLike('2.718282');
    }
}
