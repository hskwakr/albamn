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
     * register admin menu of the plugin.
     *
     * @since    1.0.0
     */
    public function register(): void
    {
        // slug name for general page
        $menu_slug = 'albamn-hskwakr-general-settings.php';

        // register menu page
        add_menu_page(
            'Albamn General Settings',
            'Albamn',
            'manage_options',
            $menu_slug,
            array( $this, 'general_settings_page' ),
            'dashicons-tickets',
            250
        );

        // register submenu pages
        $this->register_submenu($this->get_subpages($menu_slug));
    }

    /**
     * register admin sub menu of the plugin.
     *
     * @since    1.0.0
     */
    private function get_subpages(string $parent): array
    {
        return array(
            array(
                'parent_slug' => $parent,
                'page_title' => 'Albamn General Settings',
                'menu_title' => 'Settings',
                'capability' => 'manage_options',
                'menu_slug' => $parent,
                'callback' => array( $this, 'general_settings_page' )
            ),
            array(
                'parent_slug' => $parent,
                'page_title' => 'Albamn Instagram Importer',
                'menu_title' => 'Importer',
                'capability' => 'manage_options',
                'menu_slug' => 'albamn-hskwakr-instagram-importer.php',
                'callback' => array( $this, 'instagram_importer_page' )
            ),
        );
    }

    /**
     * register admin sub menu of the plugin.
     *
     * @since    1.0.0
     */
    private function register_submenu(array $pages): void
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
    public function general_settings_page(): void
    {
    }

    /**
     * Load instagram importer page.
     *
     * @since    1.0.0
     */
    public function instagram_importer_page(): void
    {
    }
}
