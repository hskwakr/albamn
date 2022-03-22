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
          . 'class-albamn-hskwakr-admin-menu.php';

        /**
         * The class responsible for admin enqueue.
         */
        require_once $path
          . 'class-albamn-hskwakr-admin-enqueue.php';

        /**
         * The class responsible for admin settings.
         */
        require_once $path
          . 'class-albamn-hskwakr-admin-settings.php';

        /**
         * View
         */

        /**
         * The class responsible for admin setting pager.
         */
        require_once $path
          . 'class-albamn-hskwakr-admin-setting-pager.php';

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

        /**
         * Style
         *
         * @var Albamn_Hskwakr_Admin_Enqueue_Style
         */
        foreach ($enqueue->styles() as $s) {
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
        foreach ($enqueue->scripts() as $s) {
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
        $settings_pager = new Albamn_Hskwakr_Admin_Setting_Pager($this->settings);
        $menu = new Albamn_Hskwakr_Admin_Menu($settings_pager);

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
         * @var Albamn_Hskwakr_Admin_Setting_Option
         */
        foreach ($this->settings->get_options() as $option) {
            /**
             * Get a list of setting names for a option group
             *
             * @var string
             */
            foreach ($option->group as $v) {
                /**
                 * Register the setting
                 */
                register_setting($option->name, $v);
            }
        }
    }
}
