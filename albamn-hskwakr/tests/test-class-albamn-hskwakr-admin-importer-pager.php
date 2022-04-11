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
        $settings = $this->createMock(
            Albamn_Hskwakr_Admin_Settings::class
        );
        $api = $this->createMock(
            Albamn_Hskwakr_Ig_Api::class
        );
        $this->pager = new Albamn_Hskwakr_Admin_Importer_Pager(
            $settings,
            $api
        );
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_header()
    {
        $pattern = '<div.*class=".*container.*>';
        $subject = $this->pager->display_header();

        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_form_header()
    {
        $pattern = '<form.*>';
        $subject = $this->pager->display_form_header();

        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_form_footer()
    {
        $pattern = '</form>';
        $subject = $this->pager->display_form_footer();

        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_ig_image_post()
    {
        $post = new class () {};
        $post->media_type = 'IMAGE';
        $post->media_url = 'mediaurl1234';
        $post->permalink = 'permalink1234';

        /**
         * Assert
         */
        $subject  = $this->pager->display_ig_image_post($post);

        $pattern = '/.*' . $post->media_url . '/';
        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);

        $pattern = '/.*' . $post->permalink . '/';
        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);
    }
}
