<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Settings_Pager
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Settings_Pager
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Settings_Pager_Test extends WP_UnitTestCase
{
    private $pager;

    public function setUp()
    {
        $settings = $this->createMock(Albamn_Hskwakr_Admin_Settings::class);
        $this->pager = new Albamn_Hskwakr_Admin_Settings_Pager(
            $settings
        );
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
        $pattern  = '</form>';
        $subject  = $this->pager->display_form_footer();

        $actual = preg_match($pattern, $subject);
        $expect = 1;
        $this->assertSame($expect, $actual);
    }
}
