<?php

/**
 * The admin importer pager.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The admin importer pager.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Importer_Pager extends Albamn_Hskwakr_Admin_Pager
{
    /**
     * The settings for the plugin
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Settings    $settings
     */
    private $settings;

    /**
     * The Instagram API
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Api    $ig_api
     */
    private $ig_api;

    /**
     * The formatter for Instagram medias
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Admin_Ig_Formatter    $ig_formatter
     */
    private $ig_formatter;

    /**
     * The access token for Instagram API
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $access_token
     */
    private $access_token = '';

    /**
     * The hashtag name for Instagram posts
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $hashtag
     */
    private $hashtag = '';

    /**
     * The method type to search for Instagram posts
     * top or recent
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $search_method
     */
    private $search_method = '';

    /**
     * The list of Instagram posts
     *
     * @since    1.0.0
     * @access   private
     * @var      array<Albamn_Hskwakr_Ig_Post>    $ig_posts
     */
    private $ig_posts;

    /**
     * The DB access for Instagram posts
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Post_Repository    $ig_repository
     */
    private $ig_repository;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Settings            $settings
     * @param    Albamn_Hskwakr_Ig_Api              $ig_api
     * @param    Albamn_Hskwakr_Ig_Post_Repository  $ig_repository
     * @param    Albamn_Hskwakr_Admin_Ig_Formatter  $ig_formatter
     */
    public function __construct(
        Albamn_Hskwakr_Settings $settings,
        Albamn_Hskwakr_Ig_Api $ig_api,
        Albamn_Hskwakr_Ig_Post_Repository $ig_repository,
        Albamn_Hskwakr_Admin_Ig_Formatter $ig_formatter
    ) {
        $this->settings = $settings;
        $this->ig_api = $ig_api;
        $this->ig_repository = $ig_repository;
        $this->ig_formatter = $ig_formatter;

        $this->ig_posts = array();
    }

    /**
     * Display importer page
     *
     * @since    1.0.0
     */
    public function display(): void
    {
        /**
         * Header
         */
        $status = $this->init();
        echo $this->display_header('Albamn Post Importer');
        echo $this->display_description('Importには５～１０分かかります。');

        /**
         * Contents
         */
        echo $this->display_self_form_header();
        echo $this->display_options();
        echo $this->display_form_footer();

        if ($status == 0) {
            /**
             * Get posts with Instagram API
             */
            echo $this->get_ig_posts();
        } elseif ($status == 2) {
            echo $this->display_alert_red('Filter required');
        } elseif ($status == 3) {
            echo $this->display_alert_red('Access token required');
        }

        /**
         * Footer
         */
        echo $this->display_footer();
    }

    /**
     * The preparation for display the page
     *
     * Check status to import post
     * If ready to import,
     * set necessary values to import posts
     *
     * @since    1.0.0
     * @return   int        The status
     *                      0 : ready to import posts
     *                      1 : need to set hashtag name
     *                      2 : need to set filter
     *                      3 : need to set access token
     */
    public function init(): int
    {
        /**
         * Check POST data from this page
         */
        if (empty($_POST['ig_hashtag'])) {
            return 1;
        }
        $hashtag = (string)$_POST['ig_hashtag'];

        if (empty($_POST['search_method'])) {
            return 2;
        }
        $search_method = (string)$_POST['search_method'];

        /**
         * Get access token from option
         */
        $access_token = $this->get_access_token();
        if (empty($access_token)) {
            return 3;
        }

        /**
         * Set necessary values to import posts
         */
        $this->access_token = $access_token;
        $this->hashtag = $hashtag;
        $this->search_method = $search_method;

        return 0;
    }

    /**
     * Get Facebook API access token
     *
     * @since    1.0.0
     * @return   string     The access token
     */
    public function get_access_token(): string
    {
        $general = $this->settings->general();
        return (string)$this->settings->get_option(
            (string)$general->options[0],
            '',
            $general->name
        );
    }

    /**
     * Get posts with Instagram API
     *
     * @since    1.0.0
     * @return   string     The html posts or error
     */
    public function get_ig_posts(): string
    {
        /**
         * The return value
         *
         * @var string $r
         */
        $r = '';

        try {
            /**
             * Get posts by Instagram API
             *
             * @var array<object> $posts
             */
            $this->ig_api->init(
                $this->access_token
            );
            $this->ig_api->search_hashtag(
                $this->hashtag,
                $this->search_method
            );
            $posts = $this->ig_api->medias;

            /**
             * Filter posts
             *
             * @var array<Albamn_Hskwakr_Ig_Post>
             */
            $filtered_posts = $this->ig_api->filter_medias($posts);

            /**
             * Arrange posts
             *
             * @var array<Albamn_Hskwakr_Ig_Post>
             */
            $this->ig_posts = $this->remove_duplicate($filtered_posts);
            if (empty($this->ig_posts)) {
                return $this->display_alert_red('No new data');
            }

            /**
             * Save to DB
             */
            $r = $r . $this->save_ig_posts($this->ig_posts);

            /**
             * Display Instagram posts
             */
            $r = $r . $this->format_ig_posts($this->ig_posts);

            return $r;
        } catch (Exception $e) {
            return $this->display_alert_red($e->getMessage());
        }
    }

    /**
     * Get posts with Instagram API
     *
     * @since    1.0.0
     * @param    array      $posts
     * @return   string     The html
     */
    public function format_ig_posts(array $posts): string
    {
        $error = 'Failed to display Instagram posts';
        if (!$this->ig_formatter->validate_medias($posts)) {
            $this->display_alert_red($error);
        }

        return $this->ig_formatter->format_medias_importer($posts);
    }

    /**
     * Save Instagram posts to DB
     *
     * @since    1.0.0
     * @param    array      $posts
     * @return   string     The html
     */
    public function save_ig_posts(array $posts): string
    {
        $error = 'Failed to save Instagram posts';
        $success = 'Successed to save Instagram posts';

        /**
         * @var mixed $post
         */
        foreach ($posts as $post) {
            if (!($post instanceof Albamn_Hskwakr_Ig_Post)) {
                return $this->display_alert_red($error);
            }

            /**
             * @var Albamn_Hskwakr_Ig_Post $post
             */
            $result = $this->ig_repository->add($post);
            if (!$result) {
                return $this->display_alert_red($error);
            }
        }

        return $this->display_alert_green($success);
    }

    /**
     * Remove duplicate posts between DB and posts
     * from posts
     *
     * @since    1.0.0
     * @param    array      $posts
     * @return   array      The arranged posts
     */
    public function remove_duplicate(
        array $posts
    ): array {
        /**
         * The arranged posts
         */
        $arranged = array();

        /**
         * @var Albamn_Hskwakr_Ig_Post $post
         */
        foreach ($posts as $post) {
            if (!$this->is_in_db($post)) {
                $arranged[] = $post;
            }
        }

        return $arranged;
    }

    /**
     * Check the post is in db
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Ig_Post     $post
     * @return   bool      Whether is in DB or not
     *                     true: is in DB
     *                     false: is not in DB
     */
    public function is_in_db(
        Albamn_Hskwakr_Ig_Post $post
    ): bool {
        /**
         * Find post in DB
         */
        $result = $this->ig_repository->find_by($post->id);

        if ($result == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * The html to display a options
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_options(): string
    {
        $r = '';

        /**
         * Input text
         */
        $r = $r . $this->display_input_text(
            "ig_hashtag",
            "",
            "Hashtag",
            "Don't need #"
        );

        /**
         * Input radio
         */
        $labels = array(
            'Popular',
            'New'
        );
        $values = array(
            'top',
            'recent'
        );
        $r = $r . $this->display_input_radio(
            'Filter',
            'search_method',
            count($labels),
            0,
            $labels,
            $values
        );

        /**
         * Submit button
         */
        $r = $r . $this->display_form_button('Import');

        return $r;
    }
}
