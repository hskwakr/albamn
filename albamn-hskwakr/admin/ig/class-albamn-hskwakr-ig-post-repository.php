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
        $flag = false;
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

            $flag = true;
        }

        return $flag;
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
     * @return   Albamn_Hskwakr_Ig_Post | null      The post
     */
    public function find_by(
        string $media_id
    ) {
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
        // wp_delete_post
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
        $result = true;

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
                return false;
            }
        }

        /**
         * Remove all posts
         *
         * @var Albamn_Hskwakr_Ig_Post $post
         */
        foreach ($posts as $post) {
            if (!$this->remove($post->id)) {
                $result = false;
            }
        }

        return $result;
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
