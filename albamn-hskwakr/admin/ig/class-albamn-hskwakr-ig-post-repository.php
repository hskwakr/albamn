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
        // wp_insert_post
        // add_post_meta

        return true;
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
        // get_posts
        // get_post_meta

        /**
         * @var array<Albamn_Hskwakr_Ig_Post>
         */
        return array();
    }

    /**
     * Find Instagram post from DB
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Ig_Post             $post
     * @return   Albamn_Hskwakr_Ig_Post | null      The post
     */
    public function find_by(
        Albamn_Hskwakr_Ig_Post $post
    ) {
        return null;
    }

    /**
     * Remove Instagram post in DB
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Ig_Post     $post
     * @return   bool      The result of success or failure
     *                     true:  success
     *                     false: failure
     */
    public function remove(
        Albamn_Hskwakr_Ig_Post $post
    ): bool {
        return true;
    }

    /**
     * Update Instagram post in DB
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Ig_Post     $target
     * @param    Albamn_Hskwakr_Ig_Post     $new
     * @return   bool      The result of success or failure
     *                     true:  success
     *                     false: failure
     */
    public function update(
        Albamn_Hskwakr_Ig_Post $target,
        Albamn_Hskwakr_Ig_Post $new
    ): bool {
        return true;
    }
}
