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
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Admin_Settings    $albamn_hskwakr
     */
    public function __construct(
        Albamn_Hskwakr_Admin_Settings $settings
    ) {
        $this->settings = $settings;
    }

    /**
     * Display settings page
     */
    public function display(): void
    {
        /**
         * Header
         */
        $this->display_header();

        /**
         * Contents
         */
        $this->display_form_header();
        $this->display_options();
        $this->display_form_footer();

        /**
         * Footer
         */
        $this->display_footer();
    }

    /**
     * Display header
     */
    public function display_header(): void
    {
        echo <<< EOF

<div class="container-sm col-sm-8" style="margin: 1rem 0rem 0rem;">
  <h3 style="margin-bottom: 1rem;">
    Albamn General Settings
  </h3>

EOF;
    }

    /**
     * Display header for form
     */
    public function display_form_header(): void
    {
        echo <<< EOF

  <form method="POST" action="options.php">

EOF;
    }

    /**
     * Display footer for form
     */
    public function display_form_footer(): void
    {
        echo <<< EOF

    <button type="submit" class="btn btn-primary col-12">
      Save
    </button>
  </form>

EOF;
    }

    /**
     * Display footer
     */
    public function display_footer(): void
    {
        echo <<< EOF

</div>

EOF;
    }

    /**
     * Display a options
     *
     * The function contains Wordpress API
     */
    public function display_options(): void
    {
        $general = $this->settings->general();

        settings_fields($general->name);
        do_settings_sections($general->name);
        $group = $general->group;

        $this->display_input_text((string)$group[0], "Access token", "Your Facebook access token");
    }

    /**
     * Display a input tag with label
     *
     * The function contains Wordpress API
     *
     * @param   string    $name         the name of option.
     * @param   string    $label        the label to describe the option.
     * @param   string    $placeholder  the message when input is empty.
     */
    public function display_input_text(
        string $name,
        string $label,
        string $placeholder = ""
    ): void {
        $value = (string)get_option($name);

        echo <<< EOF

    <div class="row mb-3">
      <label class="col-sm-4 col-from-label" for="{$name}">{$label}</label>

      <div class="col-sm-8">
        <input type="text" class="form-control" id="{$name}" name="{$name}" value="{$value}" placeholder="{$placeholder}" />
      </div>
    </div>

EOF;
    }
}
