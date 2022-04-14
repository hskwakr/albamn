<?php

/**
 * The formatter to display instagram medias.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The formatter to display instagram medias.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Ig_Formatter
{
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct(
    ) {
    }

    /**
     * Display importer page
     *
     * @since    1.0.0
     */
    public function display(): void
    {
    }

    /**
     * Validate the list of medias
     * The list should contains only image and video media
     *
     * @since    1.0.0
     * @param    array      $medias
     * @return   bool       true        The medias are expected.
     *                      false       The medias are unexpected.
     */
    public function validate_medias(array $medias): bool
    {
        foreach ($medias as $m) {
            if (!is_object($m)) {
                return false;
            }
            if (!isset($m->media_type)) {
                return false;
            }
            if (!isset($m->media_url)) {
                return false;
            }

            switch ($m->media_type) {
                case 'IMAGE':
                case 'VIDEO':
                    break;

                default:
                    return false;
            }
        }

        return true;
    }

    /**
     * Create html structure from instagram medias
     *
     * This method don't care about error case
     *
     * @since    1.0.0
     * @param    array      $posts
     * @return   string     The html
     */
    public function format_medias(array $medias): string
    {
        $r = '';
        foreach ($medias as $m) {
            switch ($m->media_type) {
                case 'IMAGE':
                    $r = $r . $this->format_image_media($m);
                    break;

                case 'VIDEO':
                    $r = $r . $this->format_video_media($m);
                    break;

                default:
                    break;
            }
        }

        return $r;
    }

    /**
     * Create html structure from image media
     *
     * This method don't care about error case
     *
     * @since    1.0.0
     * @param    object     $media
     * @return   string     The html
     */
    public function format_image_media($media): string
    {
        $r = '';
        $linkable =
            isset($media->permalink) && is_string($media->permalink);

        if ($linkable) {
            $r = $r . '<a href="' . $media->permalink . '">';
        }

        $r = $r . '<img src="' . (string)$media->media_url . '"/>';

        if ($linkable) {
            $r = $r . '</a>';
        }

        return $r;
    }

    /**
     * Create html structure from video media
     *
     * This method don't care about error case
     *
     * @since    1.0.0
     * @param    object     $media
     * @return   string     The html
     */
    public function format_video_media($media): string
    {
        $r = '';
        $linkable =
            isset($media->permalink) && is_string($media->permalink);

        if ($linkable) {
            $r = $r . '<a href="' . $media->permalink . '">';
        }

        $r = $r . '<video src="'
                . (string)$media->media_url
                . '" autoplay="" muted="" playsinline="" loop=""></video>';

        if ($linkable) {
            $r = $r . '</a>';
        }

        return $r;
    }
}
