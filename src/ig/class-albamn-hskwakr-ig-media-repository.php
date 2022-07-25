<?php

/**
 * The permanent data access for instagram media
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The permanent data access for instagram media
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Media_Repository
{
    /**
     * The path to plugin directory
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $base_dir
     */
    public $base_dir;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct(
    ) {
        $this->base_dir = (string)plugin_dir_path(dirname(__FILE__));
    }

    /**
     * Download Instagram media
     *
     * @since    1.0.0
     * @param    string    $url     The remote location to download
     * @param    string    $path    The path to store media file
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function download(
        string $url,
        string $path
    ): bool {
        $curl = curl_init($url);
        $fp = fopen($path, 'wb');

        curl_setopt($curl, CURLOPT_FILE, $fp);
        curl_setopt($curl, CURLOPT_HEADER, 0);

        $r = curl_exec($curl);
        curl_close($curl);

        fclose($fp);

        if ($r === true) {
            return true;
        } else {
            return false;
        }
    }
}
