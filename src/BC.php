<?php

namespace Danhunsaker;

class BC
{
    protected static $internalScale = 100;

    protected static $iterations = 50;

    protected static $scale = null;

    protected $instanceScale = null;

    // Extension-provided methods

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

    // Extended (convenience) methods

    public static function epow($val, $scale = null)
    {
        $scale = static::getScale($scale);

        $retval = static::add(1, $val, $scale);
        for ($i = 0; $i < static::$iterations; $i++) {
            $iplus = static::add($i, 2, static::$internalScale);
            $retval += static::div(static::pow($val, $iplus, static::$internalScale), static::fact($iplus, static::$internalScale), static::$internalScale);
        }

        return static::add($retval, 0, $scale);
    }

    public static function fact($val, $scale = null)
    {
        $scale = static::getScale($scale);

        return $val == '1' ? '1' : static::add(static::mul($val, static::fact(static::sub($val, '1'), static::$internalScale), static::$internalScale), 0, $scale);
    }

    public static function ln($val, $scale = null)
    {
        $scale = static::getScale($scale);

        $retval = 0;
        for ($i = 0; $i < static::$iterations; $i++) {
            $pow      = static::add(1, static::mul(2, $i, static::$internalScale), static::$internalScale);
            $mul      = static::div(1, $pow, static::$internalScale);
            $base     = static::div(static::sub($val, 1, static::$internalScale), static::add($val, 1, static::$internalScale), static::$internalScale);
            $fraction = static::mul($mul, static::pow($base, $pow, static::$internalScale), static::$internalScale);
            $retval   = static::add($fraction, $retval, static::$internalScale);
        }

        return static::add(static::mul(2, $retval, static::$internalScale), 0, $scale);
    }

    public static function log($val, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::add(static::div(static::ln($val, static::$internalScale), static::ln(10, static::$internalScale), static::$internalScale), 0, $scale);
    }

    public static function max(array $args, $scale = null)
    {
        $scale = static::getScale($scale);

        $retval = array_shift($args);
        foreach ($args as $value) {
            if (static::comp($value, $retval, static::$internalScale) > 0) {
                $retval = bcadd($value, 0, static::$internalScale);
            }
        }

        return static::add($retval, 0, $scale);
    }

    public static function min(array $args, $scale = null)
    {
        $scale = static::getScale($scale);

        $retval = array_shift($args);
        foreach ($args as $value) {
            if (static::comp($value, $retval, static::$internalScale) < 0) {
                $retval = bcadd($value, 0, static::$internalScale);
            }
        }

        return static::add($retval, 0, $scale);
    }

    public static function modfrac($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::sub($a, static::mul(static::div($a, $b, 0), $b, static::$internalScale), $scale);
    }

    public static function powfrac($base, $pow, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::add(static::epow(static::mul(static::ln($base, static::$internalScale), $pow, static::$internalScale), static::$internalScale), 0, $scale);
    }

    public static function root($base, $root, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::powfrac($base, static::div(1, $root, static::$internalScale), $scale);
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

    // Public utility methods

    /**
     * Parse a mathematical expression into calls to BC::math methods
     *
     * Will also allow you to use {tags} to represent variable values
     *
     * @param string $formula The expression to evaluate
     * @param array|object $values An array of values to substitute into the expression
     * @param integer $scale The scale to pass to BC::math methods
     * @return string|integer|float|boolean
     */
    public static function parse($formula, $values = [], $scale = null)
    {
        $scale = static::getScale($scale);

        $formula = str_replace(' ', '', "({$formula})");
        if (empty($values) || ! (is_array($values) || is_a($values, 'ArrayAccess') || is_a($values, 'Iterator'))) {
            $values = [];
        }

        foreach ($values as $key => $value) {
            $formula = str_replace("{{$key}}", $value, $formula);
        }
        $formula = preg_replace("/\{[^{}]+\}/", '0', $formula);

        $operations = [
            '\^|\*\*',
            '\*|\\\\|\\\\\*|\/|\%{1,2}|\-\%',
            '[\+\-]',
            '<|=|>|<=|==|>=|!=|<>',
            '(?:\||&|~){1,2}',
        ];

        $operand = '(?:(?<=[^0-9\.,]|^)[+-])?[0-9\.,]+';

        while (preg_match('/\(([^\)\(]+)\)/', $formula, $parenthetical)) {
            foreach ($operations as $operation) {
                while (preg_match("/({$operand})({$operation})({$operand})/", $parenthetical[1], $opTrio)) {
                    switch ($opTrio[2]) {
                        case '+':   $result = static::add($opTrio[1], $opTrio[3], $scale); break;
                        case '-':   $result = static::sub($opTrio[1], $opTrio[3], $scale); break;
                        case '*':   $result = static::mul($opTrio[1], $opTrio[3], $scale); break;
                        case '/':   $result = static::div($opTrio[1], $opTrio[3], $scale); break;
                        case '\\':  $result = static::div($opTrio[1], $opTrio[3], 0); break;
                        case '%':   $result = static::mod($opTrio[1], $opTrio[3], $scale); break;
                        case '%%':  $result = static::modfrac($opTrio[1], $opTrio[3], $scale); break;
                        case '\\*': $result = static::mul(static::div($opTrio[1], $opTrio[3], 0), $opTrio[3], $scale); break;
                        case '-%':  $result = static::sub($opTrio[1], static::mod($opTrio[1], $opTrio[3], 0), $scale); break;
                        case '**':  $result = static::pow($opTrio[1], $opTrio[3], $scale); break;
                        case '^':   $result = static::powfrac($opTrio[1], $opTrio[3], $scale); break;
                        case '==':
                        case '=':   $result = static::comp($opTrio[1], $opTrio[3], $scale) == 0; break;
                        case '>':   $result = static::comp($opTrio[1], $opTrio[3], $scale) >  0; break;
                        case '<':   $result = static::comp($opTrio[1], $opTrio[3], $scale) <  0; break;
                        case '>=':  $result = static::comp($opTrio[1], $opTrio[3], $scale) >= 0; break;
                        case '<=':  $result = static::comp($opTrio[1], $opTrio[3], $scale) <= 0; break;
                        case '<>':
                        case '!=':  $result = static::comp($opTrio[1], $opTrio[3], $scale) != 0; break;
                        case '|':
                        case '||':  $result = ($opTrio[1] || $opTrio[3]); break;
                        case '&':
                        case '&&':  $result = ($opTrio[1] && $opTrio[3]); break;
                        case '~':
                        case '~~':  $result = (bool) ((bool) $opTrio[1] ^ (bool) $opTrio[3]); break;
                    }
                    // error_log("Replacing {$opTrio[0]} with {$result} in the {$parenthetical[0]} section of {$formula}");
                    $parenthetical[1] = str_replace($opTrio[0], $result, $parenthetical[1]);
                }
            }
            // error_log("Replacing {$parenthetical[0]} with {$parenthetical[1]} in {$formula}");
            $formula = str_replace($parenthetical[0], $parenthetical[1], $formula);
        }

        return $formula;
    }

    // Internal utility methods

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
