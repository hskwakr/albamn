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
     * @access   public
     * @var      string    $id
     */
    public $id;

    /**
     * The media type.
     * Should be IMAGE or VIDEO.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $media_type
     */
    public $media_type;

    /**
     * The media url.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $media_url
     */
    public $media_url;

    /**
     * The permalink for the post.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $permalink
     */
    public $permalink;

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

    /**
     * Check the propaties in this post.
     *
     * @since    1.0.0
     * @return   bool       true        Expected.
     *                      false       Unexpected.
     */
    public function validate(): bool
    {
        if (empty($this->media_type)) {
            return false;
        }
        if (empty($this->media_url)) {
            return false;
        }
        if (empty($this->id)) {
            return false;
        }

        switch ($this->media_type) {
            case 'IMAGE':
            case 'VIDEO':
                break;

            default:
                return false;
        }

        return true;
    }
}
