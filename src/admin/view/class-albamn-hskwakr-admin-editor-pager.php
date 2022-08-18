<?php

/**
 * The admin editor pager.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The admin editor pager.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Editor_Pager extends Albamn_Hskwakr_Admin_Pager
{
    /**
     * The DB access for Instagram posts
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Post_Repository    $ig_post_repository
     */
    private $ig_post_repository;

    /**
     * The formatter for Instagram medias
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Admin_Ig_Formatter    $ig_formatter
     */
    private $ig_formatter;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Admin_Settings            $settings
     * @param    Albamn_Hskwakr_Admin_Ig_Formatter        $ig_formatter
     */
    public function __construct(
        Albamn_Hskwakr_Ig_Post_Repository $ig_post_repository,
        Albamn_Hskwakr_Admin_Ig_Formatter $ig_formatter
    ) {
        $this->ig_post_repository = $ig_post_repository;
        $this->ig_formatter = $ig_formatter;
    }

    /**
     * Display settings page
     *
     * @since    1.0.0
     */
    public function display(): void
    {
        /********************
         * Prepare
         *******************/

        /**
         * Check POST data
         */
        $this->check_post_data();

        /**
         * Get all Instagram posts in DB
         */
        $ig_posts = $this->get_all_ig_posts();

        /********************
         * Display
         *******************/

        /**
         * Header
         */
        echo $this->display_header('Albamn Editor');

        /**
         * Check exsisting Instagram posts in DB
         */
        if (empty($ig_posts)) {
            /**
             * Couldn't to find any Instagram posts in DB
             */
            echo $this->display_alert_red('No data');
        } else {
            /**
             * Display Instagram posts
             */
            echo $this->format_ig_posts($ig_posts);
        }

        /**
         * Footer
         */
        echo $this->display_footer();
    }

    /**
     * Check http post data
     *
     * @since    1.0.0
     * @return   bool       Whether there is post data or not
     */
    public function check_post_data(): bool
    {
        if (!empty($_POST['delete_button'])) {
            /**
             * Get all instagram post IDs from HTTP POST
             *
             * @var array<string> $ig_post_ids
             */
            $ig_post_ids = $this->extract_ig_post_id($_POST);

            /**
             * Delete posts by ID
             */
            $this->delete_ig_posts($ig_post_ids);

            return true;
        }

        if (!empty($_POST['update_button'])) {
            /**
             * Get all instagram post ids from HTTP POST
             *
             * @var array<string> $ig_post_ids
             */
            $ig_post_ids = $this->extract_ig_post_id($_POST);

            /**
             * Change visibility of posts by ID
             */
            $this->change_ig_post_visibilities($ig_post_ids);

            return true;
        }

        return false;
    }

    /**
     * Extract Instagram post ID from given array
     *
     * @since    1.0.0
     * @return   array     The list of Instagram post IDs
     */
    public function extract_ig_post_id(array $args): array
    {
        $r = array();

        /**
         * @var mixed $value
         */
        foreach ($args as $key => $value) {
            if ($value == 'ig_post') {
                $r[] = (string)$key;
            }
        }

        /**
         * @var array<string>
         */
        return $r;
    }

    /**
     * Delete Instagram posts in DB
     * by the list of media ID
     *
     * @since    1.0.0
     * @param    array     $id_list
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function delete_ig_posts(
        array $id_list
    ): bool {
        /**
         * The result of success or failure
         *
         * @var bool $success
         */
        $success = true;

        /**
         * The ID should be string type
         */
        foreach ($id_list as $id) {
            if (!is_string($id)) {
                return false;
            }
        }

        /**
         * Delete the posts by ID
         *
         * @var array<string> $id_list
         */
        foreach ($id_list as $id) {
            $result = $this->remove_ig_post($id);
            if (!$result) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Change visibilities of the Instagram post in DB
     * by the list of media ID
     *
     * @since    1.0.0
     * @param    array     $id_list
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function change_ig_post_visibilities(
        array $id_list
    ): bool {
        /**
         * The result of success or failure
         *
         * @var bool $success
         */
        $success = true;

        /**
         * The ID should be string type
         */
        foreach ($id_list as $id) {
            if (!is_string($id)) {
                return false;
            }
        }

        /**
         * Change visibilities
         *
         * @var array<string> $id_list
         */
        foreach ($id_list as $id) {
            $result = $this->change_ig_post_visibility($id);
            if (!$result) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Change visibility of the Instagram post in DB
     * by the media ID
     *
     * @since    1.0.0
     * @param    string    $ig_post_id
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function change_ig_post_visibility(
        string $ig_post_id
    ): bool {
        /**
         * The target post to update
         *
         * @var Albamn_Hskwakr_Ig_Post | null
         */
        $target = $this->find_ig_post($ig_post_id);

        /**
         * Could not find target post in DB
         */
        if (empty($target)) {
            return false;
        }

        /**
         * Change visibility of the target
         */
        $target->visibility = !$target->visibility;

        /**
         * Update the target
         */
        return $this->update_ig_post(
            $ig_post_id,
            $target
        );
    }

    /**
     * Find Instagram post from DB
     *
     * @since    1.0.0
     * @param    string    $ig_psot_id
     * @return   Albamn_Hskwakr_Ig_Post | null      The post or null if could not find it
     */
    public function find_ig_post(
        string $ig_post_id
    ) {
        return $this->ig_post_repository->find_by($ig_post_id);
    }

    /**
     * Remove an Instagram post in DB
     *
     * @since    1.0.0
     * @param    string    $ig_psot_id
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function remove_ig_post(
        string $ig_post_id
    ): bool {
        return $this->ig_post_repository->remove($ig_post_id);
    }

    /**
     * Update Instagram post in DB
     *
     * @since    1.0.0
     * @param    string    $ig_psot_id
     * @param    Albamn_Hskwakr_Ig_Post     $new
     * @return   bool      Whether success or failure
     *                     true:  success
     *                     false: failure
     */
    public function update_ig_post(
        string $ig_post_id,
        Albamn_Hskwakr_Ig_Post $new
    ): bool {
        return $this->ig_post_repository->update(
            $ig_post_id,
            $new
        );
    }

    /**
     * Get all Instagram posts in DB
     *
     * @since    1.0.0
     * @return   array     The list of Instagram posts
     */
    public function get_all_ig_posts(): array
    {
        /**
         * Get all Instagram posts
         *
         * @var array<Albamn_Hskwakr_Ig_Post> $r
         */
        return $this->ig_post_repository->get(-1);
    }

    /**
     * Format Instagram posts
     *
     * @since    1.0.0
     * @param    array      $posts
     * @return   string     The html
     */
    public function format_ig_posts(array $posts): string
    {
        $error = 'Failed to display Instagram posts';
        if (!$this->ig_formatter->validate_medias($posts)) {
            $this->display_alert_red($error);
        }

        return $this->ig_formatter->format_medias_editor($posts);
    }
}
