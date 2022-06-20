<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Pager_List
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Pager_List
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Pager_List_Test extends WP_UnitTestCase
{
    private $list;
    private $pager;

    public function setUp()
    {
        /**
         * Create mock
         */
        $general = $this->createMock(
            Albamn_Hskwakr_Admin_Settings_Pager::class
        );
        $importer = $this->createMock(
            Albamn_Hskwakr_Admin_Importer_Pager::class
        );
        $editor = $this->createMock(
            Albamn_Hskwakr_Admin_Editor_Pager::class
        );

        $this->pager = array();
        $this->pager['general'] = $general;
        $this->pager['importer'] = $importer;
        $this->pager['editor'] = $editor;

        /**
         * Instantiate
         */
        $this->list = new Albamn_Hskwakr_Admin_Pager_List();
    }

    /**
     * Check the return has correct structure.
     */
    public function test_add()
    {
        foreach ($this->pager as $key => $value) {
            /**
             * Execute
             */
            $actual = $this->list->add(
                $key,
                $value
            );

            /**
             * Assert
             */
            $this->assertSame($value, $actual);
        }
    }

    /**
     * Check the return has correct structure.
     */
    public function test_get()
    {
        /**
         * Prepare
         */
        $expect = $this->pager;
        foreach ($this->pager as $key => $value) {
            $actual = $this->list->add(
                $key,
                $value
            );
        }

        /**
         * Execute
         */
        $actual = $this->list->get();

        /**
         * Assert
         */
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_find_by()
    {
        /**
         * Prepare
         */
        $name = 'general';
        $expect = $this->pager[$name];

        foreach ($this->pager as $key => $value) {
            $actual = $this->list->add(
                $key,
                $value
            );
        }

        /**
         * Execute
         */
        $actual = $this->list->find_by($name);

        /**
         * Assert
         */
        $this->assertSame($expect, $actual);
    }
}
