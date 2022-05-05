<?php

/**
 * The permanent data access for instagram posts
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The permanent data access for instagram posts
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Post_Repository
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
     * @return   bool      The result of success or failure
     *                     true:  success
     *                     false: failure
     */
    public function add(
        Albamn_Hskwakr_Ig_Post $post
    ): bool {
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
     * @return   array     The list of Instagram posts
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
            $r[] = new Albamn_Hskwakr_Ig_Post(
                (string)$post->media_id,
                (string)$post->media_type,
                (string)$post->media_url,
                (string)$post->permalink
            );
        }

        /**
         * @var array<Albamn_Hskwakr_Ig_Post>
         */
        return $r;
    }

    /**
     * Find Instagram post from DB
     *
     * @since    1.0.0
     * @param    string    $media_id
     * @return   Albamn_Hskwakr_Ig_Post | null      The post or null if could not find it
     */
    public function find_by(
        string $media_id
    ) {
        /**
         * Get all posts
         */
        $posts = $this->get(-1);

        /**
         * Check all elements type in posts
         *
         * @var mixed $post
         */
        foreach ($posts as $post) {
            if (!($post instanceof Albamn_Hskwakr_Ig_Post)) {
                return null;
            }
        }

        /**
         * Find the post in posts
         *
         * @var Albamn_Hskwakr_Ig_Post $post
         */
        foreach ($posts as $post) {
            if ($post->id == $media_id) {
                return $post;
            }
        }

        return null;
    }

    /**
     * Remove an Instagram post in DB
     *
     * @since    1.0.0
     * @param    string    $media_id
     * @return   bool      The result of success or failure
     *                     true:  success
     *                     false: failure
     */
    public function remove(
        string $media_id
    ): bool {
        /**
         * The post to remove from DB
         *
         * @var object | null $target
         */
        $target = null;

        /**
         * The custom post type name for Instagram post
         *
         * @var string $name
         */
        $name = $this->cpt->labels->name;

        /**
         * Get all posts from DB
         *
         * @var array<object> $posts
         */
        $posts = get_posts(array(
            'post_type' => $name,
            'numberposts' => -1,
        ));

        /**
         * Find the post from DB
         *
         * @var object $post
         */
        foreach ($posts as $post) {
            /**
             * @var string $post->media_id
             */
            if ($post->media_id == $media_id) {
                $target = $post;
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
        $result = wp_delete_post($target->ID);

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
         * The custom post type name for Instagram post
         *
         * @var string $name
         */
        $name = $this->cpt->labels->name;

        /**
         * Get all posts from DB
         *
         * @var array<object> $posts
         */
        $posts = get_posts(array(
            'post_type' => $name,
            'numberposts' => -1,
        ));

        /**
         * Remove all posts from DB
         *
         * @var object $post
         */
        foreach ($posts as $post) {
            /**
             * Remove the post from DB
             *
             * @var mixed $result
             */
            $result = wp_delete_post($post->ID);

            /**
             * Failed to remove the post
             */
            if (empty($result)) {
                $success  = false;
            }
        }

        return $success;
    }

    /**
     * Update Instagram post in DB
     *
     * @since    1.0.0
     * @param    string    $media_id
     * @param    Albamn_Hskwakr_Ig_Post     $new
     * @return   bool      The result of success or failure
     *                     true:  success
     *                     false: failure
     */
    public function update(
        string $media_id,
        Albamn_Hskwakr_Ig_Post $new
    ): bool {
        return true;
    }
}
