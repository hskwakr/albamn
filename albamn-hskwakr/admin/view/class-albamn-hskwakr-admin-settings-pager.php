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
class Albamn_Hskwakr_Admin_Settings_Pager implements Albamn_Hskwakr_Admin_Displayable
{
    /**
     * The settings for the plugin
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Admin_Settings    $settings
     */
    private $settings;

    /**
     * The DB access for Instagram posts
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Post_Repository    $ig_repository
     */
    private $ig_repository;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Admin_Settings    $settings
     */
    public function __construct(
        Albamn_Hskwakr_Admin_Settings $settings,
        Albamn_Hskwakr_Ig_Post_Repository $ig_repository
    ) {
        $this->settings = $settings;
        $this->ig_repository = $ig_repository;
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
        echo $this->display_header();

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
        if ($this->ig_repository->remove_all()) {
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
    Albamn General Settings
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
