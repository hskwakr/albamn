<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/includes
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $albamn_hskwakr    The string used to uniquely identify this plugin.
     */
    protected $albamn_hskwakr;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('ALBAMN_HSKWAKR_VERSION')) {
            $this->version = ALBAMN_HSKWAKR_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->albamn_hskwakr = 'albamn-hskwakr';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Albamn_Hskwakr_Loader. Orchestrates the hooks of the plugin.
     * - Albamn_Hskwakr_i18n. Defines internationalization functionality.
     * - Albamn_Hskwakr_Admin. Defines all hooks for the admin area.
     * - Albamn_Hskwakr_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies(): void
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-albamn-hskwakr-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-albamn-hskwakr-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-albamn-hskwakr-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-albamn-hskwakr-public.php';

        $this->loader = new Albamn_Hskwakr_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Albamn_Hskwakr_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale(): void
    {
        $plugin_i18n = new Albamn_Hskwakr_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks(): void
    {
        $plugin_admin = new Albamn_Hskwakr_Admin($this->get_albamn_hskwakr(), $this->get_version());

        /**
         * Enqueue
         *
         * Register css/js
         */
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue');

        /**
         * Menu
         *
         * Register menu for admin page
         */
        $this->loader->add_action('admin_menu', $plugin_admin, 'menu');

        /**
         * Settings
         *
         * Register settings for the plugin
         */
        $this->loader->add_action('admin_init', $plugin_admin, 'register_settings');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks(): void
    {
        $plugin_public = new Albamn_Hskwakr_Public($this->get_albamn_hskwakr(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run(): void
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_albamn_hskwakr(): string
    {
        return $this->albamn_hskwakr;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Albamn_Hskwakr_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader(): Albamn_Hskwakr_Loader
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version(): string
    {
        return $this->version;
    }
}
