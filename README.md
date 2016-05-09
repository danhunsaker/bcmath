BC::math
========

[![Software License](https://img.shields.io/packagist/l/danhunsaker/bcmath.svg?style=flat-square)](LICENSE.md)
[![Gitter](https://img.shields.io/gitter/room/danhunsaker/bcmath.svg?style=flat-square)](https://gitter.im/danhunsaker/bcmath)

[![Latest Version](https://img.shields.io/github/release/danhunsaker/bcmath.svg?style=flat-square)](https://github.com/danhunsaker/bcmath/releases)
[![Build Status](https://img.shields.io/travis/danhunsaker/bcmath.svg?style=flat-square)](https://travis-ci.org/danhunsaker/bcmath)
[![Codecov](https://img.shields.io/codecov/c/github/danhunsaker/bcmath.svg?style=flat-square)](https://codecov.io/gh/danhunsaker/bcmath)
[![Total Downloads](https://img.shields.io/packagist/dt/danhunsaker/bcmath.svg?style=flat-square)](https://packagist.org/packages/danhunsaker/bcmath)

PHP bcmath as a static class, with several enhancements.

## Installation ##

Use Composer:

```bash
composer require danhunsaker/bcmath
```

## Usage ##

Usage is nearly identical to the [bcmath extension][] functions.  The main
difference is that the `bc` prefix is replaced by the `Danhunsaker\BC` class
name (which you can easily alias in your project(s) via `use Danhunsaker\BC`).

In other words:

- [`bcadd()`][]    becomes `BC::add()`
- [`bccomp()`][]   becomes `BC::comp()`
- [`bcdiv()`][]    becomes `BC::div()`
- [`bcmod()`][]    becomes `BC::mod()`
- [`bcmul()`][]    becomes `BC::mul()`
- [`bcpow()`][]    becomes `BC::pow()`
- [`bcpowmod()`][] becomes `BC::powmod()`
- [`bcscale()`][]  becomes `BC::scale()`
- [`bcsqrt()`][]   becomes `BC::sqrt()`
- [`bcsub()`][]    becomes `BC::sub()`

There are also some additional convenience methods available, that aren't
present in the extension:

- `BC::epow()` raises _e_ to the argument's power.
- `BC::fact()` calculates the factorial of the argument.
- `BC::ln()` gives the natural logarithm of the argument.
- `BC::log()` gives the base 10 logarithm of the argument (uses ln $val/ln 10).
- `BC::max()` returns the largest value in an array (the first argument).
- `BC::min()` returns the smallest value in an array (the first argument).
- `BC::modfrac()` behaves exactly like `BC::mod()`, except it will return the
  fractional part of any remainder as well as the integer part.
- `BC::powfrac()` supports fractional exponents, allowing roots other than the
  square to be calculated.
- `BC::root()` is a complement to `BC::powfrac()`, and is in fact just a
  convenience wrapper for it.
- `BC::round()` rounds a value to a given scale.

### Expression Parser ###

There's also `BC::parse()`, which lets you write your calculations as
expressions instead of method calls.  It doesn't (yet) support *everything*
available via method calls, but this is planned for a later release.  For the
moment, here's a list of which ones *are* supported, and how to specify each in
your expressions:

- `BC::add(a, b)`                => `'a + b'`
- `BC::div(a, b)`                => `'a / b'`
- `BC::div(a, b, 0)`             => `'a \ b'`
- `BC::mul(BC::div(a, b, 0), b)` => `'a \* b'`
- `BC::mod(a, b)`                => `'a % b'`
- `BC::modfrac(a, b)`            => `'a %% b'`
- `BC::mul(a, b)`                => `'a * b'`
- `BC::pow(a, b)`                => `'a ** b'`
- `BC::powfrac(a, b)`            => `'a ^ b'`
- `BC::sub(a, b)`                => `'a - b'`

There are also some logical expressions available, all of which will return a
boolean value (true/false) instead of a number:

- `BC::comp(a, b) == 0`  => `'a = b'` or `'a == b'`
- `BC::comp(a, b) == 1`  => `'a > b'`
- `BC::comp(a, b) == -1` => `'a < b'`
- `BC::comp(a, b) >= 0`  => `'a >= b'`
- `BC::comp(a, b) <= 0`  => `'a <= b'`
- `BC::comp(a, b) != 0`  => `'a != b'` or `'a <> b'`
- `a and b`              => `'a & b'` or `'a && b'`
- `a or b`               => `'a | b'` or `'a || b'`
- `a xor b`              => `'a ~ b'` or `'a ~~ b'`

The expression parser recognizes parentheses, so you can use those to group your
subexpressions as needed.  It also supports variables:

```php
BC::parse('{m} * {x} + {b}', ['m' => 0.5, 'x' => 5, 'b' => 0]);
```

Need to specify a scale for your expression?  No problem, just pass it along in
the third parameter:

```php
BC::parse('{m} * {x} + {b}', ['m' => 0.5, 'x' => 5, 'b' => 0], 18);
```

You can, of course, skip the variable list by passing `null` as the second
argument:

```php
BC::parse('{m} * {x} + {b}', null, 18);

// Any unrecognized variables are assumed to be zero,
// so the above is the same as:

BC::parse('0 * 0 + 0', null, 18);
```

## Contributions ##

Contributions are welcome at any time on [GitHub][].

Security issues should be reported directly to [Dan Hunsaker][] via email.

[bcmath extension]: https://secure.php.net/manual/en/ref.bc.php
[`bcadd()`]: https://secure.php.net/manual/en/function.bcadd.php
[`bccomp()`]: https://secure.php.net/manual/en/function.bccomp.php
[`bcdiv()`]: https://secure.php.net/manual/en/function.bcdiv.php
[`bcmod()`]: https://secure.php.net/manual/en/function.bcmod.php
[`bcmul()`]: https://secure.php.net/manual/en/function.bcmul.php
[`bcpow()`]: https://secure.php.net/manual/en/function.bcpow.php
[`bcpowmod()`]: https://secure.php.net/manual/en/function.bcpowmod.php
[`bcscale()`]: https://secure.php.net/manual/en/function.bcscale.php
[`bcsqrt()`]: https://secure.php.net/manual/en/function.bcsqrt.php
[`bcsub()`]: https://secure.php.net/manual/en/function.bcsub.php
[GitHub]: https://github.com/danhunsaker/bcmath
[Dan Hunsaker]: dan.hunsaker+bcmath@gmail.com
