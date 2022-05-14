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

use Irando\Exception\InvalidArgumentException as BNInvalidArgumentException;

/**
 * Class InvalidArgumentException.
 *
 * @since   0.3.0
 *
 * @package Irando\CountryCodes\Exception
 * @author  Robert Nicjoo <info@irando.co.id>
 */
class InvalidArgumentException extends BNInvalidArgumentException implements CountryCodesException
{

    /**
     * Get an approximate value of the invalid argument that was passed in.
     *
     * @since 0.3.0
     *
     * @param mixed  $variable Variable to deduce the value of.
     * @param string $prefix   Prefix string to prepend to value.
     * @param string $suffix   Suffix string to append to value.
     * @return string
     */
    public static function getValueString($variable, $prefix = '', $suffix = '')
    {
        switch (gettype($variable)) {
            case 'boolean':
                return $variable ? "{$prefix}true{$suffix}" : "{$prefix}false{$suffix}";
            case 'integer':
            case 'double':
            case 'string':
                return $prefix . ((string)$variable) . $suffix;
            case 'array':
            case 'object':
            case 'NULL':
            case 'resource':
            case 'resource (closed)':
            case 'unknown type':
                return '';
        }
    }
}
