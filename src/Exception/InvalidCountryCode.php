<?php
/**
 * CV. IRANDO CountryCodes Component.
 *
 * @package   Irando\CountryCodes
 * @author    Robert Nicjoo <info@irando.co.id>
 * @license   MIT
 * @link      http://www.irando.co.id/
 * @copyright 2022 Robert Nicjoo, CV. IRANDO
 */

namespace Irando\CountryCodes\Exception;

/**
 * Class InvalidCountryCode.
 *
 * @since   0.3.0
 *
 * @package Irando\CountryCodes\Exception
 * @author  Robert Nicjoo <info@irando.co.id>
 */
class InvalidCountryCode extends InvalidArgumentException
{

    /**
     * Instantiate a new InvalidCountryCode exception from a specific country code.
     *
     * @since 0.3.0
     *
     * @param mixed $code Invalid country code that was passed in.
     * @return static
     */
    public static function fromCode($code)
    {
        $type        = gettype($code);
        $valueString = static::getValueString($code, ' of value ');
        $message     = "Invalid country code of type {$type}{$valueString}";

        return new static($message);
    }

}
