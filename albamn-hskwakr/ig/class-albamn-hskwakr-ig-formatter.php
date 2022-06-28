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
            if (!($m instanceof Albamn_Hskwakr_Ig_Post)) {
                return false;
            }

            /**
             * @var Albamn_Hskwakr_Ig_Post $m
             */
            if (!$m->validate()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Create html structure from instagram medias
     * for importer page
     *
     * This method don't care about error case
     *
     * @since    1.0.0
     * @param    array      $medias
     * @return   string     The html
     */
    public function format_medias_importer(array $medias): string
    {
        $r = '';
        $r = $r . '<div class="albamn-grid-wrapper">';
        $r = $r . '<div class="albamn-grid">';

        /**
         * @var Albamn_Hskwakr_Ig_Post $m
         */
        foreach ($medias as $m) {
            $r = $r . '<div class="albamn-grid-child">';

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
        }

        $r = $r . '</div>';
        $r = $r . '</div>';
        return $r;
    }

    /**
     * Create html structure from instagram medias
     * for editor page
     *
     * This method don't care about error case
     *
     * @since    1.0.0
     * @param    array      $medias
     * @return   string     The html
     */
    public function format_medias_editor(array $medias): string
    {
        $r = '';

        /**
         * Form
         */
        $r = $r . '<form method="POST" action="">';

        /**
         * Button
         */
        $r = $r . '<div class="albamn-row almamn-justify albamn-m">';

        $r = $r . '<button type="submit"';
        $r = $r . 'name="update_button" value="update"';
        $r = $r . 'class="albamn-btn albamn-btn-red albamn-col-5">';
        $r = $r . 'Show / Hide';
        $r = $r . '</button>';

        $r = $r . '<button type="submit"';
        $r = $r . 'name="delete_button" value="delete"';
        $r = $r . 'class="albamn-btn albamn-btn-red albamn-col-5">';
        $r = $r . 'Remove';
        $r = $r . '</button>';

        $r = $r . '</div>';

        /**
         * Grid
         */
        $r = $r . '<div class="albamn-grid-wrapper">';
        $r = $r . '<div class="albamn-grid">';

        /**
         * @var Albamn_Hskwakr_Ig_Post $m
         */
        foreach ($medias as $m) {
            $r = $r . '<div class="albamn-grid-child-editor">';

            switch ($m->media_type) {
                case 'IMAGE':
                    $r = $r . '<div class="albamn-editor-media-wrapper">';

                    $r = $r . $this->format_image_media($m);

                    $r = $r . '</div>';

                    $r = $r . '<div class="albamn-editor-media-footer">';

                    $r = $r . $this->display_checkbox(
                        $m->visibility ? 'Show' : 'Hide',
                        $m->id,
                        'ig_post'
                    );

                    $r = $r . '</div>';
                    break;

                case 'VIDEO':
                    $r = $r . '<div class="albamn-editor-media-wrapper">';

                    $r = $r . $this->format_video_media($m);

                    $r = $r . '</div>';

                    $r = $r . '<div class="albamn-editor-media-footer">';

                    $r = $r . $this->display_checkbox(
                        $m->visibility ? 'Show' : 'Hide',
                        $m->id,
                        'ig_post'
                    );

                    $r = $r . '</div>';
                    break;

                default:
                    break;
            }

            $r = $r . '</div>';
        }

        $r = $r . '</div>';
        $r = $r . '</div>';
        $r = $r . '</form>';
        return $r;
    }

    /**
     * Create html structure from instagram medias
     * for shortcode
     *
     * This method don't care about error case
     *
     * @since    1.0.0
     * @param    array      $medias
     * @return   string     The html
     */
    public function format_medias_shortcode(array $medias): string
    {
        $r = '';
        $r = $r . '<div class="albamn-grid-wrapper">';
        $r = $r . '<div class="albamn-grid">';

        /**
         * @var Albamn_Hskwakr_Ig_Post $m
         */
        foreach ($medias as $m) {
            /**
             * Check visibility
             */
            if (!$m->visibility) {
                continue;
            }

            $r = $r . '<div class="albamn-grid-child">';

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
        }

        $r = $r . '</div>';
        $r = $r . '</div>';
        return $r;
    }

    /**
     * Create html structure from image media
     *
     * This method don't care about error case
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Ig_Post      $media
     * @return   string     The html
     */
    public function format_image_media(
        Albamn_Hskwakr_Ig_Post $media
    ): string {
        $r = '';

        $linkable = !empty($media->permalink);

        if ($linkable) {
            $r = $r . '<a href="'
                    . $media->permalink
                    . '" '
                    . '>';
        }

        $r = $r . '<img src="'
                . $media->media_url
                . '" '
                . 'style="display: block; width: 100%; height: 100%;"'
                . '/>';

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
     * @param    Albamn_Hskwakr_Ig_Post      $media
     * @return   string     The html
     */
    public function format_video_media(
        Albamn_Hskwakr_Ig_Post $media
    ): string {
        $r = '';

        $linkable = !empty($media->permalink);

        if ($linkable) {
            $r = $r . '<a href="'
                    . $media->permalink
                    . '" '
                    . '>';
        }

        $r = $r . '<video src="'
                . $media->media_url
                . '" autoplay="" muted="" playsinline="" loop="" '
                . 'style="display: block; width: 100%; height: 100%;"'
                . '></video>';

        if ($linkable) {
            $r = $r . '</a>';
        }

        return $r;
    }

    /**
     * Create html structure for checkbox
     *
     * @since    1.0.0
     * @param    string     $label        the label of input.
     * @param    string     $name         the name of input.
     * @param    string     $value        the value of input.
     * @return   string     The html
     */
    public function display_checkbox(
        string $label,
        string $name,
        string $value
    ): string {
        return <<< EOF

        <input type="checkbox" id="{$name}" name="{$name}" value="{$value}">
        <label for="{$name}">
          $label
        </label>

EOF;
    }
}
