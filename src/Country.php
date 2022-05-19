<?php
/**
 * Composer-packaged version of the free MaxMind GeoLite2 Country database.
 *
 * @package   Irando\CountryCodes
 * @author    Robert Nicjoo <info@irando.co.id>
 * @license   MIT
 * @link      http://www.irando.co.id/
 * @copyright 2022 Robert Nicjoo, CV. IRANDO
 */

namespace Irando\CountryCodes;

use BrightNucleus\Config\ConfigFactory;
use BrightNucleus\Config\ConfigInterface;
use BrightNucleus\CountryCodes\Exception\InvalidCountryCode;
use BrightNucleus\CountryCodes\Exception\InvalidCountryName;

/**
 * Class Country.
 *
 * @since   0.1.0
 *
 * @package Irando\CountryCodes
 * @author  Robert Nicjoo <info@irando.co.id>
 */
class Country
{
    const DB_FILENAME = 'iso3166';
    const DB_FOLDER   = 'data';
    const DB_URL      = 'https://dev.maxmind.com/csv-files/codes/iso3166.csv';

    /**
     * The configuration data that is queried.
     *
     * @var ConfigInterface
     *
     * @since 0.1.0
     */
    protected static $data;

    /**
     * Get the location of the database file.
     *
     * @since 0.1.0
     *
     * @param bool $array   Optional. Whether to return the location as an array. Defaults to false.
     * @return string|array Either a string, containing the absolute path to the file, or an array with the location
     *                      split up into two keys named 'folder' and 'filename'
     */
    public static function getLocation($array = false)
    {
        $folder   = dirname( __DIR__ ) . '/' . self::DB_FOLDER;
        $filepath = $folder . '/' . self::DB_FILENAME;
        if (! $array) {
            return $filepath;
        }

        return [
            'folder' => $folder,
            'file'   => self::DB_FILENAME,
        ];
    }

    /**
     * Get the English name of a country from its ISO 3166 code.
     *
     * @since 0.1.0
     *
     * @param string $code     ISO 3166 code of the country to query.
     * @param string $fallback Optional. Name of the country to return if the code was not found. Defaults to 'United
     *                         States'.
     * @return string English name of the country.
     * @throws InvalidCountryCode If the provided country code is not valid.
     */
    public static function getNameFromCode($code, $fallback = 'United States')
    {
        if (! is_string($code) || empty($code)) {
            throw InvalidCountryCode::fromCode($code);
        }

        $data = self::initData();
        if (! $data->hasKey('codes', $code)) {
            return $fallback;
        }

        return (string)$data->getKey('codes', $code);
    }

    /**
     * Get the ISO 3166 code of a country from its English name.
     *
     * @since 0.1.0
     *
     * @param string $name     English name of the country to query.
     * @param string $fallback Optional. ISO 3166 code to return if the code was not found. Defaults to 'US'.
     * @return string ISO 3166 code of the country.
     * @throws InvalidCountryName If the provided country name is not valid.
     */
    public static function getCodeFromName($name, $fallback = 'US')
    {
        if (! is_string($name) || empty($name)) {
            throw InvalidCountryName::fromName($name);
        }

        $data = self::initData();
        if (! $data->hasKey('countries', $name)) {
            return $fallback;
        }

        return $data->getKey('countries', $name);
    }

    /**
     * Initialize and return the configuration data.
     *
     * @since 0.1.0
     */
    protected static function initData()
    {
        if (! self::$data) {
            self::$data = ConfigFactory::create(self::getLocation() . '.php');
        }

        return self::$data;
    }
}
