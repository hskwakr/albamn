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
     * @var      Albamn_Hskwakr_Ig_Api_Context    $ctx
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
     * @var      array    $recent_medias
     */
    public $recent_medias = array();

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string                     $token
     */
    public function __construct(string $token)
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
     * This function is for test mostly.
     * This function should be called before calling any methods.
     *
     * @param     Albamn_Hskwakr_Ig_Api_Context    $ctx
     * @return    object    The instance of this class
     */
    public function set_context(
        Albamn_Hskwakr_Ig_Api_Context $ctx
    ): object {
        $this->ctx = $ctx;
        return $this;
    }

    /**
     * Init facebook graph api.
     *
     * @return    object    The instance of this class
     */
    public function init(): object
    {
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

        return $this;
    }

    /**
     * Search recent medias by a name of hashtag in instagram.
     * And store the result of medias in array.
     *
     * @param     string    $name
     * @return    object    The instance of this class
     */
    public function search_hashtag(string $name): object
    {
        /**
         * the method should be called after init
         */
        if (empty($this->pages_id) || empty($this->user_id)) {
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
            $this->recent_medias =
                $this->ctx->medias_recent(
                    $this->user_id,
                    $this->hashtag_id
                );
        } catch (Exception $e) {
            $this->error('Failed to search hashtag', $e);
        }

        return $this;
    }

    /**
     * Error handling
     * Throw exception with error message
     *
     * @param     string      $msg
     * @param     Throwable   $e
     */
    private function error(
        string $msg,
        Throwable $e
    ): void {
        throw new Exception(
            $msg . ': ' . $e->getMessage(),
            0,
            $e->getPrevious()
        );
    }
}
