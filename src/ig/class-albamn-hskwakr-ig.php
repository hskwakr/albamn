<?php

/**
 * The Instagram functionality of the plugin.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The Instagram functionality of the plugin.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig
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
     * The custom post types for the plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Cpt    $cpt
     */
    private $cpt;

    /**
     * The Instagram api
     *
     * @since    1.0.0
     * @access   public
     * @var      Albamn_Hskwakr_Ig_Api    $api
     */
    public $api;

    /**
     * The post data access in DB
     *
     * @since    1.0.0
     * @access   public
     * @var      Albamn_Hskwakr_Ig_Post_Repository    $post_repository
     */
    public $post_repository;

    /**
     * The formatter to display html
     *
     * @since    1.0.0
     * @access   public
     * @var      Albamn_Hskwakr_Admin_Ig_Formatter    $post_formatter
     */
    public $post_formatter;

    /**
     * The shortcode to display list of posts in Instagram
     *
     * @since    1.0.0
     * @access   public
     * @var      Albamn_Hskwakr_Ig_Shortcode    $shortcode
     */
    public $shortcode;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $albamn_hskwakr    The name of the plugin.
     * @param    string    $version           The version of this plugin.
     * @param    Albamn_Hskwakr_Cpt     $cpt               The custom post type of this plugin.
     */
    public function __construct(
        string $albamn_hskwakr,
        string $version,
        Albamn_Hskwakr_Cpt $cpt
    ) {
        $this->albamn_hskwakr = $albamn_hskwakr;
        $this->version = $version;
        $this->cpt = $cpt;

        $this->load_dependencies();
        $this->instantiate();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies(): void
    {
        /**
         * Location of admin folder in the plugin
         */
        $path = plugin_dir_path(dirname(__FILE__)) . 'ig/';

        /**
         * Instagram API
         */

        /**
         * The class responsible for instagram api.
         */
        require_once $path
          . 'class-albamn-hskwakr-ig-api.php';

        /**
         * The client for http access.
         */
        require_once $path
          . 'class-albamn-hskwakr-ig-http-client.php';

        /**
         * The query for Instagram API.
         */
        require_once $path
          . 'class-albamn-hskwakr-ig-api-query.php';

        /**
         * The validation for response from Instagram API.
         */
        require_once $path
          . 'class-albamn-hskwakr-ig-api-response-validation.php';

        /**
         * The context for Instagram API.
         */
        require_once $path
          . 'class-albamn-hskwakr-ig-api-context.php';

        /**
         * The Instagram post
         */
        require_once $path
          . 'class-albamn-hskwakr-ig-post.php';

        /**
         * The DB access for Instagram posts
         */
        require_once $path
          . 'class-albamn-hskwakr-ig-post-repository.php';

        /**
         * The DB provider for Instagram posts
         */
        require_once $path
          . 'class-albamn-hskwakr-ig-post-db-provider.php';

        /**
         * The class responsible for instagram media formatter.
         */
        require_once $path
          . 'class-albamn-hskwakr-ig-formatter.php';

        /**
         * The class responsible for shortcode.
         */
        require_once $path
          . 'class-albamn-hskwakr-ig-shortcode.php';
    }

    /**
     * Instantiate public classes
     *
     * @since    1.0.0
     * @access   private
     */
    private function instantiate(): void
    {
        /**
         * Private instance
         */
        $db = new Albamn_Hskwakr_Ig_Post_Db_Provider(
            $this->cpt->ig_posts()
        );

        /**
         * Public instance
         */
        $this->api = new Albamn_Hskwakr_Ig_Api();
        $this->post_formatter = new Albamn_Hskwakr_Admin_Ig_Formatter();
        $this->post_repository = new Albamn_Hskwakr_Ig_Post_Repository(
            $db
        );
        $this->shortcode = new Albamn_Hskwakr_Ig_Shortcode(
            $this->post_repository,
            $this->post_formatter
        );
    }
}
