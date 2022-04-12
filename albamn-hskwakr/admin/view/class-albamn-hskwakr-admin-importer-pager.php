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
class Albamn_Hskwakr_Admin_Importer_Pager implements Albamn_Hskwakr_Admin_Displayable
{
    /**
     * The settings for the plugin
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Admin_Settings    $settings
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
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Admin_Settings    $settings
     * @param    Albamn_Hskwakr_Ig_Api            $ig_api
     */
    public function __construct(
        Albamn_Hskwakr_Admin_Settings $settings,
        Albamn_Hskwakr_Ig_Api $ig_api
    ) {
        $this->settings = $settings;
        $this->ig_api = $ig_api;
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
        echo $this->display_header();

        /**
         * Contents
         */
        echo $this->display_form_header();
        echo $this->display_options();
        echo $this->display_form_footer();

        if ($status == 0) {
            /**
             * Get posts with Instagram API
             */
            echo $this->get_ig_posts();
        } elseif ($status == 2) {
            echo $this->display_warning('Access token required');
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
     *                      2 : need to set access token
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

        /**
         * Get access token from option
         */
        $access_token = $this->get_access_token();
        if (empty($access_token)) {
            return 2;
        }

        /**
         * Set necessary values to import posts
         */
        $this->access_token = $access_token;
        $this->hashtag = $hashtag;

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
        try {
            $this->ig_api->init($this->access_token);
            $this->ig_api->search_hashtag($this->hashtag);
            $posts = $this->ig_api->recent_medias;

            return $this->format_ig_posts($posts);
        } catch (Exception $e) {
            return $this->display_warning($e->getMessage());
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
        $r = '';

        foreach ($posts as $p) {
            /**
             * Validate argument
             */
            if (!is_object($p)) {
                return $this->display_warning($error);
            }
            if (!isset($p->media_type)) {
                continue;
            }

            switch ($p->media_type) {
                case 'IMAGE':
                    $r = $r . $this->display_ig_image_post($p);
                    break;

                case 'VIDEO':
                    $r = $r . $this->display_ig_video_post($p);
                    break;

                default:

                    break;
            }
        }

        return $r;
    }

    /**
     * Display the Instagram image post
     *
     * @since    1.0.0
     * @param    object     $post
     * @return   string     The html
     */
    public function display_ig_image_post($post): string
    {
        $error = 'Failed to display image post';

        /**
         * Validate argument
         */
        if (!isset($post->media_type)) {
            return $this->display_warning($error);
        }
        if ($post->media_type != 'IMAGE') {
            return $this->display_warning($error);
        }
        if (!isset($post->media_url) || !is_string($post->media_url)) {
            return $this->display_warning($error);
        }

        /**
         * Make html
         */
        $r = '';
        $linkable =
            isset($post->permalink) && is_string($post->permalink);

        if ($linkable) {
            $r = $r . '<a href="' . $post->permalink . '>';
        }

        $r = $r . '<img src="' . $post->media_url . '/>';

        if ($linkable) {
            $r = $r . '</a>';
        }

        return $r;
    }

    /**
     * Display the Instagram video post
     *
     * @since    1.0.0
     * @param    object     $post
     * @return   string     The html
     */
    public function display_ig_video_post($post): string
    {
        $error = 'Failed to display video post';

        /**
         * Validate argument
         */
        if (!isset($post->media_type)) {
            return $this->display_warning($error);
        }
        if ($post->media_type != 'VIDEO') {
            return $this->display_warning($error);
        }
        if (!isset($post->media_url) || !is_string($post->media_url)) {
            return $this->display_warning($error);
        }

        /**
         * Make html
         */
        $r = '';
        $linkable =
            isset($post->permalink) && is_string($post->permalink);

        if ($linkable) {
            $r = $r . '<a href="' . $post->permalink . '>';
        }

        $r = $r . '<video src="'
                . $post->media_url
                . '" autoplay="" muted="" playsinline="" loop=""></video>';

        if ($linkable) {
            $r = $r . '</a>';
        }

        return $r;
    }

    /**
     * The html to display header
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_header(): string
    {
        return <<< EOF

<div class="container-sm col-sm-8" style="margin: 1rem 0rem 0rem;">
  <h3 style="margin-bottom: 1rem;">
    Albamn Post Importer
  </h3>

EOF;
    }

    /**
     * The html to display footer
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_footer(): string
    {
        return <<< EOF

</div>

EOF;
    }

    /**
     * The html to display warning
     *
     * @since    1.0.0
     * @param    string    $msg          the message.
     * @return   string    The html
     */
    public function display_warning($msg): string
    {
        return <<< EOF

  <div class="alert alert-warning mt-2" role="alert">
    $msg
  </div>

EOF;
    }

    /**
     * The html to display header for form
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_form_header(): string
    {
        return <<< EOF

  <form method="POST" action="">

EOF;
    }

    /**
     * The html to display footer for form
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_form_footer(): string
    {
        return <<< EOF

    <button type="submit" class="btn btn-danger col-12">
      Import
    </button>
  </form>

EOF;
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
        $r = $r . $this->display_input_text(
            "ig_hashtag",
            "Hashtag",
            "Don't need #"
        );
        return $r;
    }

    /**
     * The html to display a input tag with label
     *
     * @since    1.0.0
     * @param    string    $name         the name of option.
     * @param    string    $label        the label to describe the option.
     * @param    string    $placeholder  the message when input is empty.
     * @return   string    The html
     */
    public function display_input_text(
        string $name,
        string $label,
        string $placeholder = ""
    ): string {
        return <<< EOF

    <div class="row mb-3">
      <label class="col-sm-4 col-from-label" for="{$name}">{$label}</label>

      <div class="col-sm-8">
        <input type="text" class="form-control" id="{$name}" name="{$name}" value="" placeholder="{$placeholder}" />
      </div>
    </div>

EOF;
    }

    /**
     * The html to display a input tag with label
     *
     * @since    1.0.0
     * @param    string    $name         the name of input.
     * @param    string    $value        the value of input
     * @return   string    The html
     */
    public function display_input_hidden(
        string $name,
        string $value
    ): string {
        return <<< EOF

        <input type="hidden" name="{$name}" value="{$value}">

EOF;
    }
}
