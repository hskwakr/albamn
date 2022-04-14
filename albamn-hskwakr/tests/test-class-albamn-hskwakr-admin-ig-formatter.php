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
        $correct_image = new class () {};
        $correct_image->media_type = 'IMAGE';
        $correct_image->media_url = 'mediaurl1234';
        $correct_image->permalink = 'permalink1234';

        $correct_video = new class () {};
        $correct_video->media_type = 'VIDEO';
        $correct_video->media_url = 'mediaurl1234';
        $correct_video->permalink = 'permalink1234';

        $this->medias_correct = array(
            'image' => $correct_image,
            'video' => $correct_video
        );

        /**
         * Prepare fake data
         * Wrong values
         */
        $wrong_array_elem = '';

        $wrong_type = new class () {};
        $wrong_type->media_type = 'OTHER';
        $wrong_type->media_url = 'mediaurl1234';
        $wrong_type->permalink = 'permalink1234';

        $wrong_prop_1 = new class () {};
        $wrong_prop_1->media_url = 'mediaurl1234';
        $wrong_prop_1->permalink = 'permalink1234';

        $wrong_prop_2 = new class () {};
        $wrong_prop_2->media_type = 'IMAGE';
        $wrong_prop_2->permalink = 'permalink1234';

        $this->medias_wrong = array(
            'elem' => $wrong_array_elem,
            'type' => $wrong_type,
            'lack_of_type' => $wrong_prop_1,
            'lack_of_url' => $wrong_prop_2
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
         * The array should contains only object type
         */
        $medias = array(
            $this->medias_correct['image'],
            $this->medias_correct['video'],
            $this->medias_wrong['elem']
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
