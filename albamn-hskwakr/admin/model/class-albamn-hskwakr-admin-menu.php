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
     * The pager for general settings page.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Admin_Displayable   $settings_pager
     */
    protected $settings_pager;

    /**
     * The pager for importer page.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Admin_Displayable   $impoter_pager
     */
    protected $impoter_pager;

    /**
     * The pager for editor page.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Albamn_Hskwakr_Admin_Displayable   $editor_pager
     */
    protected $editor_pager;

    /**
     * Initialize the class and set its properties.
     *
     * @param    Albamn_Hskwakr_Admin_Displayable   $settings_pager
     * @param    Albamn_Hskwakr_Admin_Displayable   $impoter_pager
     * @param    Albamn_Hskwakr_Admin_Displayable   $editor_pager
     * @since    1.0.0
     */
    public function __construct(
        Albamn_Hskwakr_Admin_Displayable $settings_pager,
        Albamn_Hskwakr_Admin_Displayable $impoter_pager,
        Albamn_Hskwakr_Admin_Displayable $editor_pager
    ) {
        $this->slug = 'albamn-hskwakr-general-settings.php';
        $this->settings_pager = $settings_pager;
        $this->impoter_pager = $impoter_pager;
        $this->editor_pager = $editor_pager;
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
     * Load about page.
     *
     * @since    1.0.0
     */
    public function about(): void
    {
    }

    /**
     * Load general settings page.
     *
     * @since    1.0.0
     */
    public function general_settings(): void
    {
        $this->settings_pager->display();
    }

    /**
     * Load importer page.
     *
     * @since    1.0.0
     */
    public function post_importer(): void
    {
        $this->impoter_pager->display();
    }

    /**
     * Load edit page.
     *
     * @since    1.0.0
     */
    public function post_editor(): void
    {
        $this->editor_pager->display();
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
