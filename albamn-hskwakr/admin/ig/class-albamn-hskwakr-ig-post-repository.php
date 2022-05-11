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
     * The DB service for the Instagram posts
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Post_Db_Provider    $db
     */
    private $db;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct(
        Albamn_Hskwakr_Ig_Post_Db_Provider $db
    ) {
        $this->db = $db;
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
    ): bool {
        return $this->db->add($post);
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
        /**
         * The list of the Instagram posts
         *
         * @var array<Albamn_Hskwakr_Ig_Post> $r
         */
        $r = array();

        /**
         * Get posts from DB
         *
         * @var array<Albamn_Hskwakr_Ig_Post_Db_Entry> $entries
         */
        $entries = $this->db->get($amount);

        /**
         * @var Albamn_Hskwakr_Ig_Post_Db_Entry $entry
         */
        foreach ($entries as $entry) {
            $r[] = new Albamn_Hskwakr_Ig_Post(
                $entry->post->id,
                $entry->post->media_type,
                $entry->post->media_url,
                $entry->post->permalink
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
         * @var Albamn_Hskwakr_Ig_Post_Db_Entry | null $target
         */
        $target = null;

        /**
         * Get all posts from DB
         *
         * @var array<Albamn_Hskwakr_Ig_Post_Db_Entry> $entries
         */
        $entries = $this->db->get(-1);

        /**
         * Could not find any entries
         */
        if (empty($entries)) {
            return false;
        }

        /**
         * Find the post from DB
         *
         * @var Albamn_Hskwakr_Ig_Post_Db_Entry $entry
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
        $result = $this->db->remove($target->id);

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
     * @return   bool      Whether success or failure
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
         * @var array<Albamn_Hskwakr_Ig_Post_Db_Entry> $entries
         */
        $entries = $this->db->get(-1);

        /**
         * Could not find any entries
         */
        if (empty($entries)) {
            return false;
        }

        /**
         * Remove all posts from DB
         *
         * @var Albamn_Hskwakr_Ig_Post_Db_Entry $entry
         */
        foreach ($entries as $entry) {
            /**
             * Remove the post from DB
             *
             * @var mixed $result
             */
            $result = $this->db->remove($entry->id);

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
     * @return   bool      Whether success or failure
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
