<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Enqueue
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Enqueue
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Enqueue_Test extends WP_UnitTestCase
{
    private $enqueue;
    private $url;

    public function setUp()
    {
        $this->enqueue = new Albamn_Hskwakr_Admin_Enqueue('', '');
        $this->url = '';
    }
    /**
     * Check the return has correct structure.
     */
    public function test_styles()
    {
        $s = $this->enqueue->styles($this->url);

        $this->assertContainsOnlyInstancesOf(
            Albamn_Hskwakr_Admin_Enqueue_Style::class,
            $s
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_scripts()
    {
        $s = $this->enqueue->scripts($this->url);

        $this->assertContainsOnlyInstancesOf(
            Albamn_Hskwakr_Admin_Enqueue_Script::class,
            $s
        );
    }
}
