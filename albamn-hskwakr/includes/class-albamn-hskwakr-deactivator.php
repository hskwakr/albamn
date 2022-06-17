<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/includes
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Deactivator
{
    /**
     * The settings for the plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Settings | null    $settings
     */
    private static $settings = null;

    /**
     * The Instagram functionality
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig | null    $ig
     */
    private static $ig = null;

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate(): void
    {
        self::load_dependencies();
    }

    /**
     * Load the required dependencies for this plugin.
     * Create an instance of the loader which will be used to register the hooks with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private static function load_dependencies(): void
    {
        /**
         * Location of the plugin
         */
        $path = (string)plugin_dir_path(dirname(__FILE__));

        /**
         * The class responsible for context of the plugin.
         */
        require_once $path
          . 'includes/class-albamn-hskwakr-context.php';

        /**
         * The class responsible for defining all custom post types for the plugin.
         */
        require_once $path
          . 'includes/class-albamn-hskwakr-cpt.php';

        /**
         * The class responsible for settings of the plugin.
         */
        require_once $path
          . 'includes/class-albamn-hskwakr-settings.php';

        /**
         * The class responsible for defining all Instagram functionalities.
         */
        require_once $path
          . 'ig/class-albamn-hskwakr-ig.php';

        /**
         * Instantiate context class
         */
        $context = new Albamn_Hskwakr_Context();

        /**
         * Instantiate any class
         */
        $cpt = new Albamn_Hskwakr_Cpt(
            $context->get_plugin_name()
        );

        self::$settings = new Albamn_Hskwakr_Settings(
            $context->get_plugin_name(),
            $context->get_version()
        );

        self::$ig = new Albamn_Hskwakr_Ig(
            $context->get_plugin_name(),
            $context->get_version(),
            $cpt
        );
    }
}
