<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Importer_Pager_Test
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Importer_Pager_Test
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
        $settings = $this->createMock(Albamn_Hskwakr_Admin_Settings::class);
        $this->pager = new Albamn_Hskwakr_Admin_Importer_Pager($settings);
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_header()
    {
        $this->expectOutputRegex('<form.*>');
        $this->pager->display_header();
    }

    /**
     * Check the output has the necessary components.
     */
    public function test_display_footer()
    {
        $this->expectOutputRegex('</form>');
        $this->pager->display_footer();
    }
}
