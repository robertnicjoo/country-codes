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

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

/**
 * Class CountryPlugin.
 *
 * @since   0.1.0
 *
 * @package Irando\CountryCodes
 * @author  Robert Nicjoo <info@irando.co.id>
 */
class CountryPlugin implements PluginInterface, EventSubscriberInterface
{
    protected $composer;
    protected $io;

    /**
     * Activate the plugin.
     *
     * @since 0.1.3
     *
     * @param Composer    $composer The main Composer object.
     * @param IOInterface $io       The i/o interface to use.
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    /**
     * Get the event subscriber configuration for this plugin.
     *
     * @since 0.1.0
     *
     * @return array<string,string> The events to listen to, and their associated handlers.
     */
    public static function getSubscribedEvents()
    {
        return array(
            ScriptEvents::POST_INSTALL_CMD => 'update',
            ScriptEvents::POST_UPDATE_CMD  => 'update',
        );
    }

    /**
     * Update the stored database.
     *
     * @since 0.1.0
     *
     * @param Event $event The event that has called the update method.
     */
    public static function update(Event $event)
    {
        $dbFilename = Country::getLocation();

        self::maybeCreateDBFolder(dirname($dbFilename));

        $io = $event->getIO();
        $io->write('Fetching new CSV version of the MaxMind ISO3166 country codes database...', true);
        // self::downloadFile($dbFilename . '.csv', Country::DB_URL);

        $io->write('Generating PHP configuration file from CSV file...', true);
        self::generateConfig($dbFilename . '.csv', $dbFilename . '.php');

        $io->write('Removing CSV file...', true);
        self::removeFile($dbFilename . '.csv');

        $io->write(
            sprintf(
                'The country codes database has been updated (%1$s).',
                $dbFilename . '.php'
            ),
            true
        );
    }

    /**
     * Create the DB folder if it does not exist yet.
     *
     * @since 0.1.0
     *
     * @param string $folder Name of the DB folder.
     */
    protected static function maybeCreateDBFolder($folder)
    {
        if (! is_dir($folder)) {
            mkdir($folder);
        }
    }

    /**
     * Download a file from an URL.
     *
     * @since 0.1.0
     *
     * @param string $filename Filename of the file to download.
     */
    // protected static function downloadFile($filename, $url)
    // {
    //     $fileHandle = fopen($filename, 'w');
    //     $options    = [
    //         CURLOPT_FILE    => $fileHandle,
    //         CURLOPT_TIMEOUT => 600,
    //         CURLOPT_URL     => $url,
    //     ];

    //     $curl = curl_init();
    //     curl_setopt_array($curl, $options);
    //     curl_exec($curl);
    //     curl_close($curl);
    // }

    /**
     * Delete a file.
     *
     * @since 0.1.2
     *
     * @param string $filename Filename of the file to delete.
     */
    protected static function removeFile($filename)
    {
        if (is_file($filename)) {
            unlink($filename);
        }
    }

    /**
     * Generate a PHP configuration file from the CSV data file.
     *
     * @since 0.1.0
     *
     * @param string $csvFile Path to the CSV file.
     * @param string $phpFile Path to the PHP file.
     */
    protected static function generateConfig($csvFile, $phpFile)
    {
        $csv  = array_map('str_getcsv', file($csvFile));
        $data = '<?php' . PHP_EOL;
        $data .= '/* DO NOT EDIT! This file has been automatically generated. Run composer update to fetch a new version. */' . PHP_EOL;
        $data .= 'return [' . PHP_EOL;
        $data .= '   \'codes\' => [' . PHP_EOL;
        foreach ($csv as $csvRow) {
            $data .= '      \'' . addslashes($csvRow[0]) . '\' => \'' . addslashes($csvRow[1]) . '\',' . PHP_EOL;
        }
        $data .= '   ],' . PHP_EOL;
        $data .= '   \'countries\' => [' . PHP_EOL;
        foreach ($csv as $csvRow) {
            $data .= '      \'' . addslashes($csvRow[1]) . '\' => \'' . addslashes($csvRow[0]) . '\',' . PHP_EOL;
        }
        $data .= '   ],' . PHP_EOL;
        $data .= '];' . PHP_EOL;
        file_put_contents($phpFile, $data);
    }

    /**
     * Remove any hooks from Composer
     *
     * @param Composer    $composer
     * @param IOInterface $io
     */
    public function deactivate(Composer $composer, IOInterface $io)
    {
        // no action required
    }

    /**
     * Prepare the plugin to be uninstalled
     *
     * This will be called after deactivate
     *
     * @param Composer    $composer
     * @param IOInterface $io
     */
    public function uninstall(Composer $composer, IOInterface $io)
    {
        // no action required
    }
}
