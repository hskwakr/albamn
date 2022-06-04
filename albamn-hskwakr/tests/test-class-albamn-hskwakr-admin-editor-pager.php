<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Editor_Pager
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Editor_Pager
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Editor_Pager_Test extends WP_UnitTestCase
{
    private $pager;

    public function setUp()
    {
        /**
         * Create mock
         */
        $repository = $this->createMock(
            Albamn_Hskwakr_Ig_Post_Repository::class
        );
        $formatter = $this->createMock(
            Albamn_Hskwakr_Admin_Ig_Formatter::class
        );

        /**
         * Instantiate
         */
        $this->pager = new Albamn_Hskwakr_Admin_Editor_Pager(
            $repository,
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
    public function test_extract_ig_post_id()
    {
        /**
         * Prepare
         */
        $data = array();
        $expect = array();

        $correct = array(
            'correct1234' => 'ig_post',
            '1234correct' => 'ig_post'
        );
        $wrong = array(
            'wrong1234' => 'wrong_post',
        );

        foreach ($correct as $k => $v) {
            $data[$k] = $v;
            $expect[] = $k;
        }
        foreach ($wrong as $k => $v) {
            $data[$k] = $v;
        }

        /**
         * Execute
         */
        $actual = $this->pager->extract_ig_post_id(
            $data
        );

        /**
         * Assert
         */
        $this->assertEqualsCanonicalizing($expect, $actual);
    }
}
