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
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
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
     * The pages that's responsible for admin pages.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Admin_Pages    $pages
     */
    protected $pages;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $albamn_hskwakr       The name of this plugin.
     * @param      string    $version    The version of this plugin.
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
     * Include the following files that make up the plugin:
     *
     * - Albamn_Hskwakr_Admin_Menu. Custom menu of admin.
     * - Albamn_Hskwakr_Admin_Pages. Specific pages of admin.
     *
     * Create an instans of pages.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies(): void
    {
        /**
         * The class responsible for admin custom menu.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-albamn-hskwakr-admin-menu.php';

        /**
         * The class responsible for admin pages.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-albamn-hskwakr-admin-pages.php';

        $this->pages = new Albamn_Hskwakr_Admin_Pages();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles(): void
    {
        wp_enqueue_style($this->albamn_hskwakr, plugin_dir_url(__FILE__) . 'css/albamn-hskwakr-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts(): void
    {
        wp_enqueue_script($this->albamn_hskwakr, plugin_dir_url(__FILE__) . 'js/albamn-hskwakr-admin.js', array( 'jquery' ), $this->version, false);
    }

    /**
     * Add custom menu for this plugin.
     *
     * @since    1.0.0
     */
    public function admin_menu(): void
    {
        $admin_menu = new Albamn_Hskwakr_Admin_Menu($this->pages);
        $admin_menu->register();
    }
}
