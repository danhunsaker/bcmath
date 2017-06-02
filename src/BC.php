<?php

namespace Danhunsaker;

/**
 * Class BC
 *
 * @package Danhunsaker
 */
class BC
{
    /**
     * @var integer
     */
    protected static $internalScale = 100;

    /**
     * @var integer
     */
    protected static $iterations = 50;

    /**
     * @var integer
     */
    protected static $scale = null;

    /**
     * @var integer
     */
    protected $instanceScale = null;

    // Extension-provided methods

    /**
     * Add two arbitrary precision numbers
     *
     * @param string|integer|float $a
     * @param string|integer|float $b
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function add($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcadd($a, $b, $scale);
    }

    /**
     * Compare two arbitrary precision numbers
     *
     * @param string|integer|float $a
     * @param string|integer|float $b
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function comp($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return bccomp($a, $b, $scale);
    }

    /**
     * Divide ($a / $b) two arbitrary precision numbers
     *
     * @param string|integer|float $a
     * @param string|integer|float $b
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function div($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcdiv($a, $b, $scale);
    }

    /**
     * Get modulus of an arbitrary precision number
     *
     * @param string|integer|float $a
     * @param string|integer|float $b
     * @return string|integer|float
     */
    public static function mod($a, $b)
    {
        return bcmod(static::intval($a, 0), static::intval($b, 0));
    }

    /**
     * Multiply ($a * $b) two arbitrary precision numbers
     *
     * @param string|integer|float $a
     * @param string|integer|float $b
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function mul($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcmul($a, $b, $scale);
    }

    /**
     * Raise an arbitrary precision number to another
     *
     * @param string|integer|float $base
     * @param string|integer|float $power
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function pow($base, $power, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcpow($base, bcadd($power, 0, 0), $scale);
    }

    /**
     * Raise an arbitrary precision number to another, reduced by a specified modulus
     *
     * @param string|integer|float $base
     * @param string|integer|float $power
     * @param string|integer|float $modulo
     * @param integer|null $scale
     * @return string|integer|float 
     */
    public static function powmod($base, $power, $modulo, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcpowmod($base, bcadd($power, 0, 0), $modulo, $scale);
    }

    /**
     * Set default scale parameter for all bc math functions
     *
     * @param integer|null $scale
     * @return bool
     */
    public static function scale($scale)
    {
        if ($retval = bcscale($scale)) {
            static::$scale = $scale;
        }

        return $retval;
    }

    /**
     * Get the square root of an arbitrary precision number
     *
     * @param string|integer|float $val
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function sqrt($val, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcsqrt($val, $scale);
    }

    /**
     * Subtract one arbitrary precision number from another
     *
     * @param string|integer|float $a
     * @param string|integer|float $b
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function sub($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return bcsub($a, $b, $scale);
    }

    // Extended (convenience) methods

    /**
     * Raises e to the argument's power.
     *
     * @param string|integer|float $val
     * @param integer|null $scale
     * @return string|integer|float
     */
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

    /**
     * Calculates the factorial of the argument.
     *
     * @param string|integer|float $val
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function fact($val, $scale = null)
    {
        $scale = static::getScale($scale);

        return $val == '1' ? '1' : static::add(static::mul($val, static::fact(static::sub($val, '1'), static::$internalScale), static::$internalScale), 0, $scale);
    }

    /**
     * Truncates the fractional portion of the argument, if any.
     *
     * @param string|integer|float $val
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function intval($val, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::add(static::add($val, 0, 0), 0, $scale);
    }

    /**
     * Gives the natural logarithm of the argument.
     *
     * @param string|integer|float $val
     * @param integer|null $scale
     * @return string|integer|float
     */
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

    /**
     *  Gives the base 10 logarithm of the argument (uses ln $val/ln 10).
     *
     * @param string|integer|float $val
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function log($val, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::add(static::div(static::ln($val, static::$internalScale), static::ln(10, static::$internalScale), static::$internalScale), 0, $scale);
    }

    /**
     * Returns the largest value in an array (the first argument).
     *
     * @param array $args
     * @param integer|null $scale
     * @return string|integer|float
     */
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

    /**
     * Returns the smallest value in an array (the first argument).
     *
     * @param array $args
     * @param integer|null $scale
     * @return string|integer|float
     */
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

    /**
     * Behaves exactly like BC::mod(), except it will return the fractional part of any remainder
     * as well as the integer part.
     *
     * @param string|integer|float $a
     * @param string|integer|float $b
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function modfrac($a, $b, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::sub($a, static::mul(static::div($a, $b, 0), $b, static::$internalScale), $scale);
    }

    /**
     * Supports fractional exponents, allowing roots other than the square to be calculated.
     *
     * @param string|integer|float $base
     * @param string|integer|float $pow
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function powfrac($base, $pow, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::add(static::epow(static::mul(static::ln($base, static::$internalScale), $pow, static::$internalScale), static::$internalScale), 0, $scale);
    }

    /**
     * Complement to BC::powfrac(), and is in fact just a convenience wrapper for it.
     *
     * @param string|integer|float $base
     * @param string|integer|float $root
     * @param integer|null $scale
     * @return string|integer|float
     */
    public static function root($base, $root, $scale = null)
    {
        $scale = static::getScale($scale);

        return static::powfrac($base, static::div(1, $root, static::$internalScale), $scale);
    }

    /**
     * Rounds a value to a given scale.
     *
     * @param string|integer|float $val
     * @param integer|null $scale
     * @return string|integer|float
     */
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
     * Honors order of operations:
     * - Parentheses
     * - Exponents (and Roots)
     * - Multiplication and Division
     * - Addition and Subtraction
     * - Comparison (Equality/Inequality)
     * - Booleans
     *
     * Will also allow you to use {tags} to represent variable values;
     * tags not found in $values will be treated as 0
     * 
     * @param string $formula The expression to evaluate
     * @param array|object $values An associative array of values to substitute into the expression
     * @param integer|null $scale The scale to pass to BC::math methods
     * @return string|integer|float|boolean
     */
    public static function parse($formula, $values = [], $scale = null, $returnBool = false)
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
                        case '%':   $result = static::mod($opTrio[1], $opTrio[3]); break;
                        case '%%':  $result = static::modfrac($opTrio[1], $opTrio[3], $scale); break;
                        case '\\*': $result = static::mul(static::div($opTrio[1], $opTrio[3], 0), $opTrio[3], $scale); break;
                        case '-%':  $result = static::sub($opTrio[1], static::mod($opTrio[1], $opTrio[3]), $scale); break;
                        case '**':  $result = static::pow($opTrio[1], $opTrio[3], $scale); break;
                        case '^':   $result = static::powfrac($opTrio[1], $opTrio[3], $scale); break;
                        case '==':
                        case '=':   $result = static::comp($opTrio[1], $opTrio[3], $scale) == 0 ? 1:0; break;
                        case '>':   $result = static::comp($opTrio[1], $opTrio[3], $scale) >  0 ? 1:0; break;
                        case '<':   $result = static::comp($opTrio[1], $opTrio[3], $scale) <  0 ? 1:0; break;
                        case '>=':  $result = static::comp($opTrio[1], $opTrio[3], $scale) >= 0 ? 1:0; break;
                        case '<=':  $result = static::comp($opTrio[1], $opTrio[3], $scale) <= 0 ? 1:0; break;
                        case '<>':
                        case '!=':  $result = static::comp($opTrio[1], $opTrio[3], $scale) != 0 ? 1:0; break;
                        case '|':
                        case '||':  $result = ($opTrio[1] || $opTrio[3]) ? 1:0; break;
                        case '&':
                        case '&&':  $result = ($opTrio[1] && $opTrio[3]) ? 1:0; break;
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
        /*if($returnBool) {
            return (bool)$formula;
        }*/
        return $formula;
    }

    // Internal utility methods

    /**
     * Retrieve a scale value, using the one passed, or falling back to the internal one
     *
     * @param integer|null $scale
     * @return integer
     */
    protected static function getScale($scale)
    {
        if (is_null(static::$scale)) {
            static::$scale = intval(ini_get('bcmath.scale'));
        }

        if (is_null($scale)) {
            $scale = static::$scale;
        }

        return intval($scale);
    }
}
