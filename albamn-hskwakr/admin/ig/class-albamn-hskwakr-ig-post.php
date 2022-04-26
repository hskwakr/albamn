<?php

/**
 * The Instagram post
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The Instagram post
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Post
{
    /**
     * The ID of the post.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $id
     */
    private $id;

    /**
     * The media type.
     * Should be IMAGE or VIDEO.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $media_type
     */
    private $media_type;

    /**
     * The media url.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $media_url
     */
    private $media_url;

    /**
     * The permalink for the post.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $permalink
     */
    private $permalink;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $albamn_hskwakr    The name of the plugin.
     */
    public function __construct(
        string $id,
        string $media_type,
        string $media_url,
        string $permalink
    ) {
        $this->id = $id;
        $this->media_type = $media_type;
        $this->media_url = $media_url;
        $this->permalink = $permalink;
    }
}
