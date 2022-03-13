<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Setting
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Setting
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Setting_Test extends WP_UnitTestCase
{
    /**
     * Check the return has correct structure.
     */
    public function test_get_options()
    {
        $setting = new Albamn_Hskwakr_Admin_Setting('', '');
        $o = $setting->get_options();

        $this->assertContainsOnlyInstancesOf(
            Albamn_Hskwakr_Admin_Setting_Option::class,
            $o
        );

        /**
         * @var Albamn_Hskwakr_Admin_Setting_Option
         */
        foreach ($o as $v) {
            $this->assertContainsOnly(
                'string',
                $v->group
            );
        }
    }
}
