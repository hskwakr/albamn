<?php

/**
 * The admin settings for the plugin.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The admin settings for the plugin.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Setting
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $albamn_hskwakr    The ID of this plugin.
     */
    private $albamn_hskwakr;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $albamn_hskwakr    The name of the plugin.
     * @param    string    $version           The version of this plugin.
     */
    public function __construct($albamn_hskwakr, $version)
    {
        $this->albamn_hskwakr = $albamn_hskwakr;
        $this->version = $version;
    }

    /**
     * Return a list of settings
     *
     * @since    1.0.0
     * @return   array    list of Albamn_Hskwakr_Admin_Setting_Option
     */
    public function get_options(): array
    {
        return array(
            $this->general(),
        );
    }

    /**
     * Return general setting option
     *
     * @since    1.0.0
     * @return   Albamn_Hskwakr_Admin_Setting_Option
     */
    public function general(): Albamn_Hskwakr_Admin_Setting_Option
    {
        return new Albamn_Hskwakr_Admin_Setting_Option(
            $this->albamn_hskwakr . '-general',
            array(
                'fb_api_token'
            )
        );
    }
}

/**
 * The admin settings for the plugin.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Setting_Option
{
    /**
     * A settings group name.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $name
     */
    public $name;

    /**
     * The list of names of an option to sanitize and save.
     *
     * @since    1.0.0
     * @access   public
     * @var      array    $group
     */
    public $group;

    public function __construct(
        string $name,
        array  $group
    ) {
        $this->name  = $name;
        $this->group = $group;
    }
}
