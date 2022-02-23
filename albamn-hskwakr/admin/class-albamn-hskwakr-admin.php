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
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles(): void
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Albamn_Hskwakr_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Albamn_Hskwakr_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->albamn_hskwakr, plugin_dir_url(__FILE__) . 'css/albamn-hskwakr-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts(): void
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Albamn_Hskwakr_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Albamn_Hskwakr_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->albamn_hskwakr, plugin_dir_url(__FILE__) . 'js/albamn-hskwakr-admin.js', array( 'jquery' ), $this->version, false);
    }

    /**
     * Add custom menu for this plugin.
     *
     * @since    1.0.0
     */
    public function admin_menu(): void
    {
        $admin_menu = new Albamn_Hskwakr_Admin_Menu();
        $admin_menu->register();
    }
}
