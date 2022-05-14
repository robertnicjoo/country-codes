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
 * Class InvalidCountryName.
 *
 * @since   0.3.0
 *
 * @package Irando\CountryCodes\Exception
 * @author  Robert Nicjoo <info@irando.co.id>
 */
class InvalidCountryName extends InvalidArgumentException
{

    /**
     * Instantiate a new InvalidCountryName exception from a specific country name.
     *
     * @since 0.3.0
     *
     * @param mixed $name Invalid country name that was passed in.
     * @return static
     */
    public static function fromName($name)
    {
        $type        = gettype($name);
        $valueString = static::getValueString($name, ' of value ');
        $message     = "Invalid country name of type {$type}{$valueString}";

        return new static($message);
    }
}
