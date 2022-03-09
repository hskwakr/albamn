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
     */
    public function __construct()
    {
        $this->slug = 'albamn-hskwakr-general-settings.php';
    }

    /**
     * The base of admin submenus.
     *
     * @since    1.0.0
     * @return   Albamn_Hskwakr_Admin_Menu_Base
     */
    public function base(): Albamn_Hskwakr_Admin_Menu_Base
    {
        return new Albamn_Hskwakr_Admin_Menu_Base(
            'Albamn General Settings',
            'Albamn',
            'manage_options',
            $this->slug,
            array($this, 'general_settings'),
            'dashicons-tickets',
            250
        );
    }

    /**
     * The admin submenus
     *
     * @since    1.0.0
     * @return   array     a list of class Albamn_Hskwakr_Admin_Menu_Sub.
     */
    public function sub(): array
    {
        return array(
            new Albamn_Hskwakr_Admin_Menu_Sub(
                $this->slug,
                'Albamn General Settings',
                'Settings',
                'manage_options',
                $this->slug,
                array($this, 'general_settings')
            ),
            new Albamn_Hskwakr_Admin_Menu_Sub(
                $this->slug,
                'Albamn Instagram Importer',
                'Importer',
                'manage_options',
                'albamn-hskwakr-instagram-importer.php',
                array($this, 'instagram_importer')
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

/**
 * The base menu of the admin.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Menu_Base
{
    /**
     * The text to be displayed in the title tags of the page
     * when the menu is selected.
     *
     * @since    1.0.0
     * @access   public
     * @var      string
     */
    public $page_title;

    /**
     * The text to be used for the menu.
     *
     * @since    1.0.0
     * @access   public
     * @var      string
     */
    public $menu_title;

    /**
     * The capability required for this menu
     * to be displayed to the user.
     *
     * @since    1.0.0
     * @access   public
     * @var      string
     */
    public $capability;

    /**
     * The slug name to refer to this menu by.
     *
     * @since    1.0.0
     * @access   public
     * @var      string
     */
    public $menu_slug;

    /**
     * The URL to the icon to be used for this menu.
     *
     * @since    1.0.0
     * @access   public
     * @var      string
     */
    public $icon;

    /**
     * The position in the menu order this item should appear.
     *
     * @since    1.0.0
     * @access   public
     * @var      int
     */
    public $position;

    /**
     * The function to be called to output the content for this page.
     *
     * @since    1.0.0
     * @access   public
     * @var      callable
     */
    public $callback;

    public function __construct(
        string $page_title,
        string $menu_title,
        string $capability,
        string $menu_slug,
        callable $callback,
        string $icon,
        int $position
    ) {
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;
        $this->capability = $capability;
        $this->menu_slug = $menu_slug;
        $this->callback = $callback;
        $this->icon = $icon;
        $this->position = $position;
    }
}

/**
 * The sub menu of the admin.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Menu_Sub
{
    /**
     * The slug name for the base menu.
     *
     * @since    1.0.0
     * @access   public
     * @var      string
     */
    public $base;

    /**
     * The text to be displayed in the title tags of the page
     * when the menu is selected.
     *
     * @since    1.0.0
     * @access   public
     * @var      string
     */
    public $page_title;

    /**
     * The text to be used for the menu.
     *
     * @since    1.0.0
     * @access   public
     * @var      string
     */
    public $menu_title;

    /**
     * The capability required for this menu
     * to be displayed to the user.
     *
     * @since    1.0.0
     * @access   public
     * @var      string
     */
    public $capability;

    /**
     * The slug name to refer to this menu by.
     *
     * @since    1.0.0
     * @access   public
     * @var      string
     */
    public $menu_slug;

    /**
     * The function to be called to output the content for this page.
     *
     * @since    1.0.0
     * @access   public
     * @var      callable
     */
    public $callback;

    public function __construct(
        string $base,
        string $page_title,
        string $menu_title,
        string $capability,
        string $menu_slug,
        callable $callback
    ) {
        $this->base = $base;
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;
        $this->capability = $capability;
        $this->menu_slug = $menu_slug;
        $this->callback = $callback;
    }
}
