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
     * Should be IMAGE or VIDEO or CAROUSEL_ALBUM.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $media_type
     */
    public $media_type;

    /**
     * The list of media types for CAROUSEL_ALBUM.
     *
     * @since    1.0.0
     * @access   public
     * @var      array    $media_type_list
     */
    public $media_type_list;

    /**
     * The media url.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $media_url
     */
    public $media_url;

    /**
     * The list of media urls for CAROUSEL_ALBUM.
     *
     * @since    1.0.0
     * @access   public
     * @var      array    $media_url_list
     */
    public $media_url_list;

    /**
     * The permalink for the post.
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $permalink
     */
    public $permalink;

    /**
     * The visibility for the post.
     * true: show
     * false: hide
     *
     * @since    1.0.0
     * @access   public
     * @var      bool    $visibility
     */
    public $visibility;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct(
        string $id,
        string $media_type,
        array  $media_type_list,
        string $media_url,
        array  $media_url_list,
        string $permalink,
        bool   $visibility
    ) {
        $this->id = $id;
        $this->media_type = $media_type;
        $this->media_type_list = $media_type_list;
        $this->media_url = $media_url;
        $this->media_url_list = $media_url_list;
        $this->permalink = $permalink;
        $this->visibility = $visibility;
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
        if (empty($this->id)) {
            return false;
        }

        switch ($this->media_type) {
            case 'IMAGE':
            case 'VIDEO':
                if (empty($this->media_url)) {
                    return false;
                }
                break;

            case 'CAROUSEL_ALBUM':
                if (empty($this->media_url_list)) {
                    return false;
                }
                break;

            default:
                return false;
        }

        return true;
    }
}
