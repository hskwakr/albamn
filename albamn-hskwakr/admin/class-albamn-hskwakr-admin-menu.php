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
     * The base of admin submenus.
     *
     * @since    1.0.0
     * @param    string    $parent    the parent slug.
     * @return   array     a list of menus.
     */
    public function base(): array
    {
        return array(
            'page_title' => 'Albamn General Settings',
            'menu_title' => 'Albamn',
            'capability' => 'manage_options',
            'menu_slug' => $this->slug,
            'callback' => array($this, 'general_settings'),
            'icon' => 'dashicons-tickets',
            'position' => 250
        );
    }

    /**
     * The admin submenus
     *
     * @since    1.0.0
     * @param    string    $parent    the parent slug.
     * @return   array     a list of menus.
     */
    public function sub(): array
    {
        return array(
            array(
                'parent_slug' => $this->slug,
                'page_title' => 'Albamn General Settings',
                'menu_title' => 'Settings',
                'capability' => 'manage_options',
                'menu_slug' => $this->slug,
                'callback' => array($this, 'general_settings')
            ),
            array(
                'parent_slug' => $this->slug,
                'page_title' => 'Albamn Instagram Importer',
                'menu_title' => 'Importer',
                'capability' => 'manage_options',
                'menu_slug' => 'albamn-hskwakr-instagram-importer.php',
                'callback' => array($this, 'instagram_importer')
            ),
        );
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
