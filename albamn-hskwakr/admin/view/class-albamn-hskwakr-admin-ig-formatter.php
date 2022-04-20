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
    public function __construct()
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
        /**
         * @var mixed $m
         */
        foreach ($medias as $m) {
            if (!is_object($m)) {
                return false;
            }

            /**
             * @var object $m
             */
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
     * @param    array      $medias
     * @return   string     The html
     */
    public function format_medias(array $medias): string
    {
        $count = 0;
        $row = 4;
        $margin = 2;

        $r = '';
        $r = $r . '<div class="m-' . $margin . '">';

        /**
         * @var object $m
         */
        foreach ($medias as $m) {
            if ($count % $row == 0) {
                $r = $r . '<div class="row">';
            }

            $r = $r . '<div '
              . 'class="col p-1" '
              . 'style="width: 15rem; height: 16rem;'
              . '">';

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

            $r = $r . '</div>';

            if ($count % $row == $row - 1) {
                $r = $r . '</div>';
            }

            $count++;
        }

        $r = $r . '</div>';
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
        $r = $r . '<div '
                . 'class="m-auto" '
                . 'style="width: 15rem; height: 15rem; background: black;"'
                . '>';

        $linkable =
            isset($media->permalink);

        if ($linkable) {
            $r = $r . '<a href="'
                    . (string)$media->permalink
                    . '" '
                    . '>';
        }

        $r = $r . '<img src="'
                . (string)$media->media_url
                . '" '
                . 'style="display: block; width: 100%; height: 100%;"'
                . '/>';

        if ($linkable) {
            $r = $r . '</a>';
        }

        $r = $r . '</div>';
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
        $r = $r . '<div '
                . 'class="m-auto" '
                . 'style="width: 15rem; height: 15rem; background: black;"'
                . '>';

        $linkable =
            isset($media->permalink);

        if ($linkable) {
            $r = $r . '<a href="'
                    . (string)$media->permalink
                    . '" '
                    . '>';
        }

        $r = $r . '<video src="'
                . (string)$media->media_url
                . '" autoplay="" muted="" playsinline="" loop="" '
                . 'style="display: block; width: 100%; height: 100%;"'
                . '></video>';

        if ($linkable) {
            $r = $r . '</a>';
        }

        $r = $r . '</div>';
        return $r;
    }
}