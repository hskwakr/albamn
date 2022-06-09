<?php

/**
 * The context for Instagram API.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The context for Instagram API.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Shortcode
{
    /**
     * The formatter for Instagram medias
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Admin_Ig_Formatter    $formatter
     */
    private $formatter;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Admin_Ig_Formatter    $formatter
     */
    public function __construct(
        Albamn_Hskwakr_Admin_Ig_Formatter $formatter
    ) {
        $this->formatter = $formatter;
    }

    /**
     * Run the shortcode
     * to display list of Instagram posts
     *
     * @since    1.0.0
     * @return   string
     */
    public function run(): string
    {
        return '';
    }
}
