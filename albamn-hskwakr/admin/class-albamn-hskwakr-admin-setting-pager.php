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
     */
    public function display_options(): void
    {
        echo <<< EOF

      <div class="col-sm-4">
        <label>Facebook Graph API Access Token</label>
      </div>

      <div class="col-sm-4">
        <input type="text" class="form-control" />
      </div>

EOF;
    }
}
