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
class Albamn_Hskwakr_Admin_Editor_Pager implements Albamn_Hskwakr_Admin_Displayable
{
    /**
     * The DB access for Instagram posts
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Post_Repository    $ig_repository
     */
    private $ig_repository;

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
        Albamn_Hskwakr_Ig_Post_Repository $ig_repository,
        Albamn_Hskwakr_Admin_Ig_Formatter $ig_formatter
    ) {
        $this->ig_repository = $ig_repository;
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
        echo $this->display_header();

        /**
         * Check exsisting Instagram posts in DB
         */
        if (empty($ig_posts)) {
            /**
             * Couldn't to find any Instagram posts in DB
             */
            echo 'There is nothing';
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
        return $this->ig_repository->find_by($ig_post_id);
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
        return $this->ig_repository->remove($ig_post_id);
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
        return $this->ig_repository->update(
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
        return $this->ig_repository->get(-1);
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

    /**
     * The html to display header
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_header(): string
    {
        return <<< EOF

<div class="container-sm col-sm-8" style="margin: 1rem 0rem 0rem;">
  <h3 style="margin-bottom: 1rem;">
    Albamn Editor 
  </h3>

EOF;
    }

    /**
     * The html to display footer for form
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_footer(): string
    {
        return <<< EOF

</div>

EOF;
    }

    /**
     * The html to display header for form to the options.php
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_options_form_header(): string
    {
        return <<< EOF

  <form method="POST" action="options.php">

EOF;
    }

    /**
     * The html to display header for form to this page
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_self_form_header(): string
    {
        return <<< EOF

  <form method="POST" action="">

EOF;
    }

    /**
     * The html to display footer for form
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_form_footer(): string
    {
        return <<< EOF

  </form>

EOF;
    }

    /**
     * The html to display a input tag with label
     *
     * @since    1.0.0
     * @param   string    $name         the name of option.
     * @param   string    $label        the label to describe the option.
     * @param   string    $placeholder  the message when input is empty.
     * @return   string     The html
     */
    public function display_input_text(
        string $name,
        string $value,
        string $label,
        string $placeholder = ""
    ): string {
        return <<< EOF

    <div class="row mb-3">
      <label class="col-sm-4 col-from-label" for="{$name}">{$label}</label>

      <div class="col-sm-8">
        <input type="text" class="form-control" id="{$name}" name="{$name}" value="{$value}" placeholder="{$placeholder}" />
      </div>
    </div>

EOF;
    }

    /**
     * The html to display a input tag with label
     *
     * @since    1.0.0
     * @param    string    $name         the name of input.
     * @param    string    $value        the value of input
     * @return   string    The html
     */
    public function display_input_hidden(
        string $name,
        string $value
    ): string {
        return <<< EOF

        <input type="hidden" name="{$name}" value="{$value}">

EOF;
    }

    /**
     * The html to display submit button for form
     *
     * @since    1.0.0
     * @param    string     $label        the label for button.
     * @return   string     The html
     */
    public function display_form_button(
        string $label
    ): string {
        return <<< EOF

    <button type="submit" class="btn btn-primary col-12 mb-2">
      $label
    </button>

EOF;
    }

    /**
     * The html to display message
     * with red background
     *
     * @since    1.0.0
     * @param    string    $msg          the message.
     * @return   string    The html
     */
    public function display_alert_red($msg): string
    {
        return <<< EOF

  <div class="alert alert-warning mt-2" role="alert">
    $msg
  </div>

EOF;
    }

    /**
     * The html to display message
     * with green background
     *
     * @since    1.0.0
     * @param    string    $msg          the message.
     * @return   string    The html
     */
    public function display_alert_green($msg): string
    {
        return <<< EOF

  <div class="alert alert-success mt-2" role="alert">
    $msg
  </div>

EOF;
    }
}
