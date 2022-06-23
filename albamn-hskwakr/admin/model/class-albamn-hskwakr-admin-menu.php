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
     * The list of pager
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Admin_Pager_List    $pager_list
     */
    protected $pager_list;

    /**
     * The pager for general settings page.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Admin_Displayable | null   $settings_pager
     */
    protected $settings_pager;

    /**
     * The pager for importer page.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Admin_Displayable | null   $impoter_pager
     */
    protected $impoter_pager;

    /**
     * The pager for editor page.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Admin_Displayable | null   $editor_pager
     */
    protected $editor_pager;

    /**
     * The pager for about page.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Admin_Displayable | null   $about_pager
     */
    protected $about_pager;

    /**
     * Initialize the class and set its properties.
     *
     * @param    Albamn_Hskwakr_Admin_Pager_List   $pager_list
     * @since    1.0.0
     */
    public function __construct(
        Albamn_Hskwakr_Admin_Pager_List $pager_list
    ) {
        $this->slug = 'albamn-hskwakr-about.php';

        $this->pager_list = $pager_list;
        $this->init_pager();
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
            'Albamn About',
            'Albamn',
            'manage_options',
            $this->slug,
            array($this, 'about'),
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
                'Albamn About',
                'About',
                'manage_options',
                $this->slug,
                array($this, 'about')
            ),
            new Albamn_Hskwakr_Admin_Menu_Sub(
                $this->slug,
                'Albamn General Settings',
                'Settings',
                'manage_options',
                'albamn-hskwakr-general-settings.php',
                array($this, 'general_settings'),
            ),
            new Albamn_Hskwakr_Admin_Menu_Sub(
                $this->slug,
                'Albamn Post Importer',
                'Importer',
                'manage_options',
                'albamn-hskwakr-post-importer.php',
                array($this, 'post_importer'),
            ),
            new Albamn_Hskwakr_Admin_Menu_Sub(
                $this->slug,
                'Albamn Post Editor',
                'Editor',
                'manage_options',
                'albamn-hskwakr-post-editor.php',
                array($this, 'post_editor')
            ),
        );
    }

    /**
     * Init pagers
     *
     * @since    1.0.0
     */
    private function init_pager(): void
    {
        /**
         * Get list of pager
         *
         * @var array<string, Albamn_Hskwakr_Admin_Displayable> $list
         */
        $list = $this->pager_list->get();

        /**
         * Set pager
         */
        foreach ($list as $key => $value) {
            if ($key == 'general') {
                $this->settings_pager = $value;
            }

            if ($key == 'importer') {
                $this->impoter_pager = $value;
            }

            if ($key == 'editor') {
                $this->editor_pager = $value;
            }

            if ($key == 'about') {
                $this->about_pager = $value;
            }
        }
    }

    /**
     * Load about page.
     *
     * @since    1.0.0
     */
    public function about(): void
    {
        if (!empty($this->about_pager)) {
            $this->about_pager->display();
        }
    }

    /**
     * Load general settings page.
     *
     * @since    1.0.0
     */
    public function general_settings(): void
    {
        if (!empty($this->settings_pager)) {
            $this->settings_pager->display();
        }
    }

    /**
     * Load importer page.
     *
     * @since    1.0.0
     */
    public function post_importer(): void
    {
        if (!empty($this->impoter_pager)) {
            $this->impoter_pager->display();
        }
    }

    /**
     * Load edit page.
     *
     * @since    1.0.0
     */
    public function post_editor(): void
    {
        if (!empty($this->editor_pager)) {
            $this->editor_pager->display();
        }
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
