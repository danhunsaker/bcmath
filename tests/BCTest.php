<?php

namespace Danhunsaker\BC\Tests;

/**
 * @coversDefaultClass Danhunsaker\BC
 */
class BCTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::add
     */
    public function testAdd()
    {
        $this->assertEquals(bcadd(1, 5), BC::add(1, 5));
    }

    /**
     * @covers ::comp
     */
    public function testComp()
    {
        $this->assertEquals(bccomp(1, 5), BC::comp(1, 5));
    }

    /**
     * @covers ::div
     */
    public function testDiv()
    {
        $this->assertEquals(bcdiv(1, 5), BC::div(1, 5));
    }

    /**
     * @covers ::mod
     */
    public function testMod()
    {
        $this->assertEquals(bcmod(1, 5), BC::mod(1, 5));
    }

    /**
     * @covers ::mul
     */
    public function testMul()
    {
        $this->assertEquals(bcmul(1, 5), BC::mul(1, 5));
    }

    /**
     * @covers ::pow
     */
    public function testPow()
    {
        $this->assertEquals(bcpow(2, 5), BC::pow(2, 5));
    }

    /**
     * @covers ::powmod
     */
    public function testPowMod()
    {
        $this->assertEquals(bcpowmod(2, 5, 3), BC::powmod(2, 5, 3));
    }

    /**
     * @covers ::sqrt
     */
    public function testSqrt()
    {
        $this->assertEquals(bcsqrt(1), BC::sqrt(1));
    }

    /**
     * @covers ::scale
     */
    public function testScale()
    {
        $this->assertEquals(bcscale(1), BC::scale(1));
        $this->assertAttributeEquals(1, 'scale', 'Danhunsaker\\BC\\Tests\\BC');
    }

    /**
     * @covers ::sub
     */
    public function testSub()
    {
        $this->assertEquals(bcsub(1, 5), BC::sub(1, 5));
    }

    /**
     * @covers ::epow
     */
    public function testEPow()
    {
        $this->assertEquals('2.71828', BC::epow(1, 5));
    }

    /**
     * @covers ::fact
     */
    public function testFact()
    {
        $this->assertEquals(120, BC::fact(5));
    }

    /**
     * @covers ::ln
     */
    public function testLn()
    {
        $this->assertEquals('-5.87554', BC::ln(0, 5));
        $this->assertEquals(0, BC::ln(1, 5));
    }

    /**
     * @covers ::log
     */
    public function testLog()
    {
        $this->assertEquals(-2.55171, BC::log(0, 5));
        $this->assertEquals(0, BC::log(1, 5));
    }

    /**
     * @covers ::max
     */
    public function testMax()
    {
        $this->assertEquals(7, BC::max([5, 1, 7]));
    }

    /**
     * @covers ::min
     */
    public function testMin()
    {
        $this->assertEquals(1, BC::min([5, 1, 7]));
    }

    /**
     * @covers ::modfrac
     */
    public function testModFrac()
    {
        $this->assertEquals(1, BC::modfrac(1, 5, 4));
        $this->assertEquals(3.1745, BC::modfrac(3.1745, 5, 4));
        $this->assertEquals(0.1745, BC::modfrac(5.1745, 5, 4));
    }

    /**
     * @covers ::powfrac
     */
    public function testPowFrac()
    {
        $this->assertEquals(32, BC::powfrac(2, 5));
        $this->assertEquals(1.41421, BC::powfrac(2, 0.5, 5));
    }

    /**
     * @covers ::root
     */
    public function testRoot()
    {
        $this->assertEquals(1.14869, BC::root(2, 5, 5));
    }

    /**
     * @covers ::round
     */
    public function testRound()
    {
        $this->assertEquals(3, BC::round('2.7182818284590455', 0));
        $this->assertEquals('2.71828183', BC::round('2.7182818284590455', 8));
        $this->assertEquals('2.7182818284590455', BC::round('2.7182818284590455', 18));
    }

    /**
     * @covers ::parse
     */
    public function testParse()
    {
        BC::scale(18);
        $this->assertEquals(6, BC::parse('1 + 5'));
        $this->assertEquals(-4, BC::parse('1 - 5'));
        $this->assertEquals(5, BC::parse('1 * 5'));
        $this->assertEquals(0.2, BC::parse('1 / 5'));
        $this->assertEquals(0, BC::parse('1 \ 5'));
        $this->assertEquals(1, BC::parse('1 % 5'));
        $this->assertEquals(1.5, BC::parse('5.5 %% 2'));
        $this->assertEquals(4, BC::parse('5.5 \* 2'));
        $this->assertEquals(1, BC::parse('4 ** .5'));
        $this->assertEquals(2, BC::parse('4 ^ .5'));
        $this->assertEquals(false, BC::parse('1 = 5'));
        $this->assertEquals(false, BC::parse('1 == 5'));
        $this->assertEquals(false, BC::parse('1 > 5'));
        $this->assertEquals(true, BC::parse('1 < 5'));
        $this->assertEquals(false, BC::parse('1 >= 5'));
        $this->assertEquals(true, BC::parse('1 <= 5'));
        $this->assertEquals(true, BC::parse('1 <> 5'));
        $this->assertEquals(true, BC::parse('1 != 5'));
        $this->assertEquals(true, BC::parse('1 & 5'));
        $this->assertEquals(true, BC::parse('1 && 5'));
        $this->assertEquals(true, BC::parse('1 | 5'));
        $this->assertEquals(true, BC::parse('1 || 5'));
        $this->assertEquals(false, BC::parse('1 ~ 5'));
        $this->assertEquals(false, BC::parse('1 ~~ 5'));
        $this->assertEquals('2.25', BC::parse('5 / 4 + 1'));
        $this->assertEquals('2.25', BC::parse('1 + 5 / 4'));
        $this->assertEquals('0.25', BC::parse('-1 + 5 / 4'));
        $this->assertEquals('-0.25', BC::parse('1 + -5 / 4'));
        $this->assertEquals('-0.25', BC::parse('1 - +5 / 4'));
        $this->assertEquals('1.5', BC::parse('(1 + 5) / 4'));
        $this->assertEquals('1', BC::parse('(1 + 5) \ 4'));
        $this->assertEquals('1', BC::parse('(1 + 5) / 4', null, 0));
        $this->assertEquals('1.5', BC::parse('({a} + {b}) / {c}', ['a' => 1, 'b' => 5, 'c' => 4]));
        $this->assertEquals('1', BC::parse('({a} + {b}) / {c}', ['a' => 1, 'b' => 5, 'c' => 4], 0));
    }

    /**
     * @covers ::getScale
     */
    public function testGetScale()
    {
        BC::scale(null);
        $this->assertEquals(ini_get('bcmath.scale'), BC::getScale(null));
        $this->assertEquals(17, BC::getScale(17));
        BC::scale(63);
        $this->assertEquals(63, BC::getScale(null));
        $this->assertEquals(17, BC::getScale(17));
        BC::scale(null);
        $this->assertEquals(ini_get('bcmath.scale'), BC::getScale(null));
        $this->assertEquals(17, BC::getScale(17));
    }
}
