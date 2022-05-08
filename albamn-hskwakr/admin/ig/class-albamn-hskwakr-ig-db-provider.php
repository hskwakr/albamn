<?php

/**
 * The DB access for Instagram posts
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The DB access for Instagram posts
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Db_Provider
{
    /**
     * The custom post type
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Admin_Cpt_Arg    $cpt
     */
    private $cpt;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct(
        Albamn_Hskwakr_Admin_Cpt_Arg $cpt
    ) {
        $this->cpt = $cpt;
    }

    /**
     * Add Instagram post to DB
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Ig_Post     $post
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function add(
        Albamn_Hskwakr_Ig_Post $post
    ) {
        /**
         * The result of success or failure to remove
         *
         * @var bool $success
         */
        $success = false;

        /**
         * The custom post type name for Instagram post
         *
         * @var string $name
         */
        $name = $this->cpt->labels->name;

        /**
         * Create the post data
         */
        $data = array(
            'post_title' => $post->id,
            'post_status' => 'publish',
            'post_type' => $name
        );

        /**
         * Add the post into DB
         *
         * @var mixed $result
         */
        $result = wp_insert_post($data);

        /**
         * Capture the post ID
         */
        if ($result && ! is_wp_error($result)) {
            /**
             * @var int $result
             */
            $post_id = $result;

            /**
             * Add meta data
             */
            add_post_meta(
                $post_id,
                'media_id',
                $post->id
            );
            add_post_meta(
                $post_id,
                'media_type',
                $post->media_type
            );
            add_post_meta(
                $post_id,
                'media_url',
                $post->media_url
            );
            add_post_meta(
                $post_id,
                'permalink',
                $post->permalink
            );

            $success = true;
        }

        return $success;
    }

    /**
     * Get Instagram post from DB
     *
     * @since    1.0.0
     * @param    int       $amount     The amount of posts. -1 means all posts.
     * @return   array     The list of the DB entries for the Instagram post
     */
    public function get(
        int $amount
    ): array {
        $r = array();
        $name = $this->cpt->labels->name;

        /**
         * Get posts from DB
         *
         * @var array<object> $posts
         */
        $posts = get_posts(array(
            'post_type' => $name,
            'numberposts' => $amount,
        ));

        /**
         * @var object $post
         */
        foreach ($posts as $post) {
            $r[] = new Albamn_Hskwakr_Ig_Db_Post(
                (int)$post->ID,
                (string)$post->post_title,
                (string)$post->post_type,
                (string)$post->post_status,
                new Albamn_Hskwakr_Ig_Post(
                    (string)$post->media_id,
                    (string)$post->media_type,
                    (string)$post->media_url,
                    (string)$post->permalink
                )
            );
        }

        /**
         * @var array<Albamn_Hskwakr_Ig_Db_Post>
         */
        return $r;
    }

    /**
     * Remove an Instagram post in DB
     *
     * @since    1.0.0
     * @param    string    $media_id
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function remove(
        string $media_id
    ): bool {
        /**
         * The post to remove from DB
         *
         * @var Albamn_Hskwakr_Ig_Db_Post | null $target
         */
        $target = null;

        /**
         * Get all posts from DB
         *
         * @var array<Albamn_Hskwakr_Ig_Db_Post> $entries
         */
        $entries = $this->get(-1);

        /**
         * Find the post from DB
         *
         * @var Albamn_Hskwakr_Ig_Db_Post $entry
         */
        foreach ($entries as $entry) {
            if ($entry->post->id == $media_id) {
                $target = $entry;
            }
        }

        /**
         * Failed to find the post
         */
        if ($target == null) {
            return false;
        }

        /**
         * Remove the post from DB
         *
         * @var mixed $result
         */
        $result = wp_delete_post($target->id);

        /**
         * Failed to remove the post
         */
        if (empty($result)) {
            return false;
        }

        return true;
    }

    /**
     * Remove all Instagram post in DB
     *
     * @since    1.0.0
     * @return   bool      The result of success or failure
     *                     true:  success
     *                     false: failure
     */
    public function remove_all(
    ): bool {
        /**
         * The result of success or failure to remove
         *
         * @var bool $success
         */
        $success = true;

        /**
         * Get all posts from DB
         *
         * @var array<Albamn_Hskwakr_Ig_Db_Post> $entries
         */
        $entries = $this->get(-1);

        /**
         * Remove all posts from DB
         *
         * @var Albamn_Hskwakr_Ig_Db_Post $entry
         */
        foreach ($entries as $entry) {
            /**
             * Remove the post from DB
             *
             * @var mixed $result
             */
            $result = wp_delete_post($entry->id);

            /**
             * Failed to remove the post
             */
            if (empty($result)) {
                $success  = false;
            }
        }

        return $success;
    }
}

/**
 * The post object in DB
 *
 * https://developer.wordpress.org/reference/classes/wp_post/
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Db_Post
{
    /**
     * The DB entry ID of the Instagram post
     *
     * @since    1.0.0
     * @access   public
     * @var      int    $id
     */
    public $id;

    /**
     * The post title
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $title
     */
    public $title;

    /**
     * The post type
     *
     * https://wordpress.org/support/article/post-types/
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $type
     */
    public $type;

    /**
     * The post status
     *
     * https://wordpress.org/support/article/post-status/
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $status
     */
    public $status;

    /**
     * The Instagram post
     *
     * @since    1.0.0
     * @access   public
     * @var      Albamn_Hskwakr_Ig_Post    $post
     */
    public $post;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct(
        int $id,
        string $title,
        string $type,
        string $status,
        Albamn_Hskwakr_Ig_Post $post
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->status = $status;
        $this->post = $post;
    }
}
