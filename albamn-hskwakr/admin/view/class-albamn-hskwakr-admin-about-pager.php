<?php

/**
 * The admin about pager.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The admin about pager.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_About_Pager extends Albamn_Hskwakr_Admin_Pager
{
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
    }

    /**
     * Display settings page
     *
     * @since    1.0.0
     */
    public function display(): void
    {
        /********************
         * Prepare
         *******************/

        /**
         * Check post data
         */
        $status = $this->check_post_data();

        /********************
         * Display
         *******************/

        /**
         * Header
         */
        echo $this->display_header('About Albamn');

        /**
         * Location of admin folder in the plugin
         */
        $path = (string)plugin_dir_path(dirname(__FILE__));

        switch ($status) {
            case 1:

                break;

            case 2:

                break;

            default:
                require_once $path .
                    'partials/albamn-hskwakr-admin-display-about-jp.php';
                break;
        }

        /**
         * Footer
         */
        echo $this->display_footer();
    }

    /**
     * Check post data
     *
     * @since    1.0.0
     * @return   int        The status
     *                      0 : There is no post data sent
     *                      1 : 'English' button sent
     *                      2 : 'Japanese' button sent
     */
    public function check_post_data(): int
    {
        /**
         * Check POST data from this page
         */
        if (!empty($_POST['english'])) {
            return 1;
        }

        if (!empty($_POST['japanese'])) {
            return 2;
        }

        return 0;
    }
}
