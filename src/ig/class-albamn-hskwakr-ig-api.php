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
     * The data access for media file.
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Media_Repository    $media_repository
     */
    private $media_repository;

    /**
     * The base url of the API.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $fb_api_base
     */
    public $fb_api_base = 'https://graph.facebook.com/v14.0';

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
    public function __construct(
        Albamn_Hskwakr_Ig_Media_Repository $media_repository
    ) {
        $this->ctx = null;
        $this->media_repository = $media_repository;
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
     * @param     string    $name     The name of hashtag
     * @param     string    $method   The method to search medias by hashtag
     * @return    object    The instance of this class
     */
    public function search_hashtag(
        string $name,
        string $method = 'top'
    ): object {
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
             * Get medias
             * that has specific hashtag in instagram
             */
            switch ($method) {
                case 'top':
                    $this->medias =
                        $this->ctx->medias_top(
                            $this->user_id,
                            $this->hashtag_id
                        );

                    break;

                case 'recent':
                    $this->medias =
                        $this->ctx->medias_recent(
                            $this->user_id,
                            $this->hashtag_id
                        );

                    break;

                default:
                    $this->medias =
                        $this->ctx->medias_top(
                            $this->user_id,
                            $this->hashtag_id
                        );

                    break;
            }
        } catch (Exception $e) {
            $this->error('Failed to search hashtag', $e);
        }

        return $this;
    }

    /**
     * Filter the list of medias
     * only contains VIDEO or IMAGE or CAROUSEL_ALBUM media
     *
     * This method contains Wordpress API
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
            if (!isset($m->id)) {
                continue;
            }

            switch ((string)$m->media_type) {
                case 'IMAGE':
                    if (!isset($m->media_url)) {
                        break;
                    }

                    /**
                     * Create Instagram post
                     */
                    $r[] = $this->create_ig_post(
                        (string)$m->id,
                        (string)$m->media_type,
                        array(),
                        (string)$m->media_url,
                        array(),
                        (string)$m->permalink,
                        false
                    );
                    break;

                case 'VIDEO':
                    if (!isset($m->media_url)) {
                        break;
                    }

                    /**
                     * Download a media file.
                     */
                    $filename = (string)$m->id . '.mp4';
                    $url = $this->download_ig_media(
                        $filename,
                        (string)$m->media_url
                    );
                    if (empty($url)) {
                        break;
                    }

                    /**
                     * Create Instagram post
                     */
                    $r[] = $this->create_ig_post(
                        (string)$m->id,
                        (string)$m->media_type,
                        array(),
                        (string)$m->media_url,
                        array(),
                        (string)$m->permalink,
                        false
                    );
                    break;

                case 'CAROUSEL_ALBUM':
                    /**
                     * Validate ALBUM type media
                     */
                    if (!$this->validate_album_media($m)) {
                        break;
                    }

                    /**
                     * @var object $m->children
                     * @var array $data
                     */
                    $data = $m->children->data;

                    /**
                     * The list of media type
                     *
                     * @var array $media_type_list
                     */
                    $media_type_list = array();

                    /**
                     * The list of media url
                     *
                     * @var array $media_url_list
                     */
                    $media_url_list = array();

                    /**
                     * Get list of media_url in children
                     *
                     * @var object $v
                     */
                    foreach ($data as $v) {
                        if (!is_string($v->id)) {
                            break;
                        }
                        if (is_string($v->media_type)) {
                            $media_type_list[$v->id] = $v->media_type;
                        }
                        if (is_string($v->media_url)) {
                            $media_url_list[$v->id] = $v->media_url;
                        }
                    }

                    /**
                     * Create Instagram post
                     */
                    $r[] = $this->create_ig_post(
                        (string)$m->id,
                        (string)$m->media_type,
                        $media_type_list,
                        '',
                        $media_url_list,
                        (string)$m->permalink,
                        false
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
     * Create an object for a Instagram post
     *
     * @since     1.0.0
     * @param     string    $id
     * @param     string    $media_type
     * @param     string    $media_url
     * @param     array     $media_url_list
     * @param     string    $permalink
     * @param     bool      $visibility
     * @return    Albamn_Hskwakr_Ig_Post      The object
     */
    public function create_ig_post(
        string $id,
        string $media_type,
        array  $media_type_list,
        string $media_url,
        array  $media_url_list,
        string $permalink,
        bool   $visibility
    ): Albamn_Hskwakr_Ig_Post {
        return new Albamn_Hskwakr_Ig_Post(
            $id,
            $media_type,
            $media_type_list,
            $media_url,
            $media_url_list,
            $permalink,
            $visibility
        );
    }

    /**
     * Validate CAROUSEL_ALBUM type media
     *
     * @since     1.0.0
     * @param     object     $media      The media data.
     * @return    bool       true        The data is expected.
     *                       false       The data is unexpected.
     */
    public function validate_album_media(
        object $media
    ): bool {
        if (!isset($media->children)) {
            return false;
        }
        if (!is_object($media->children)) {
            return false;
        }
        if (!isset($media->children->data)) {
            return false;
        }
        if (!is_array($media->children->data)) {
            return false;
        }

        foreach ($media->children->data as $v) {
            if (!is_object($v)) {
                return false;
            }
            if (!isset($v->id)) {
                return false;
            }
            if (!isset($v->media_type)) {
                return false;
            }
            if (!isset($v->media_url)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Download an Instagram media file.
     *
     * @since     1.0.0
     * @param     string     $filename   The filename to store.
     * @param     string     $media_url  The url to download.
     * @return    string     The url to stored media file.
     *                       It returns empty if failed to download.
     */
    public function download_ig_media(
        string $filename,
        string $media_url
    ): string {
        $path = $this->media_repository->base_dir . $filename;

        /**
         * Download media file
         *
         * @var bool $success
         */
        $success = $this->media_repository->download(
            $media_url,
            $path
        );
        if (!$success) {
            return '';
        }

        /**
         * The url to the media file
         */
        $base_url = (string)plugin_dir_url(dirname(__FILE__));
        return $base_url . 'medias/' . $filename;
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
