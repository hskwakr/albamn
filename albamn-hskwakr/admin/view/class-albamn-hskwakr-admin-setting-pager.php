<?php

/**
 * The admin setting pager.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The admin setting pager.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Setting_Pager implements Albamn_Hskwakr_Admin_Displayable
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
    public function __construct(Albamn_Hskwakr_Admin_Settings $settings)
    {
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
        $this->display_options();

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

<div class="container-sm" style="margin: 1rem 0rem 0rem;">
  <h2 style="margin-bottom: 1rem;">
    Albamn General Settings
  </h2>

  <form method="POST" action="options.php">
    <div class="row">

EOF;
    }

    /**
     * Display footer
     */
    public function display_footer(): void
    {
        echo <<< EOF

    </div>

    <div style="margin-top: 1rem;">
      <button type="submit" class="btn btn-primary btn-sm">
        Save
      </button>
    </div>
  </form>
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

        $this->display_input((string)$group[0], "Facebook Graph API Access Token", "Your Facebook Access Token");
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
    public function display_input(
        string $name,
        string $label,
        string $placeholder = ""
    ): void {
        $value = (string)get_option($name);

        echo <<< EOF

      <div class="col-sm-4">
        <label for="{$name}">{$label}</label>
      </div>

      <div class="col-sm-4">
        <input type="text" class="form-control" id="{$name}" name="{$name}" value="{$value}" placeholder="{$placeholder}" />
      </div>

EOF;
    }
}
