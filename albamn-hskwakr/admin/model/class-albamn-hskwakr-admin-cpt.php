<?php

/**
 * The custom post time for the plugin.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The custom post time for the plugin.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Cpt
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
     * @param    string    $albamn_hskwakr    The name of the plugin.
     * @param    string    $version           The version of this plugin.
     */
    public function __construct($albamn_hskwakr, $version)
    {
        $this->albamn_hskwakr = $albamn_hskwakr;
        $this->version = $version;
    }

    /**
     * Get the list of custom post types.
     *
     * @since    1.0.0
     * @return   array     The list of cpts
     */
    public function get(): array
    {
        return array(
            $this->ig_posts()
        );
    }

    /**
     * Get the custom post type for Instagram posts
     *
     * This method contains Wordpress API
     *
     * @since    1.0.0
     * @return   array     The array for cpt
     */
    public function ig_posts(): array
    {
        $name = $this->albamn_hskwakr . 'ig-posts';
        $taxsonomies = array($this->hyphen_to_underbar($name));

        $labels = new Albamn_Hskwakr_Admin_Cpt_Label(
            (string)_x('Instagram Posts', 'Post Type General Name'),
            (string)_x('Instagram Post', 'Post Type Singular Name'),
            (string)__('Add New'),
            (string)__('Add New Instagram Post'),
            (string)__('Edit'),
            (string)__('View Posts'),
            (string)__('Search'),
            (string)__('Not Found'),
            (string)__('Not found in Trash'),
            (string)__('Parent Post'),
            (string)__('All Posts'),
            (string)__('Instagram Posts'),
            (string)__('Update'),
        );

        $supports = new Albamn_Hskwakr_Admin_Cpt_Support(
            true,
            true,
            true,
            true,
            true,
            false,
            true,
            true,
            true,
            false,
            false
        );

        $arg = new Albamn_Hskwakr_Admin_Cpt_Arg(
            $labels,
            $supports,
            (string)__('Instagram Posts'),
            'post',
            $taxsonomies,
            true,
            false,
            false,
            false,
            false,
            false,
            false,
            true,
            true,
            true,
            true
        );

        return $arg->get_array();
    }

    /**
     * Replace - to _ in the string.
     *
     * @since    1.0.0
     * @param    string    $arg    The string.
     * @return   string    The replaced list
     */
    public function hyphen_to_underbar(string $arg): string
    {
        return str_replace('-', '_', $arg);
    }
}

/**
 * The arg for the custom post type.
 *
 * https://developer.wordpress.org/reference/functions/register_post_type/
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Cpt_Arg
{
    /**
     * The labels for this post type.
     *
     * @since    1.0.0
     * @access   public
     * @var      Albamn_Hskwakr_Admin_Cpt_Label     $labels
     */
    public $labels;

    /**
     * Core feature(s) the post type supports.
     *
     * @since    1.0.0
     * @access   public
     * @var      Albamn_Hskwakr_Admin_Cpt_Support     $supports
     */
    public $supports;

    /**
     * A short descriptive summary of what the post type is.
     *
     * @since    1.0.0
     * @access   public
     * @var      string     $description
     */
    public $description;

    /**
     * The string to use to build
     * the read, edit, and delete capabilities.
     *
     * @since    1.0.0
     * @access   public
     * @var      string     $capability_type
     */
    public $capability_type;

    /**
     * An array of taxonomy identifiers
     * that will be registered for the post type.
     *
     * @since    1.0.0
     * @access   public
     * @var      array     $taxonomies
     */
    public $taxonomies;

    /**
     * Whether a post type is intended for use publicly
     * either via the admin interface or by front-end users.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $public
     */
    public $public;

    /**
     * Whether the post type is hierarchical.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $hierarchical
     */
    public $hierarchical;

    /**
     * Whether to generate a default UI
     * for managing this post type in the admin.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $show_ui
     */
    public $show_ui;

    /**
     * Whether post_type is available
     * for selection in navigation menus.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $show_in_nav_menus
     */
    public $show_in_nav_menus;

    /**
     * Where to show the post type in the admin menu.
     * show_ui must be true.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $show_in_menu
     */
    public $show_in_menu;

    /**
     * Whether to make this post type available
     * in the WordPress admin bar.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $show_in_admin_bar
     */
    public $show_in_admin_bar;

    /**
     * Whether to expose this post type in the REST API.
     * Must be true to enable the Gutenberg editor.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $can_export
     */
    public $can_export;

    /**
     * Enables post type archives.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $has_archive
     */
    public $has_archive;

    /**
     * Whether to exclude posts with this post type
     * from front end search results.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $exclude_from_search
     */
    public $exclude_from_search;

    /**
     * Whether to exclude posts with this post type
     * from front end search results.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $exclude_from_search
     */
    public $publicly_queryable;

    /**
     *  Whether to expose this post type in the REST API.
     *  Must be true to enable the Gutenberg editor.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool     $show_in_rest
     */
    public $show_in_rest;

    /**
     * The position in the menu order the post type should appear.
     * To work, $show_in_menu must be true.
     *
     * @since    1.0.0
     * @access   public
     * @var      int     $menu_position
     */
    public $menu_position;

    public function __construct(
        Albamn_Hskwakr_Admin_Cpt_Label $labels,
        Albamn_Hskwakr_Admin_Cpt_Support $supports,
        string $description,
        string $capability_type,
        array $taxonomies,
        bool $public,
        bool $hierarchical,
        bool $show_ui,
        bool $show_in_menu,
        bool $show_in_nav_menus,
        bool $show_in_admin_bar,
        bool $can_export,
        bool $has_archive,
        bool $exclude_from_search,
        bool $publicly_queryable,
        bool $show_in_rest,
        int $menu_position = 5
    ) {
        $this->labels = $labels;
        $this->supports = $supports;
        $this->description = $description;
        $this->capability_type = $capability_type;
        $this->taxonomies = $taxonomies;
        $this->hierarchical = $hierarchical;
        $this->public = $public;
        $this->show_ui = $show_ui;
        $this->show_in_menu = $show_in_menu;
        $this->show_in_nav_menus = $show_in_nav_menus;
        $this->show_in_admin_bar = $show_in_admin_bar;
        $this->can_export = $can_export;
        $this->has_archive = $has_archive;
        $this->exclude_from_search = $exclude_from_search;
        $this->publicly_queryable = $publicly_queryable;
        $this->show_in_rest = $show_in_rest;
        $this->menu_position = $menu_position;
    }

    /**
     * Create an array by properties.
     *
     * @since    1.0.0
     * @return   array    The array for the args.
     */
    public function get_array(): array
    {
        $r = array();

        $r['labels'] = $this->labels->get_array();
        $r['supports'] = $this->supports->get_array();
        $r['description'] = $this->description;
        $r['capability_type'] = $this->capability_type;
        $r['taxonomies'] = $this->taxonomies;
        $r['hierarchical'] = $this->hierarchical;
        $r['public'] = $this->public;
        $r['show_ui'] = $this->show_ui;
        $r['show_in_menu'] = $this->show_in_menu;
        $r['show_in_nav_menus'] = $this->show_in_nav_menus;
        $r['show_in_admin_bar'] = $this->show_in_admin_bar;
        $r['can_export'] = $this->can_export;
        $r['has_archive'] = $this->has_archive;
        $r['exclude_from_search'] = $this->exclude_from_search;
        $r['publicly_queryable'] = $this->publicly_queryable;
        $r['show_in_rest'] = $this->show_in_rest;
        $r['menu_position'] = $this->menu_position;

        return $r;
    }
}

/**
 * The labels for the custom post type.
 *
 * https://developer.wordpress.org/reference/functions/get_post_type_labels/
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Cpt_Label
{
    /**
     * General name for the post type, usually plural.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $name
     */
    public $name;

    /**
     * Name for one object of this post type.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $singular_name
     */
    public $singular_name;

    /**
     * Default is ‘Add New’ for both hierarchical
     * and non-hierarchical types.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $add_new
     */
    public $add_new;

    /**
     * Label for adding a new singular item.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $add_new_item
     */
    public $add_new_item;

    /**
     * Label for editing a singular item.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $edit_item
     */
    public $edit_item;

    /**
     * Label for viewing a singular item.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $view_item
     */
    public $view_item;

    /**
     * Label for searching plural items.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $search_items
     */
    public $search_items;

    /**
     * Label used when no items are found.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $not_found
     */
    public $not_found;

    /**
     * Label used when no items are in the Trash.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $not_found_in_trash
     */
    public $not_found_in_trash;

    /**
     * Label used to prefix parents of hierarchical items.
     * Not used on non-hierarchical post types.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $parent_item_colon
     */
    public $parent_item_colon;

    /**
     * Label to signify all items in a submenu link.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $all_items
     */
    public $all_items;

    /**
     * Label for the menu name.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $menu_name
     */
    public $menu_name;

    /**
     * Label used when an item is updated.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $item_updated
     */
    public $item_updated;

    public function __construct(
        string $name,
        string $singular_name,
        string $add_new,
        string $add_new_item,
        string $edit_item,
        string $view_item,
        string $search_items,
        string $not_found,
        string $not_found_in_trash,
        string $parent_item_colon,
        string $all_items,
        string $menu_name,
        string $item_updated
    ) {
        $this->name = $name;
        $this->singular_name = $singular_name;
        $this->add_new = $add_new;
        $this->add_new_item = $add_new_item;
        $this->edit_item = $edit_item;
        $this->view_item = $view_item;
        $this->search_items = $search_items;
        $this->not_found = $not_found;
        $this->not_found_in_trash = $not_found_in_trash;
        $this->parent_item_colon = $parent_item_colon;
        $this->all_items = $all_items;
        $this->menu_name = $menu_name;
        $this->item_updated = $item_updated;
    }

    /**
     * Create an array by properties.
     *
     * @since    1.0.0
     * @return   array    The array for the labels.
     */
    public function get_array(): array
    {
        $r = array();

        $r['name'] = $this->name;
        $r['singular_name'] = $this->singular_name;
        $r['add_new'] = $this->add_new;
        $r['add_new_item'] = $this->add_new_item;
        $r['edit_item'] = $this->edit_item;
        $r['view_item'] = $this->view_item;
        $r['search_items'] = $this->search_items;
        $r['not_found'] = $this->not_found;
        $r['not_found_in_trash'] = $this->not_found_in_trash;
        $r['parent_item_colon'] = $this->parent_item_colon;
        $r['all_items'] = $this->all_items;
        $r['menu_name'] = $this->menu_name;
        $r['item_updated'] = $this->item_updated;

        return $r;
    }
}

/**
 * The Core feature(s) for the custom post type.
 *
 * https://developer.wordpress.org/reference/functions/post_type_supports/
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Cpt_Support
{
    public $title;
    public $editor;
    public $author;
    public $thumbnail;
    public $excerpt;
    public $trackbacks;
    public $custom_fields;
    public $comments;
    public $revisions;
    public $page_attributes;
    public $post_formats;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct(
        bool $title,
        bool $editor,
        bool $author,
        bool $thumbnail,
        bool $excerpt,
        bool $trackbacks,
        bool $custom_fields,
        bool $comments,
        bool $revisions,
        bool $page_attributes,
        bool $post_formats
    ) {
        $this->title = $title;
        $this->editor = $editor;
        $this->author = $author;
        $this->thumbnail = $thumbnail;
        $this->excerpt = $excerpt;
        $this->trackbacks = $trackbacks;
        $this->custom_fields = $custom_fields;
        $this->comments = $comments;
        $this->revisions = $revisions;
        $this->page_attributes = $page_attributes;
        $this->post_formats = $post_formats;
    }

    /**
     * Create an array by properties.
     *
     * @since    1.0.0
     * @return   array    The array for the future of post type.
     */
    public function get_array(): array
    {
        $r = array();

        if ($this->title) {
            $r[] = 'title';
        }
        if ($this->editor) {
            $r[] = 'editor';
        }
        if ($this->author) {
            $r[] = 'author';
        }
        if ($this->thumbnail) {
            $r[] = 'thumbnail';
        }
        if ($this->excerpt) {
            $r[] = 'excerpt';
        }
        if ($this->trackbacks) {
            $r[] = 'trackbacks';
        }
        if ($this->custom_fields) {
            $r[] = 'custom-fields';
        }
        if ($this->comments) {
            $r[] = 'comments';
        }
        if ($this->revisions) {
            $r[] = 'revisions';
        }
        if ($this->page_attributes) {
            $r[] = 'page-attributes';
        }
        if ($this->post_formats) {
            $r[] = 'post-formats';
        }

        return $r;
    }
}
