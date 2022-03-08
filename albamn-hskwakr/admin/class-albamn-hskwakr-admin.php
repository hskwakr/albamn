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
     * The pages that's responsible for admin enqueues.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Admin_Enqueues    $enqueues
     */
    protected $enqueues;

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
     * Include the following files that make up the plugin:
     *
     * - Albamn_Hskwakr_Admin_Menu. Custom menu of admin.
     * - Albamn_Hskwakr_Admin_Enqueues. Specific enqueues of admin.
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
         * The class responsible for admin enqueues.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-albamn-hskwakr-admin-enqueues.php';

        $this->enqueues = new Albamn_Hskwakr_Admin_Enqueues(
            $this->albamn_hskwakr,
            $this->version
        );
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles(): void
    {
        $this->enqueues->styles();
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts(): void
    {
        $this->enqueues->scripts();
    }

    /**
     * Add custom menu for this plugin.
     *
     * @since    1.0.0
     */
    public function admin_menu(): void
    {
        $admin_menu = new Albamn_Hskwakr_Admin_Menu();

        $b = $admin_menu->base();
        add_menu_page(
            $b->page_title,
            $b->menu_title,
            $b->capability,
            $b->menu_slug,
            $b->callback,
            $b->icon,
            $b->position
        );

        foreach ($admin_menu->sub() as $s) {
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
}
