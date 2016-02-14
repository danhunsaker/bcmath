BC::math
========

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

- `BC::modfrac()` behaves exactly like `BC::mod()`, except it will return the
  fractional part of any remainder as well as the integer part.
- `BC::powfrac()` supports fractional exponents, allowing roots other than the
  square to be calculated.
- `BC::root()` is a complement to `BC::powfrac()`, and is in fact just a
  convenience wrapper for it.
- `BC::log()` gives the base 10 logarithm of the argument.
- `BC::ln()` gives the natural logarithm of the argument.
- `BC::epow()` raises _e_ to the argument's power.  Another convenience wrapper
  for `BC::powfrac()`.

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
