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
     * The custom post types for the plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Cpt    $cpt
     */
    private $cpt;

    /**
     * The Instagram functionality
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig    $ig
     */
    private $ig;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $albamn_hskwakr    The name of the plugin.
     * @param    string    $version           The version of this plugin.
     * @param    Albamn_Hskwakr_Cpt   $cpt    The custom post type of this plugin.
     * @param    Albamn_Hskwakr_Ig    $ig     The Instagram functionality of this plugin.
     */
    public function __construct(
        string $albamn_hskwakr,
        string $version,
        Albamn_Hskwakr_Cpt $cpt,
        Albamn_Hskwakr_Ig $ig
    ) {
        $this->albamn_hskwakr = $albamn_hskwakr;
        $this->version = $version;
        $this->cpt = $cpt;
        $this->ig = $ig;

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
         * The class responsible for admin editor pager.
         */
        require_once $path
          . 'view/class-albamn-hskwakr-admin-editor-pager.php';

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
            $this->settings,
            $this->ig->post_repository
        );

        /**
         * Instantiate importer pager
         */
        $importer = new Albamn_Hskwakr_Admin_Importer_Pager(
            $this->settings,
            $this->ig->api,
            $this->ig->post_formatter,
            $this->ig->post_repository
        );

        /**
         * Instantiate editor pager
         */
        $editor = new Albamn_Hskwakr_Admin_Editor_Pager(
            $this->ig->post_repository,
            $this->ig->post_formatter
        );

        /**
         * Instantiate menu
         */
        $menu = new Albamn_Hskwakr_Admin_Menu(
            $general,
            $importer,
            $editor
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

    /**
     * Add custom post type for the plugin.
     *
     * @since    1.0.0
     */
    public function cpt(): void
    {
        /**
         * Get a list of custom post types
         *
         * @var Albamn_Hskwakr_Cpt_Arg
         */
        foreach ($this->cpt->get() as $c) {
            $name = $c->labels->name;

            /**
             * Register custom post type
             */
            register_post_type($name, $c->get_array());
        }
    }
}
