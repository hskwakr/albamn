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
class Albamn_Hskwakr_Ig_Post_Db_Provider
{
    /**
     * The custom post type
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Cpt_Arg    $cpt
     */
    private $cpt;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct(
        Albamn_Hskwakr_Cpt_Arg $cpt
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
         * The result of success or failure to add
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
         * The post ID on success.
         * The value 0 or WP_Error on failure.
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
            $this->set_post_meta($post_id, $post);

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
            /**
             * Initialize properties
             */
            if (!isset($post->ID)) {
                continue;
            }
            $post_id = (int)$post->ID;
            $post_title =
                isset($post->post_title) ?
                (string)$post->post_title : '';
            $post_type =
                isset($post->post_type) ?
                (string)$post->post_type : '';
            $post_status =
                isset($post->post_status) ?
                (string)$post->post_status : '';

            $media_id =
                isset($post->media_id) ?
                (string)$post->media_id : '';
            $media_type =
                isset($post->media_type) ?
                (string)$post->media_type : '';
            $media_type_list =
                isset($post->media_type_list) ?
                (array)$post->media_type_list : array();
            $media_url =
                isset($post->media_url) ?
                (string)$post->media_url : '';
            $media_url_list =
                isset($post->media_url_list) ?
                (array)$post->media_url_list : array();
            $media_permalink =
                isset($post->permalink) ?
                (string)$post->permalink : '';
            $media_visibility =
                isset($post->visibility) ?
                (bool)$post->visibility : false;

            /**
             * Create Entry
             */
            $r[] = new Albamn_Hskwakr_Ig_Post_Db_Entry(
                $post_id,
                $post_title,
                $post_type,
                $post_status,
                new Albamn_Hskwakr_Ig_Post(
                    $media_id,
                    $media_type,
                    $media_type_list,
                    $media_url,
                    $media_url_list,
                    $media_permalink,
                    $media_visibility
                )
            );
        }

        /**
         * @var array<Albamn_Hskwakr_Ig_Post_Db_Entry>
         */
        return $r;
    }

    /**
     * Remove an Instagram post in DB
     *
     * @since    1.0.0
     * @param    int       $id    The post id for DB
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function remove(
        int $id
    ): bool {
        /**
         * Remove the post from DB
         *
         * @var mixed $result
         */
        $result = wp_delete_post($id);

        /**
         * Failed to remove the post
         */
        if (empty($result)) {
            return false;
        }

        return true;
    }

    /**
     * Update Instagram post in DB
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Ig_Post_Db_Entry      $new
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function update(
        Albamn_Hskwakr_Ig_Post_Db_Entry $new
    ): bool {
        /**
         * The result of success or failure to update
         *
         * @var bool $success
         */
        $success = false;

        /**
         * Create the post data
         */
        $data = array(
            'ID' => $new->id,
            'post_title' => $new->title,
            'post_status' => $new->status,
            'post_type' => $new->type,
        );

        /**
         * Update the post in DB
         *
         * @var mixed $result
         */
        $result = wp_update_post($data);

        /**
         * Capture the post ID
         */
        if ($result && ! is_wp_error($result)) {
            /**
             * @var int $result
             */
            $post_id = $result;

            /**
             * Update meta data
             */
            $this->set_post_meta($post_id, $new->post);

            $success = true;
        }

        return $success;
    }

    /**
     * Set a post meta field based on the given post ID.
     *
     * https://developer.wordpress.org/reference/functions/update_post_meta/
     *
     * @since    1.0.0
     * @param    int    $id
     * @param    Albamn_Hskwakr_Ig_Post   $post
     */
    public function set_post_meta(
        int $id,
        Albamn_Hskwakr_Ig_Post $post
    ): void {
        update_post_meta(
            $id,
            'media_id',
            $post->id
        );

        update_post_meta(
            $id,
            'media_type',
            $post->media_type
        );

        update_post_meta(
            $id,
            'media_type_list',
            $post->media_type_list
        );

        update_post_meta(
            $id,
            'media_url',
            $post->media_url
        );

        update_post_meta(
            $id,
            'media_url_list',
            $post->media_url_list
        );

        update_post_meta(
            $id,
            'permalink',
            $post->permalink
        );

        update_post_meta(
            $id,
            'visibility',
            $post->visibility
        );
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
class Albamn_Hskwakr_Ig_Post_Db_Entry
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
