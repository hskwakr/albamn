<?php

/**
 * The admin-specific custom menu of the plugin.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The admin-specific custom menu of the plugin.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Menu
{
    /**
     * The slug that's responsible for main admin page.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $slug
     */
    protected $slug;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Admin_Pages    $pages
     */
    public function __construct()
    {
        $this->slug = 'albamn-hskwakr-general-settings.php';
    }

    /**
     * register admin menu of the plugin.
     *
     * @since    1.0.0
     */
    public function register(): void
    {
        // register menu page
        add_menu_page(
            'Albamn General Settings',
            'Albamn',
            'manage_options',
            $this->slug,
            array($this, 'general_settings'),
            'dashicons-tickets',
            250
        );

        // register submenu pages
        $submenus = $this->get_submenus($this->slug);
        $this->register_submenus($submenus);
    }

    /**
     * register admin submenus of the plugin.
     *
     * @since    1.0.0
     * @param    string    $parent    the parent slug.
     * @return   array     a list of menus.
     */
    private function get_submenus(string $parent): array
    {
        return array(
            array(
                'parent_slug' => $parent,
                'page_title' => 'Albamn General Settings',
                'menu_title' => 'Settings',
                'capability' => 'manage_options',
                'menu_slug' => $parent,
                'callback' => array($this, 'general_settings')
            ),
            array(
                'parent_slug' => $parent,
                'page_title' => 'Albamn Instagram Importer',
                'menu_title' => 'Importer',
                'capability' => 'manage_options',
                'menu_slug' => 'albamn-hskwakr-instagram-importer.php',
                'callback' => array($this, 'instagram_importer')
            ),
        );
    }

    /**
     * register admin sub menu of the plugin.
     *
     * @since    1.0.0
     */
    private function register_submenus(array $pages): void
    {
        foreach ($pages as $p) {
            add_submenu_page(
                $p['parent_slug'],
                $p['page_title'],
                $p['menu_title'],
                $p['capability'],
                $p['menu_slug'],
                $p['callback']
            );
        }
    }

    /**
     * Load general settings page.
     *
     * @since    1.0.0
     */
    public function general_settings(): void
    {
        require_once 'partials/albamn-hskwakr-admin-display.php';
    }

    /**
     * Load instagram importer page.
     *
     * @since    1.0.0
     */
    public function instagram_importer(): void
    {
    }
}
