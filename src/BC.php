<?php

namespace Danhunsaker;

class BC
{
    protected static $scale = null;

    protected $instanceScale = null;

    public static function add($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcadd($a, $b, $scale);
    }

    public static function comp($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return bccomp($a, $b, $scale);
    }

    public static function div($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcdiv($a, $b, $scale);
    }

    public static function mod($a, $b)
    {
        return bcmod($a, $b);
    }

    public static function mul($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcmul($a, $b, $scale);
    }

    public static function pow($base, $power, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcpow($base, bcadd($power, 0, 0), $scale);
    }

    public static function powmod($base, $power, $modulo, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcpowmod($base, bcadd($power, 0, 0), $modulo, $scale);
    }

    public static function scale($scale)
    {
        if ($retval = bcscale($scale)) {
            static::$scale = $scale;
        }

        return $retval;
    }

    public static function sqrt($val, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcsqrt($val, $scale);
    }

    public static function sub($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcsub($a, $b, $scale);
    }

    public static function modfrac($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::sub($a, static::mul(static::div($a, $b, 0), $b, $scale), $scale);
    }

    public static function powfrac($base, $pow, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::epow(static::mul(static::ln($base, $scale), $pow, $scale), $scale);
    }

    public static function root($base, $root, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::powfrac($base, static::div(1, $root, $scale), $scale);
    }

    public static function epow($val, $scale = null)
    {
        $scale = static::getScale($scale);

        $retval = static::add('1.0', $val, $scale);
        for ($i = 0; $i < 25; $i++) {
            $retval += static::div(static::pow($val, static::add($i, '2', $scale), $scale), static::fact(static::add($i, '2', $scale), $scale), $scale);
        }

        return $retval;
    }

    public static function fact($val, $scale = null)
    {
        $scale = static::getScale($scale);

        return $val == '1' ? '1' : static::mul($val, static::fact(static::sub($val, '1'), $scale), $scale);
    }

    public static function max(array $args, $scale = null)
    {
        $scale = static::getScale($scale);

        $retval = array_shift($args);
        foreach ($args as $value) {
            if (static::comp($value, $retval, $scale) > 0) {
                $retval = $value;
            }
        }

        return $retval;
    }

    public static function min(array $args, $scale = null)
    {
        $scale = static::getScale($scale);

        $retval = array_shift($args);
        foreach ($args as $value) {
            if (static::comp($value, $retval, $scale) < 0) {
                $retval = $value;
            }
        }

        return $retval;
    }

    public static function log($val, $scale = null)
    {
        $scale = static::getScale($scale);

        return $val == '1' ? '0' : static::div(static::ln($val, $scale), static::ln(10, $scale), $scale);
    }

    public static function ln($val, $scale = null)
    {
        $scale = static::getScale($scale);

        $retval = 0;
        for ($i = 0; $i < 25; $i++) {
            $pow      = static::add(1, static::mul(2, $i, $scale), $scale);
            $mul      = static::div(1, $pow, $scale);
            $fraction = static::mul($mul, static::pow(static::div(static::sub($val, 1, $scale), static::add($val, 1, $scale)), $pow), $scale);
            $retval   = static::add($fraction, $retval, $scale);
        }

        return static::mul(2, $retval, $scale);
    }

    public static function round($val, $scale = null)
    {
        $scale = static::getScale($scale);

        if (false !== ($pos = strpos($val, '.')) && (strlen($val) - $pos - 1) > $scale) {
            $zeros = str_repeat("0", $scale);
            return static::add($val, "0.{$zeros}5", $scale);
        } else {
            return $val;
        }
    }

    protected static function getScale($scale)
    {
        if (is_null(static::$scale)) {
            static::$scale = ini_get('bcmath.scale');
        }

        if (is_null($scale)) {
            $scale = static::$scale;
        }

        return $scale;
    }
}
