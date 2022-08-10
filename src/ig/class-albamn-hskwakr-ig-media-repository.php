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
        $this->base_dir =
            (string)plugin_dir_path(dirname(__FILE__)) . 'medias/';
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
        $timeout = 300;

        /**
         * @var object $res
         */
        $res = wp_remote_request(
            $url,
            array(
                'timeout' => $timeout,
                'stream' => true,
                'filename' => $path,
            )
        );

        $res_code = (int)wp_remote_retrieve_response_code($res);

        if ($res_code == 200) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete a file
     *
     * This method contains Wordpress API
     *
     * @since    1.0.0
     * @param    string    $path    The path to delete a file
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function delete(
        string $path
    ): bool {
        $success = false;

        global $wp_filesystem;
        WP_Filesystem();

        if ($wp_filesystem->exists($path)) {
            $success = $wp_filesystem->delete($path);
        }

        return $success;
    }
}
