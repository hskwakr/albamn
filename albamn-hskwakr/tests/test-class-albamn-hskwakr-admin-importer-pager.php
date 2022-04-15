<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Importer_Pager
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Importer_Pager
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Importer_Pager_Test extends WP_UnitTestCase
{
    private $pager;

    public function setUp()
    {
        /**
         * Create mock
         */
        $settings = $this->createMock(
            Albamn_Hskwakr_Admin_Settings::class
        );
        $api = $this->createMock(
            Albamn_Hskwakr_Ig_Api::class
        );
        $formatter = $this->createMock(
            Albamn_Hskwakr_Admin_Ig_Formatter::class
        );

        /**
         * Instantiate
         */
        $this->pager = new Albamn_Hskwakr_Admin_Importer_Pager(
            $settings,
            $api,
            $formatter
        );
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_header()
    {
        /**
         * Prepare
         */
        $pattern = '<div.*class=".*container.*>';
        $subject = $this->pager->display_header();

        /**
         * Assert
         */
        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_form_header()
    {
        /**
         * Prepare
         */
        $pattern = '<form.*>';
        $subject = $this->pager->display_form_header();

        /**
         * Assert
         */
        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_form_footer()
    {
        /**
         * Prepare
         */
        $pattern = '</form>';
        $subject = $this->pager->display_form_footer();

        /**
         * Assert
         */
        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_ig_image_post()
    {
        /**
         * Prepare
         */
        $post = new class () {};
        $post->media_type = 'IMAGE';
        $post->media_url = 'mediaurl1234';
        $post->permalink = 'permalink1234';

        /**
         * Execute
         */
        $subject  = $this->pager->display_ig_image_post($post);

        /**
         * Assert
         */
        $pattern = '/.*' . $post->media_url . '/';
        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);

        $pattern = '/.*' . $post->permalink . '/';
        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_ig_video_post()
    {
        /**
         * Prepare
         */
        $post = new class () {};
        $post->media_type = 'VIDEO';
        $post->media_url = 'mediaurl1234';
        $post->permalink = 'permalink1234';

        /**
         * Execute
         */
        $subject  = $this->pager->display_ig_video_post($post);

        /**
         * Assert
         */
        $pattern = '/.*' . $post->media_url . '/';
        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);

        $pattern = '/.*' . $post->permalink . '/';
        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);
    }

    /**
     * Should be error.
     * Argument object has to have necessary property.
     */
    public function test_display_ig_image_post_error_handle_argument()
    {
        /**
         * Prepare
         */
        $assert = function ($data) {
            $subject  = $this->pager->display_ig_image_post($data);
            $pattern = '/.*Fail/';
            $actual = preg_match($pattern, $subject);
            $expect = 1;
            $this->assertSame($expect, $actual);
        };

        /**
         * Assert wrong case:
         * Does not have media_type
         *
         * Should return error html
         */
        $post = new class () {};
        $post->media_url = 'mediaurl1234';
        $assert($post);

        /**
         * Assert wrong case:
         * media_type has wrong value
         *
         * Should return error html
         */
        $post = new class () {};
        $post->media_type = 'VIDEO';
        $post->media_url = 'mediaurl1234';
        $assert($post);

        /**
         * Assert wrong case:
         * Does not have media_url
         *
         * Should return error html
         */
        $post = new class () {};
        $post->media_type = 'IMAGE';
        $assert($post);
    }

    /**
     * Should be error.
     * Argument object has to have necessary property.
     */
    public function test_display_ig_video_post_error_handle_argument()
    {
        /**
         * Prepare
         */
        $assert = function ($data) {
            $subject  = $this->pager->display_ig_video_post($data);
            $pattern = '/.*Fail/';
            $actual = preg_match($pattern, $subject);
            $expect = 1;
            $this->assertSame($expect, $actual);
        };

        /**
         * Assert wrong case:
         * Does not have media_type
         *
         * Should return error html
         */
        $post = new class () {};
        $post->media_url = 'mediaurl1234';
        $assert($post);

        /**
         * Assert wrong case:
         * media_type has wrong value
         *
         * Should return error html
         */
        $post = new class () {};
        $post->media_type = 'IMAGE';
        $post->media_url = 'mediaurl1234';
        $assert($post);

        /**
         * Assert wrong case:
         * Does not have media_url
         *
         * Should return error html
         */
        $post = new class () {};
        $post->media_type = 'VIDEO';
        $assert($post);
    }
}
