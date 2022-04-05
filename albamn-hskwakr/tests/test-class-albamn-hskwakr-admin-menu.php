<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Menu
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Menu
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Menu_Test extends WP_UnitTestCase
{
    private $menu;

    public function setUp()
    {
        $pager = $this->createMock(
            Albamn_Hskwakr_Admin_Importer_Pager::class
        );
        $this->menu = new Albamn_Hskwakr_Admin_Menu($pager);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_base()
    {
        $b = $this->menu->base();

        $this->assertInstanceOf(
            Albamn_Hskwakr_Admin_Menu_Base::class,
            $b
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_sub()
    {
        $s = $this->menu->sub();

        $this->assertContainsOnlyInstancesOf(
            Albamn_Hskwakr_Admin_Menu_Sub::class,
            $s
        );
    }
}
