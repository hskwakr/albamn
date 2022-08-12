<?php

/**
 * The admin settings pager.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The admin settings pager.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Settings_Pager extends Albamn_Hskwakr_Admin_Pager
{
    /**
     * The settings for the plugin
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Settings    $settings
     */
    private $settings;

    /**
     * The DB access for Instagram posts
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Post_Repository    $ig_post_repository
     */
    private $ig_post_repository;

    /**
     * The access for Instagram media files
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Media_Repository    $ig_media_repository
     */
    private $ig_media_repository;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Settings    $settings
     */
    public function __construct(
        Albamn_Hskwakr_Settings $settings,
        Albamn_Hskwakr_Ig_Post_Repository $ig_post_repository,
        Albamn_Hskwakr_Ig_Media_Repository $ig_media_repository
    ) {
        $this->settings = $settings;
        $this->ig_post_repository = $ig_post_repository;
        $this->ig_media_repository = $ig_media_repository;
    }

    /**
     * Display settings page
     *
     * @since    1.0.0
     */
    public function display(): void
    {
        /**
         * Prepare to display
         */
        $status = $this->check_post_data();

        /**
         * Header
         */
        echo $this->display_header('Albamn General Settings');

        /**
         * Contents
         */
        echo $this->display_options_form_header();
        echo $this->display_form_1_options();
        echo $this->display_form_footer();

        echo $this->display_self_form_header();
        echo $this->display_form_2_options();
        echo $this->display_form_footer();

        if ($status == 1) {
            /**
             * Remove all posts
             */
            echo $this->remove_all_ig_posts();
        }

        /**
         * Footer
         */
        echo $this->display_footer();
    }

    /**
     * Check post data
     *
     * @since    1.0.0
     * @return   int        The status
     *                      0 : There is no post data sent
     *                      1 : 'Remove all posts' button sent
     */
    public function check_post_data(): int
    {
        /**
         * Check POST data from this page
         */
        if (!empty($_POST['remove'])) {
            return 1;
        }

        return 0;
    }

    /**
     * Remove all Instagram posts from DB
     *
     * @since    1.0.0
     * @return   string      The html
     */
    public function remove_all_ig_posts(): string
    {
        if ($this->ig_post_repository->remove_all()) {
            return $this->display_alert_green(
                'Successed to remove all posts'
            );
        } else {
            return $this->display_alert_red(
                'Failed to remove all posts'
            );
        }
    }

    /**
     * Display a options
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_form_1_options(): string
    {
        /**
         * Get the setting names
         */
        $general = $this->settings->general();

        /**
         * Get the setting values of the option from DB
         */
        $token = (string)$this->settings->get_option(
            (string)$general->options[0],
            '',
            $general->name
        );

        $r = '';

        /**
         * Set input text
         */
        $r = $r . $this->display_input_text(
            (string)$general->options[0],
            $token,
            "Access token",
            "Your Facebook access token"
        );

        /**
         * Set button text
         */
        $r = $r . $this->display_form_button(
            'Save'
        );

        return $r;
    }

    /**
     * Display a options
     *
     * @since    1.0.0
     * @return   string     The html
     */
    public function display_form_2_options(): string
    {
        $r = '';

        /**
         * Set input hidden
         */
        $r = $r . $this->display_input_hidden(
            'remove',
            'remove'
        );

        /**
         * Set submit button
         */
        $r = $r . $this->display_form_button(
            'Remove all posts'
        );

        return $r;
    }
}
