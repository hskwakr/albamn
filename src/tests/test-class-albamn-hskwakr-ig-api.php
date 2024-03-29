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
    private $repository;

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
        $this->repository = $this->createMock(
            Albamn_Hskwakr_Ig_Media_Repository::class
        );

        /**
         * Init fake objects
         */
        $media_image = new class () {};
        $media_image->media_type = 'IMAGE';
        $media_image->media_type_list = array();
        $media_image->media_url = 'url1234';
        $media_image->media_url_list = array();
        $media_image->permalink = 'link1234';
        $media_image->visibility = true;
        $media_image->id = 'id1234';

        $media_video = new class () {};
        $media_video->media_type = 'VIDEO';
        $media_video->media_type_list = array();
        $media_video->media_url = 'url1234';
        $media_video->media_url_list = array();
        $media_video->permalink = 'link1234';
        $media_video->visibility = true;
        $media_video->id = 'id1234';

        $wrong_media_1 = new class () {};
        $wrong_media_1->media_type = 'OTHER';
        $wrong_media_1->media_type_list = array();
        $wrong_media_1->media_url = 'url1234';
        $wrong_media_1->media_url_list = array();
        $wrong_media_1->permalink = 'link1234';
        $wrong_media_1->visibility = true;
        $wrong_media_1->id = 'id1234';

        $wrong_media_2 = new class () {};
        $wrong_media_2->media_type = 'IMAGE';
        $wrong_media_1->media_type_list = array();
        $wrong_media_2->media_url_list = array();
        $wrong_media_2->permalink = 'link1234';
        $wrong_media_2->visibility = true;
        $wrong_media_2->id = 'id1234';

        $this->medias = array();
        $this->medias[0] = $media_image;
        $this->medias[1] = $media_video;
        $this->medias[2] = $wrong_media_1;
        $this->medias[3] = $wrong_media_2;
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
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $actual = $api->init($this->ctx);
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
    public function test_validate_init_arg()
    {
        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         * with token
         */
        $actual = $api->validate_init_arg($this->token);
        $this->assertNotNull($actual);

        /**
         * Assert
         * with object
         */
        $actual = $api->validate_init_arg($this->ctx);
        $this->assertNotNull($actual);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_validate_album_media()
    {
        /**
         * Prepare
         */

        /**
         * Correct data
         */
        $correct_media = new class () {};
        $correct_media->children = new class () {};
        $correct_media->children->data = array();
        $correct_media->children->data[0] = new class () {};
        $correct_media->children->data[0]->id = 'id1234';
        $correct_media->children->data[0]->media_type = 'mediatype1234';
        $correct_media->children->data[0]->media_url = 'mediaurl1234';

        /**
         * Wrong data
         * children is not object
         */
        $wrong_media_children_1 = new class () {};
        $wrong_media_children_1->children = '';

        /**
         * Wrong data
         * data is not array
         */
        $wrong_media_data_1 = new class () {};
        $wrong_media_data_1->children = new class () {};
        $wrong_media_data_1->children->data = '';

        /**
         * Wrong data
         * element of data is not object
         */
        $wrong_media_data_elm_1 = new class () {};
        $wrong_media_data_elm_1->children = new class () {};
        $wrong_media_data_elm_1->children->data = array();
        $wrong_media_data_elm_1->children->data[0] = '';

        /**
         * Wrong data
         * media_type is not exist
         */
        $wrong_media_type_1 = new class () {};
        $wrong_media_type_1->children = new class () {};
        $wrong_media_type_1->children->data = array();
        $wrong_media_type_1->children->data[0] = new class () {};
        $wrong_media_type_1->children->data[0]->id = 'id1234';
        $wrong_media_type_1->children->data[0]->media_url = 'mediaurl1234';

        /**
         * Wrong data
         * media_url is not exist
         */
        $wrong_media_url_1 = new class () {};
        $wrong_media_url_1->children = new class () {};
        $wrong_media_url_1->children->data = array();
        $wrong_media_url_1->children->data[0] = new class () {};
        $wrong_media_url_1->children->data[0]->id = 'id1234';
        $wrong_media_url_1->children->data[0]->media_type = 'mediatype1234';

        /**
         * Wrong data
         * id is not exist
         */
        $wrong_media_id_1 = new class () {};
        $wrong_media_id_1->children = new class () {};
        $wrong_media_id_1->children->data = array();
        $wrong_media_id_1->children->data[0] = new class () {};
        $wrong_media_id_1->children->data[0]->media_type = 'mediatype1234';
        $wrong_media_id_1->children->data[0]->media_url = 'mediaurl1234';

        /**
         * Execute
         */
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         * Proper case:
         */
        $actual = $api->validate_album_media($correct_media);
        $this->assertTrue($actual);

        /**
         * Assert
         * Wrong case:
         */
        $actual = $api->validate_album_media($wrong_media_children_1);
        $this->assertFalse($actual);
        $actual = $api->validate_album_media($wrong_media_data_1);
        $this->assertFalse($actual);
        $actual = $api->validate_album_media($wrong_media_data_elm_1);
        $this->assertFalse($actual);
        $actual = $api->validate_album_media($wrong_media_url_1);
        $this->assertFalse($actual);
        $actual = $api->validate_album_media($wrong_media_type_1);
        $this->assertFalse($actual);
        $actual = $api->validate_album_media($wrong_media_id_1);
        $this->assertFalse($actual);
    }

    /**
     * Check the return has correct structure.
     */
    public function test_search_hashtag_with_top_method()
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
             ->method('medias_top')
             ->willReturn($this->medias);

        /**
         * Prepare to test
         */
        $method = 'top';
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $actual = $api->init($this->ctx)
                      ->search_hashtag($this->hashtag_name, $method);

        $this->assertSame(
            $this->pages_id,
            $actual->pages_id
        );
        $this->assertSame(
            $this->user_id,
            $actual->user_id
        );
        $this->assertSame(
            $this->hashtag_id,
            $actual->hashtag_id
        );
        $this->assertEquals(
            $this->medias,
            $actual->medias
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_search_hashtag_with_recent_method()
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
        $method = 'recent';
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $actual = $api->init($this->ctx)
                      ->search_hashtag($this->hashtag_name, $method);

        $this->assertSame(
            $this->pages_id,
            $actual->pages_id
        );
        $this->assertSame(
            $this->user_id,
            $actual->user_id
        );
        $this->assertSame(
            $this->hashtag_id,
            $actual->hashtag_id
        );
        $this->assertEquals(
            $this->medias,
            $actual->medias
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_filter_medias()
    {
        /**
         * Prepare
         */
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        $data_1 = new Albamn_Hskwakr_Ig_Post(
            $this->medias[0]->id,
            $this->medias[0]->media_type,
            $this->medias[0]->media_type_list,
            $this->medias[0]->media_url,
            $this->medias[0]->media_url_list,
            $this->medias[0]->permalink,
            false
        );
        $data_2 = new Albamn_Hskwakr_Ig_Post(
            $this->medias[1]->id,
            $this->medias[1]->media_type,
            $this->medias[1]->media_type_list,
            $this->medias[1]->media_url,
            $this->medias[1]->media_url_list,
            $this->medias[1]->permalink,
            false
        );

        /**
         * Execute
         */
        $actual = $api->filter_medias($this->medias);

        /**
         * Assert
         */
        $this->assertContainsOnlyInstancesOf(
            Albamn_Hskwakr_Ig_Post::class,
            $actual
        );

        /**
         * Assert
         */
        $expects = array(
            $data_1,
            $data_2
        );
        foreach ($actual as $v) {
            if (!in_array($v, $expects)) {
                $this->fail();
            }
        }
    }

    /**
     * Should be error.
     * The method should be called after init method.
     */
    public function test_search_hashtag_should_after_init()
    {
        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $actual = $api->search_hashtag($this->hashtag_name);
    }

    /**
     * Should be error.
     */
    public function test_init_error_handle_argument_type()
    {
        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $arg = 0;
        $this->expectException(Exception::class);
        $actual = $api->init($arg);
    }

    /**
     * Should be error.
     */
    public function test_init_error_handle_object_type()
    {
        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $arg = new class () {};
        $this->expectException(Exception::class);
        $actual = $api->init($arg);
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
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $api->init($this->ctx);
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
             ->method('user_pages_id')
             ->willReturn($this->pages_id);
        $this->ctx
             ->method('ig_user_id')
             ->will($this->throwException(new Exception()));

        /**
         * Prepare to test
         */
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $api->init($this->ctx);
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
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $api->init($this->ctx)->search_hashtag($this->hashtag_name);
    }

    /**
     * Should be error.
     * Should catch error from context class.
     */
    public function test_search_hashtag_error_handle_medias_top()
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
             ->method('medias_top')
             ->will($this->throwException(new Exception()));

        /**
         * Prepare to test
         */
        $method = 'top';
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $api->init($this->ctx)
            ->search_hashtag($this->hashtag_name, $method);
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
        $method = 'recent';
        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $this->expectException(Exception::class);
        $api->init($this->ctx)
            ->search_hashtag($this->hashtag_name, $method);
    }

    /**
     * Should be error.
     */
    public function test_filter_medias_error_handle_not_object()
    {
        /**
         * Prepare
         */
        $media_correct = new class () {};
        $media_correct->media_type = 'IMAGE';
        $media_correct->media_url = 'url1234';
        $media_correct->permalink = 'link1234';
        $media_correct->id = 'id1234';

        $media_wrong = '';

        $api = new Albamn_Hskwakr_Ig_Api(
            $this->repository
        );

        /**
         * Assert
         */
        $medias = array(
            $media_correct,
            $media_wrong
        );
        $this->expectException(Exception::class);
        $api->filter_medias($medias);
    }
}
