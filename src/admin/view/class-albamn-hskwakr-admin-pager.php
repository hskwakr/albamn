<?php

/**
 * The admin abstract pager.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The admin abstract pager.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
abstract class Albamn_Hskwakr_Admin_Pager
{
    /**
     * Display page
     */
    abstract public function display(): void;

    /**
     * The html to display header
     *
     * @since    1.0.0
     * @param    string     $msg          the message.
     * @return   string     The html
     */
    protected function display_header(
        $msg
    ): string {
        return <<< EOF

<div class="albamn-container albamn-mt">
  <h3 class="albamn-mb-3">
    $msg
  </h3>

EOF;
    }

    /**
     * The html to display footer
     *
     * @since    1.0.0
     * @return   string     The html
     */
    protected function display_footer(): string
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
    protected function display_options_form_header(): string
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
    protected function display_self_form_header(): string
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
    protected function display_form_footer(): string
    {
        return <<< EOF

  </form>

EOF;
    }

    /**
     * The html to display a input tag with label
     *
     * @since    1.0.0
     * @param    string     $name         the name of option.
     * @param    string     $label        the label to describe option.
     * @param    string     $placeholder  the message when input is empty.
     * @return   string     The html
     */
    protected function display_input_text(
        string $name,
        string $value,
        string $label,
        string $placeholder = ""
    ): string {
        return <<< EOF

    <div class="albamn-input albamn-mb-2">
      <label class="albamn-input-label" for="{$name}">{$label}</label>

      <div class="albamn-input-text">
        <input type="text" id="{$name}" name="{$name}" value="{$value}" placeholder="{$placeholder}" />
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
    protected function display_input_hidden(
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
    protected function display_form_button(
        string $label
    ): string {
        return <<< EOF

    <button type="submit" class="albamn-btn albamn-btn-blue albamn-mb-2">
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
    protected function display_alert_red(
        $msg
    ): string {
        return <<< EOF

  <div class="albamn-alert albamn-alert-yellow albamn-mt" role="alert">
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
    protected function display_alert_green(
        $msg
    ): string {
        return <<< EOF

  <div class="albamn-alert albamn-alert-green albamn-mt albamn-mb-2" role="alert">
    $msg
  </div>

EOF;
    }
}
