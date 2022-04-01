<?php
/**
 * The test cases for Albamn_Hskwakr_Ig_Api
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Ig_Api
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Api_Test extends WP_UnitTestCase
{
    private $ctx;

    private $token = 'token1234';
    private $pages_id = 'pages1234';
    private $user_id = 'user1234';
    private $hashtag_name = 'hashtagname1234';
    private $hashtag_id = 'hashtagid1234';
    private $medias;

    public function setUp()
    {
        /**
         * Create mock
         */
        $this->ctx = $this->createMock(
            Albamn_Hskwakr_Ig_Api_Context::class
        );

        /**
         * Init fake objects
         */
        $media = new class () {};
        $media->media_type = 'type1234';
        $media->media_url = 'url1234';
        $media->permalink = 'link1234';
        $media->id = 'id1234';

        $this->medias = array(new class () {});
        $this->medias[0] = $media;
    }

    /**
     * Check the return has correct structure.
     */
    public function test_init()
    {
        /**
         * Set up mock
         */
        $this->ctx
             ->method('user_pages_id')
             ->willReturn($this->pages_id);
        $this->ctx
             ->method('ig_user_id')
             ->willReturn($this->user_id);

        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api($this->token);
        $api = $api->set_context($this->ctx);

        /**
         * Assert
         */
        $actual = $api->init();

        $this->assertSame(
            $this->pages_id,
            $actual->pages_id
        );
        $this->assertSame(
            $this->user_id,
            $actual->user_id
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_search_hashtag()
    {
        /**
         * Set up mock
         */
        $this->ctx
             ->method('user_pages_id')
             ->willReturn($this->pages_id);
        $this->ctx
             ->method('ig_user_id')
             ->willReturn($this->user_id);
        $this->ctx
             ->method('hashtag_id')
             ->willReturn($this->hashtag_id);
        $this->ctx
             ->method('medias_recent')
             ->willReturn($this->medias);

        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api($this->token);
        $api = $api->set_context($this->ctx);

        /**
         * Assert
         */
        $actual = $api->init()
                      ->search_hashtag($this->hashtag_name);

        $this->assertSame(
            $this->hashtag_id,
            $actual->hashtag_id
        );
        $this->assertEquals(
            $this->medias,
            $actual->recent_medias
        );
    }

    /**
     * Should be error.
     * The method should be called after init method.
     */
    public function test_search_hashtag_should_after_init()
    {
        /**
         * Set up mock
         */
        $this->ctx
             ->method('user_pages_id')
             ->willReturn($this->pages_id);
        $this->ctx
             ->method('ig_user_id')
             ->willReturn($this->user_id);
        $this->ctx
             ->method('hashtag_id')
             ->willReturn($this->hashtag_id);
        $this->ctx
             ->method('medias_recent')
             ->willReturn($this->medias);

        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api($this->token);
        $api = $api->set_context($this->ctx);

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $actual = $api->search_hashtag($this->hashtag_name);
    }

    /**
     * Should be error.
     * Should catch error from context class.
     */
    public function test_init_error_handle_user_pages_id()
    {
        /**
         * Set up mock
         */
        $this->ctx
             ->method('user_pages_id')
             ->will($this->throwException(new Exception()));

        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api($this->token);
        $api = $api->set_context($this->ctx);

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $api->init();
    }

    /**
     * Should be error.
     * Should catch error from context class.
     */
    public function test_init_error_handle_ig_user_id()
    {
        /**
         * Set up mock
         */
        $this->ctx
             ->method('ig_user_id')
             ->will($this->throwException(new Exception()));

        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api($this->token);
        $api = $api->set_context($this->ctx);

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $api->init();
    }

    /**
     * Should be error.
     * Should catch error from context class.
     */
    public function test_search_hashtag_error_handle_hashtag_id()
    {
        /**
         * Set up mock
         */
        $this->ctx
             ->method('user_pages_id')
             ->willReturn($this->pages_id);
        $this->ctx
             ->method('ig_user_id')
             ->willReturn($this->user_id);
        $this->ctx
             ->method('hashtag_id')
             ->will($this->throwException(new Exception()));

        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api($this->token);
        $api = $api->set_context($this->ctx);

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $api->init()->search_hashtag($this->hashtag_name);
    }

    /**
     * Should be error.
     * Should catch error from context class.
     */
    public function test_search_hashtag_error_handle_medias_recent()
    {
        /**
         * Set up mock
         */
        $this->ctx
             ->method('user_pages_id')
             ->willReturn($this->pages_id);
        $this->ctx
             ->method('ig_user_id')
             ->willReturn($this->user_id);
        $this->ctx
             ->method('hashtag_id')
             ->willReturn($this->hashtag_id);
        $this->ctx
             ->method('medias_recent')
             ->will($this->throwException(new Exception()));

        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api($this->token);
        $api = $api->set_context($this->ctx);

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $api->init()->search_hashtag($this->hashtag_name);
    }
}