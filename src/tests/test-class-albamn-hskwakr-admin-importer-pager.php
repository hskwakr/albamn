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
    private $repository;

    public function setUp()
    {
        /**
         * Create mock
         */
        $ig_api = $this->createMock(
            Albamn_Hskwakr_Ig_Api::class
        );
        $settings = $this->createMock(
            Albamn_Hskwakr_Settings::class
        );
        $formatter = $this->createMock(
            Albamn_Hskwakr_Admin_Ig_Formatter::class
        );
        $this->repository = $this->createMock(
            Albamn_Hskwakr_Ig_Post_Repository::class
        );

        /**
         * Instantiate
         */
        $this->pager = new Albamn_Hskwakr_Admin_Importer_Pager(
            $settings,
            $ig_api,
            $this->repository,
            $formatter
        );
    }

    /**
     * Check the return has correct value.
     */
    public function test_is_in_db_true()
    {
        /**
         * Prepare
         */
        $post = $this->createMock(
            Albamn_Hskwakr_Ig_Post::class
        );
        $found = $this->createMock(
            Albamn_Hskwakr_Ig_Post::class
        );

        $post->id = '9066808a-10f5-42ed-8cae-2c53e57f6ff9';
        $this->repository
             ->method('find_by')
             ->willReturn($found);

        /**
         * Execute
         */
        $actual = $this->pager->is_in_db($post);

        /**
         * Assert
         */
        $this->assertTrue($actual);
    }

    /**
     * Check the return has correct value.
     */
    public function test_is_in_db_false()
    {
        /**
         * Prepare
         */
        $post = $this->createMock(
            Albamn_Hskwakr_Ig_Post::class
        );
        $found = null;

        $post->id = '9066808a-10f5-42ed-8cae-2c53e57f6ff9';
        $this->repository
             ->method('find_by')
             ->willReturn($found);

        /**
         * Execute
         */
        $actual = $this->pager->is_in_db($post);

        /**
         * Assert
         */
        $this->assertFalse($actual);
    }
}
