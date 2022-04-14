<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $albamn_hskwakr    The ID of this plugin.
     */
    private $albamn_hskwakr;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The settings for the plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Admin_Settings    $settings
     */
    private $settings;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $albamn_hskwakr    The name of the plugin.
     * @param    string    $version           The version of this plugin.
     */
    public function __construct($albamn_hskwakr, $version)
    {
        $this->albamn_hskwakr = $albamn_hskwakr;
        $this->version = $version;

        $this->load_dependencies();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies(): void
    {
        /**
         * Location of admin folder in the plugin
         */
        $path = plugin_dir_path(dirname(__FILE__)) . 'admin/';

        /**
         * The interface responsible for admin displayable.
         */
        require_once $path
          . 'interface-albamn-hskwakr-admin-displayable.php';

        /**
         * Model
         */

        /**
         * The class responsible for admin custom menu.
         */
        require_once $path
          . 'model/class-albamn-hskwakr-admin-menu.php';

        /**
         * The class responsible for admin enqueue.
         */
        require_once $path
          . 'model/class-albamn-hskwakr-admin-enqueue.php';

        /**
         * The class responsible for admin settings.
         */
        require_once $path
          . 'model/class-albamn-hskwakr-admin-settings.php';

        /**
         * View
         */

        /**
         * The class responsible for admin setting pager.
         */
        require_once $path
          . 'view/class-albamn-hskwakr-admin-settings-pager.php';

        /**
         * The class responsible for admin importer pager.
         */
        require_once $path
          . 'view/class-albamn-hskwakr-admin-importer-pager.php';

        /**
         * The class responsible for instagram media formatter.
         */
        require_once $path
          . 'view/class-albamn-hskwakr-admin-ig-formatter.php';


        /**
         * Instagram API
         */

        /**
         * The class responsible for instagram api.
         */
        require_once $path
          . 'ig/class-albamn-hskwakr-ig-api.php';

        /**
         * The client for http access.
         */
        require_once $path
          . 'ig/class-albamn-hskwakr-ig-http-client.php';

        /**
         * The query for Instagram API.
         */
        require_once $path
          . 'ig/class-albamn-hskwakr-ig-api-query.php';

        /**
         * The validation for response from Instagram API.
         */
        require_once $path
          . 'ig/class-albamn-hskwakr-ig-api-response-validation.php';

        /**
         * The context for Instagram API.
         */
        require_once $path
          . 'ig/class-albamn-hskwakr-ig-api-context.php';

        /**
         * Create instaces.
         */
        $this->settings = new Albamn_Hskwakr_Admin_Settings(
            $this->albamn_hskwakr,
            $this->version
        );
    }

    /**
     * Register the css/js for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue(): void
    {
        $enqueue = new Albamn_Hskwakr_Admin_Enqueue(
            $this->albamn_hskwakr,
            $this->version
        );
        $url = (string)plugin_dir_url(__FILE__);

        /**
         * Style
         *
         * @var Albamn_Hskwakr_Admin_Enqueue_Style
         */
        foreach ($enqueue->styles($url) as $s) {
            wp_enqueue_style(
                $s->handle,
                $s->src,
                $s->deps,
                $s->ver,
                $s->media
            );
        }

        /**
         * Script
         *
         * @var Albamn_Hskwakr_Admin_Enqueue_Script
         */
        foreach ($enqueue->scripts($url) as $s) {
            wp_enqueue_script(
                $s->handle,
                $s->src,
                $s->deps,
                $s->ver,
                $s->footer
            );
        }
    }

    /**
     * Add custom menu for this plugin.
     *
     * @since    1.0.0
     */
    public function menu(): void
    {
        /**
         * Instantiate settings pager
         */
        $general = new Albamn_Hskwakr_Admin_Settings_Pager(
            $this->settings
        );

        /**
         * Instantiate importer pager
         */
        $ig_api = new Albamn_Hskwakr_Ig_Api();
        $importer = new Albamn_Hskwakr_Admin_Importer_Pager(
            $this->settings,
            $ig_api
        );

        /**
         * Instantiate menu
         */
        $menu = new Albamn_Hskwakr_Admin_Menu(
            $general,
            $importer
        );

        /**
         * Base menu
         *
         * @var Albamn_Hskwakr_Admin_Menu_Base
         */
        $b = $menu->base();
        add_menu_page(
            $b->page_title,
            $b->menu_title,
            $b->capability,
            $b->menu_slug,
            $b->callback,
            $b->icon,
            $b->position
        );

        /**
         * Sub menu
         *
         * @var Albamn_Hskwakr_Admin_Menu_Sub
         */
        foreach ($menu->sub() as $s) {
            add_submenu_page(
                $s->base,
                $s->page_title,
                $s->menu_title,
                $s->capability,
                $s->menu_slug,
                $s->callback
            );
        }
    }

    /**
     * Register settings for the plugin.
     *
     * @since    1.0.0
     */
    public function settings(): void
    {
        /**
         * Get a list of option groups
         *
         * @var Albamn_Hskwakr_Admin_Settings_Option_Group
         */
        foreach (
            $this->settings->get_option_groups() as $og
        ) {
            /**
             * Get option names in each option groups
             *
             * @var string
             */
            foreach ($og->options as $v) {
                /**
                 * Register the setting
                 */
                register_setting($og->name, $v);
            }
        }
    }
}
