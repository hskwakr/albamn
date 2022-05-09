<?php
/**
 * The test cases for Albamn_Hskwakr_Ig_Post_Repository
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Ig_Post_Repository
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Post_Repository_Test extends WP_UnitTestCase
{
    private $repository;
    private $db;
    private $post;

    public function setUp()
    {
        /**
         * Prepare fake data
         */

        /**
         * Create mock
         */
        $this->db = $this->createMock(
            Albamn_Hskwakr_Ig_Post_Db_Provider::class
        );
        $this->post = $this->createMock(
            Albamn_Hskwakr_Ig_Post::class
        );

        /**
         * Instantiate repository class
         */
        $this->repository = new Albamn_Hskwakr_Ig_Post_Repository(
            $this->db
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_add_with_true()
    {
        /**
         * Prepare
         */
        $this->db
             ->method('add')
             ->willReturn(true);

        /**
         * Execute
         */
        $actual = $this->repository->add($this->post);

        /**
         * Assert
         */
        $this->assertTrue($actual);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_add_with_false()
    {
        /**
         * Prepare
         */
        $this->db
             ->method('add')
             ->willReturn(false);

        /**
         * Execute
         */
        $actual = $this->repository->add($this->post);

        /**
         * Assert
         */
        $this->assertFalse($actual);
    }
}
