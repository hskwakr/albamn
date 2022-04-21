<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Cpt
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Cpt
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Cpt_Test extends WP_UnitTestCase
{
    private $cpt;
    private $id;
    private $version;

    public function setUp()
    {
        $this->id = 'id-1234';
        $this->version = 'version1234';
        $this->cpt = new Albamn_Hskwakr_Admin_Cpt(
            $this->id,
            $this->version
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_hyphen_to_underbar()
    {
        /**
         * Prepare
         */
        $expect = 'id_1234';

        /**
         * Execute
         */
        $actual = $this->cpt->hyphen_to_underbar(
            $this->id
        );

        /**
         * Assert
         */
        $this->assertSame($expect, $actual);
    }
}
