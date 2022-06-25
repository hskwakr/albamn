<?php

/**
 * The context for Instagram API.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The context for Instagram API.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Api
{
    /**
     * The context of Instagram API
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Api_Context|null    $ctx
     */
    private $ctx;

    /**
     * The base url of the API.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $fb_api_base
     */
    public $fb_api_base = 'https://graph.facebook.com/v12.0';

    /**
     * The user pages id for Facebook pages.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $pages_id
     */
    public $pages_id = '';

    /**
     * The user id for Instagram business account.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $user_id
     */
    public $user_id = '';

    /**
     * The hashtag id in Instagram.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $hashtag_id
     */
    public $hashtag_id = '';

    /**
     * The recent medias that has specific hashtag in Instagram.
     *
     * @since    1.0.0
     * @access   public
     * @var      array    $medias
     */
    public $medias = array();

    /**
     * Initialize the class and set its properties.
     *
     * @since     1.0.0
     */
    public function __construct()
    {
        $this->ctx = null;
    }

    /**
     * Init this class with access token or context object.
     *
     * @since     1.0.0
     * @param     mixed     $arg    The argument should be access token or api context object.
     * @return    object    The instance of this class
     */
    public function init($arg): object
    {
        if (
            $this->validate_init_arg($arg) != null
        ) {
            /**
             * @var Albamn_Hskwakr_Ig_Api_Context $this->ctx
             */
            try {
                /**
                 * Get user pages id for facebook pages
                 */
                $this->pages_id = $this->ctx->user_pages_id();

                /**
                 * Get user id for instagram business account
                 */
                $this->user_id = $this->ctx->ig_user_id($this->pages_id);
            } catch (Exception $e) {
                $this->error('Failed to init', $e);
            }
        }

        return $this;
    }

    /**
     * Validate init argument and set or init context
     *
     * @since     1.0.0
     * @param     mixed     $arg    The argument should be access token or api context object.
     * @return    Albamn_Hskwakr_Ig_Api_Context|null    The context object.
     */
    public function validate_init_arg($arg)
    {
        $error = 'Failed to init: ';

        switch (gettype($arg)) {
            case 'string':
                /**
                 * $arg should be access token
                 */
                $this->init_context($arg);
                break;

            case 'object':
                if (
                    ($arg instanceof Albamn_Hskwakr_Ig_Api_Context)
                ) {
                    /**
                     * $arg should be context object
                     *
                     * @var Albamn_Hskwakr_Ig_Api_Context
                     */
                    $this->set_context($arg);
                } else {
                    $this->error($error . 'unexpected object type');
                }
                break;

            default:
                $this->error($error . 'unexpected argument type');
                break;
        }

        return $this->ctx;
    }

    /**
     * Init this class.
     *
     * @since     1.0.0
     * @param     string    $token
     */
    private function init_context(string $token): void
    {
        $http = new Albamn_Hskwakr_Ig_Http_Client();
        $query = new Albamn_Hskwakr_Ig_Query(
            $this->fb_api_base,
            $token
        );
        $validation = new Albamn_Hskwakr_Ig_Api_Response_Validation();
        $this->ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $http,
            $query,
            $validation,
            $token
        );
    }

    /**
     * Set a context of instagram api.
     *
     * @since     1.0.0
     * @param     Albamn_Hskwakr_Ig_Api_Context    $ctx
     */
    private function set_context(
        Albamn_Hskwakr_Ig_Api_Context $ctx
    ): void {
        $this->ctx = $ctx;
    }

    /**
     * Search recent medias by a name of hashtag in instagram.
     * And store the result of medias in array.
     *
     * @since     1.0.0
     * @param     string    $name
     * @return    object    The instance of this class
     */
    public function search_hashtag(string $name): object
    {
        /**
         * the method should be called after init
         */
        if (empty($this->ctx)) {
            throw new Exception(
                'The method should be called after init method'
            );
        }

        try {
            /**
             * Get hashtag id in instagram by hashtag name
             */
            $this->hashtag_id =
                $this->ctx->hashtag_id($this->user_id, $name);

            /**
             * Get recent medias
             * that has specific hashtag in instagram
             */
            $this->medias =
                $this->ctx->medias_top(
                    $this->user_id,
                    $this->hashtag_id
                );
        } catch (Exception $e) {
            $this->error('Failed to search hashtag', $e);
        }

        return $this;
    }

    /**
     * Filter the list of medias
     * to make the list that only contains VIDEO or IMAGE media
     *
     * @since     1.0.0
     * @param     array     $medias
     * @return    array     The list of filtered medias
     */
    public function filter_medias(array $medias): array
    {
        $error = 'Failed to filter medias';
        $r = array();

        /**
         * @var mixed $m
         */
        foreach ($medias as $m) {
            /**
             * Validate
             */
            if (!is_object($m)) {
                $this->error($error . ': Unexpected media object');
            }
            /**
             * Validate
             * @var object $m
             */
            if (!isset($m->media_type)) {
                continue;
            }

            switch ((string)$m->media_type) {
                case 'IMAGE':
                case 'VIDEO':
                    if (!isset($m->media_url)) {
                        break;
                    }
                    if (!isset($m->id)) {
                        break;
                    }

                    $r[] = new Albamn_Hskwakr_Ig_Post(
                        (string)$m->id,
                        (string)$m->media_type,
                        (string)$m->media_url,
                        (string)$m->permalink,
                        true
                    );
                    break;

                default:
                    break;
            }
        }

        /**
         * @var array<Albamn_Hskwakr_Ig_Post>
         */
        return $r;
    }

    /**
     * Error handling
     * Throw exception with error message
     *
     * @since     1.0.0
     * @param     string      $msg
     * @param     Throwable   $e
     */
    private function error(
        string $msg,
        Throwable $e=null
    ): void {
        if ($e == null) {
            throw new Exception(
                $msg,
                0,
                null
            );
        } else {
            throw new Exception(
                $msg . ': ' . $e->getMessage(),
                0,
                $e->getPrevious()
            );
        }
    }
}
