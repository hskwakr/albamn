<?php

/**
 * The admin-specific enqueues for css/js of the plugin.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The admin-specific enqueues for css/js of the plugin.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Enqueue
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
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     * @return   array     a list of class Albamn_Hskwakr_Admin_Enqueue_Style.
     */
    public function styles(): array
    {
        return array(
            new Albamn_Hskwakr_Admin_Enqueue_Style(
                $this->albamn_hskwakr,
                plugin_dir_url(__FILE__) . 'css/albamn-hskwakr-admin.css',
                array(),
                $this->version,
                'all'
            ),
            // bootstrap
            new Albamn_Hskwakr_Admin_Enqueue_Style(
                $this->albamn_hskwakr . '-bootstrap-css',
                plugin_dir_url(__FILE__) . 'css/bootstrap.min.css',
                array(),
                $this->version,
                'all'
            ),
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     * @return   array     a list of class Albamn_Hskwakr_Admin_Enqueue_Script.
     */
    public function scripts(): array
    {
        return array(
            new Albamn_Hskwakr_Admin_Enqueue_Script(
                $this->albamn_hskwakr,
                plugin_dir_url(__FILE__) . 'js/albamn-hskwakr-admin.js',
                array('jquery'),
                $this->version,
                false
            ),
            // bootstrap
            new Albamn_Hskwakr_Admin_Enqueue_Script(
                $this->albamn_hskwakr . '-bootstrap-js',
                plugin_dir_url(__FILE__) . 'js/bootstrap.min.js',
                array('jquery'),
                $this->version,
                false
            ),
        );
    }
}

/**
 * The style enqueue.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Enqueue_Style
{
    /**
     * Name of the stylesheet. Should be unique.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $handle
     */
    public $handle;

    /**
     * Full URL of the stylesheet, or path of the stylesheet
     * relative to the WordPress root directory.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $src
     */
    public $src;

    /**
     * An array of registered stylesheet
     * handles this stylesheet depends on.
     *
     * @since    1.0.0
     * @access   public
     * @var      array    $deps
     */
    public $deps;

    /**
     * String specifying stylesheet version number.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $ver
     */
    public $ver;

    /**
     * The media for which this stylesheet has been defined.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $media
     */
    public $media;

    public function __construct(
        string $handle,
        string $src,
        array  $deps,
        string $ver,
        string $media
    ) {
        $this->handle = $handle;
        $this->src    = $src;
        $this->deps   = $deps;
        $this->ver    = $ver;
        $this->media  = $media;
    }
}

/**
 * The script enqueue.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Enqueue_Script
{
    /**
     * Name of the stylesheet. Should be unique.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $handle
     */
    public $handle;

    /**
     * Full URL of the stylesheet, or path of the stylesheet
     * relative to the WordPress root directory.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $src
     */
    public $src;

    /**
     * An array of registered stylesheet
     * handles this stylesheet depends on.
     *
     * @since    1.0.0
     * @access   public
     * @var      array    $deps
     */
    public $deps;

    /**
     * String specifying stylesheet version number.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $ver
     */
    public $ver;

    /**
     * Whether to enqueue the script
     * before </body> instead of in the <head>.
     *
     * @since    1.0.0
     * @access   public
     * @var      bool    $footer
     */
    public $footer;

    public function __construct(
        string $handle,
        string $src,
        array  $deps,
        string $ver,
        bool   $footer
    ) {
        $this->handle = $handle;
        $this->src    = $src;
        $this->deps   = $deps;
        $this->ver    = $ver;
        $this->footer = $footer;
    }
}
