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
    private $entries;

    public function setUp()
    {
        /**
         * Prepare fake data
         */
        $entry_id = 1234;
        $entry_title = 'entrytitle';
        $entry_type = 'entrytype';
        $entry_status = 'entrystatus';

        $media_id = 'mediaid1234';
        $media_type = 'mediatype';
        $media_url = 'mediaurl';
        $media_permalink = 'mediapermalink ';

        $this->post = new Albamn_Hskwakr_Ig_Post(
            $media_id,
            $media_type,
            $media_url,
            $media_permalink
        );

        $entry = new Albamn_Hskwakr_Ig_Post_Db_Entry(
            $entry_id,
            $entry_title,
            $entry_type,
            $entry_status,
            $this->post
        );

        $this->entries = array(
            $entry
        );

        /**
         * Create mock
         */
        $this->db = $this->createMock(
            Albamn_Hskwakr_Ig_Post_Db_Provider::class
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

    /**
     * Check the return has correct structure.
     */
    public function test_get()
    {
        /**
         * Prepare
         */
        $amount = 1;
        $this->db
             ->method('get')
             ->willReturn($this->entries);

        /**
         * Execute
         */
        $actual = $this->repository->get($amount);

        /**
         * Assert
         */
        $this->assertEquals($this->post, $actual[0]);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_find_by()
    {
        /**
         * Prepare
         */
        $this->db
             ->method('get')
             ->willReturn($this->entries);

        /**
         * Execute
         */
        $media_id = 'mediaid1234';
        $actual = $this->repository->find_by($media_id);

        /**
         * Assert
         * Proper case:
         */
        $this->assertTrue($actual instanceof Albamn_Hskwakr_Ig_Post);

        /**
         * Execute
         */
        $media_id = 'wrongid1234';
        $actual = $this->repository->find_by($media_id);

        /**
         * Assert
         * Wrong case:
         */
        $this->assertNull($actual);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_find_by_with_empty_array()
    {
        /**
         * Prepare
         */
        $this->db
             ->method('get')
             ->willReturn(array());

        /**
         * Execute
         */
        $media_id = 'mediaid1234';
        $actual = $this->repository->find_by($media_id);

        /**
         * Assert
         */
        $this->assertNull($actual);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_remove_with_true()
    {
        /**
         * Prepare
         */
        $this->db
             ->method('get')
             ->willReturn($this->entries);
        $this->db
             ->method('remove')
             ->willReturn(true);

        /**
         * Execute
         */
        $media_id = 'mediaid1234';
        $actual = $this->repository->remove($media_id);

        /**
         * Assert
         * Proper case:
         */
        $this->assertTrue($actual);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_remove_with_false()
    {
        /**
         * Prepare
         */
        $this->db
             ->method('get')
             ->willReturn($this->entries);
        $this->db
             ->method('remove')
             ->willReturn(false);

        /**
         * Execute
         */
        $media_id = 'mediaid1234';
        $actual = $this->repository->remove($media_id);

        /**
         * Assert
         * Proper case:
         */
        $this->assertFalse($actual);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_remove_all_with_true()
    {
        /**
         * Prepare
         */
        $this->db
             ->method('get')
             ->willReturn($this->entries);
        $this->db
             ->method('remove')
             ->willReturn(true);

        /**
         * Execute
         */
        $media_id = 'mediaid1234';
        $actual = $this->repository->remove_all($media_id);

        /**
         * Assert
         * Proper case:
         */
        $this->assertTrue($actual);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_remove_all_with_false()
    {
        /**
         * Prepare
         */
        $this->db
             ->method('get')
             ->willReturn($this->entries);
        $this->db
             ->method('remove')
             ->willReturn(false);

        /**
         * Execute
         */
        $media_id = 'mediaid1234';
        $actual = $this->repository->remove_all($media_id);

        /**
         * Assert
         * Proper case:
         */
        $this->assertFalse($actual);
    }
}
