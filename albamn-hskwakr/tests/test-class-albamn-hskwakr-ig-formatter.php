<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Ig_Formatter
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Ig_Formatter
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Ig_Formatter_Test extends WP_UnitTestCase
{
    private $formatter;
    private $medias_correct;
    private $medias_wrong;

    public function setUp()
    {
        /**
         * Prepare fake data
         * Correct values
         */
        $correct_image = new Albamn_Hskwakr_Ig_Post(
            'id1234',
            'IMAGE',
            'mediaurl1234',
            array(),
            'permalink1234',
            true
        );

        $correct_video = new Albamn_Hskwakr_Ig_Post(
            'id1234',
            'VIDEO',
            'mediaurl1234',
            array(),
            'permalink1234',
            true
        );

        $correct_album = new Albamn_Hskwakr_Ig_Post(
            'id1234',
            'CAROUSEL_ALBUM',
            '',
            array('list1234'),
            'permalink1234',
            true
        );

        $this->medias_correct = array(
            'image' => $correct_image,
            'video' => $correct_video,
            'album' => $correct_album
        );

        /**
         * Prepare fake data
         * Wrong values
         */
        $wrong_array_elem_string = '';

        $wrong_array_elem_object = new class () {};
        $wrong_array_elem_object->media_type = 'IMAGE';
        $wrong_array_elem_object->media_url = 'url1234';
        $wrong_array_elem_object->permalink = 'link1234';
        $wrong_array_elem_object->id = 'id1234';

        $wrong_type = new Albamn_Hskwakr_Ig_Post(
            'id1234',
            'OTHER',
            'mediaurl1234',
            array(),
            'permalink1234',
            true
        );

        $wrong_prop_1 = new Albamn_Hskwakr_Ig_Post(
            'id1234',
            '',
            'mediaurl1234',
            array(),
            'permalink1234',
            true
        );

        $wrong_prop_2 = new Albamn_Hskwakr_Ig_Post(
            'id1234',
            'IMAGE',
            '',
            array(),
            'permalink1234',
            true
        );

        $wrong_prop_3 = new Albamn_Hskwakr_Ig_Post(
            '',
            'IMAGE',
            'mediaurl1234',
            array(),
            'permalink1234',
            true
        );

        $wrong_prop_4 = new Albamn_Hskwakr_Ig_Post(
            '',
            'CAROUSEL_ALBUM',
            '',
            array(),
            'permalink1234',
            true
        );

        $this->medias_wrong = array(
            'elem_string' => $wrong_array_elem_string,
            'elem_object' => $wrong_array_elem_object,
            'type' => $wrong_type,
            'lack_of_type' => $wrong_prop_1,
            'lack_of_url' => $wrong_prop_2,
            'lack_of_id' => $wrong_prop_3,
            'lack_of_url_list' => $wrong_prop_4,
        );

        /**
         * Instantiate
         */
        $this->formatter = new Albamn_Hskwakr_Admin_Ig_Formatter();
    }

    /**
     * Check the return has correct data
     */
    public function test_validate_medias()
    {
        /**
         * Asset: Propper case
         */
        $actual = $this->formatter->validate_medias(
            $this->medias_correct
        );
        $this->assertTrue($actual);

        /**
         * Asset: Wrong case
         * The array should contains only Albamn_Hskwakr_Ig_Post type
         */
        $medias = array(
            $this->medias_correct['image'],
            $this->medias_correct['video'],
            $this->medias_wrong['elem_string']
        );
        $actual = $this->formatter->validate_medias(
            $medias
        );
        $this->assertFalse($actual);

        $medias = array(
            $this->medias_correct['image'],
            $this->medias_correct['video'],
            $this->medias_wrong['elem_object']
        );
        $actual = $this->formatter->validate_medias(
            $medias
        );
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The media_type should be IMAGE or VIDEO
         */
        $medias = array(
            $this->medias_correct['image'],
            $this->medias_correct['video'],
            $this->medias_wrong['type']
        );
        $actual = $this->formatter->validate_medias(
            $medias
        );
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have media_type
         */
        $medias = array(
            $this->medias_correct['image'],
            $this->medias_correct['video'],
            $this->medias_wrong['lack_of_type']
        );
        $actual = $this->formatter->validate_medias(
            $medias
        );
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have media_url
         */
        $medias = array(
            $this->medias_correct['image'],
            $this->medias_correct['video'],
            $this->medias_wrong['lack_of_url']
        );
        $actual = $this->formatter->validate_medias(
            $medias
        );
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have media_url_list
         */
        $medias = array(
            $this->medias_correct['image'],
            $this->medias_correct['video'],
            $this->medias_wrong['lack_of_url_list']
        );
        $actual = $this->formatter->validate_medias(
            $medias
        );
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have id
         */
        $medias = array(
            $this->medias_correct['image'],
            $this->medias_correct['video'],
            $this->medias_wrong['lack_of_id']
        );
        $actual = $this->formatter->validate_medias(
            $medias
        );
        $this->assertFalse($actual);
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_format_image_media()
    {
        /**
         * Prepare
         */
        $media = $this->medias_correct['image'];

        $assert = function ($pattern, $subject) {
            $actual = preg_match($pattern, $subject);
            $expect = 1;
            $this->assertSame($expect, $actual);
        };

        /**
         * Execute
         */
        $subject = $this->formatter->format_image_media(
            $media
        );

        /**
         * Assert
         */
        $pattern = '/.*' . $media->media_url . '/';
        $assert($pattern, $subject);

        $pattern = '/.*' . $media->permalink . '/';
        $assert($pattern, $subject);
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_format_video_media()
    {
        /**
         * Prepare
         */
        $media = $this->medias_correct['video'];

        $assert = function ($pattern, $subject) {
            $actual = preg_match($pattern, $subject);
            $expect = 1;
            $this->assertSame($expect, $actual);
        };

        /**
         * Execute
         */
        $subject = $this->formatter->format_video_media(
            $media
        );

        /**
         * Assert
         */
        $pattern = '/.*' . $media->media_url . '/';
        $assert($pattern, $subject);

        $pattern = '/.*' . $media->permalink . '/';
        $assert($pattern, $subject);
    }
}
