<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Setting_Pager
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Setting_Pager
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Setting_Pager_Test extends WP_UnitTestCase
{
    /**
     * Check the output has the necessary components.
     */
    public function test_display_header()
    {
        $pager = new Albamn_Hskwakr_Admin_Setting_Pager('', '');

        $this->expectOutputRegex('<form.*>');
        $pager->display_header();
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_footer()
    {
        $pager = new Albamn_Hskwakr_Admin_Setting_Pager('', '');

        $this->expectOutputRegex('</form>');
        $pager->display_footer();
    }
}
