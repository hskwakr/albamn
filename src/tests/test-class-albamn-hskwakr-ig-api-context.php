<?php
/**
 * The test cases for Albamn_Hskwakr_Ig_Api_Context
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Ig_Api_Context
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Api_Context_Test extends WP_UnitTestCase
{
    private $http;
    private $query;
    private $validation;

    private $token = 'token1234';
    private $pages_id = 'page1234';
    private $user_id = 'user1234';
    private $hashtag_name = 'hashtagname1234';
    private $hashtag_id = 'hashtagid1234';
    private $media;
    private $error;

    public function setUp()
    {
        /**
         * Create mock
         */
        $this->http = $this->createMock(
            Albamn_Hskwakr_Ig_Http_Client::class
        );
        $this->query = $this->createMock(
            Albamn_Hskwakr_Ig_Query::class
        );
        $this->validation = $this->createMock(
            Albamn_Hskwakr_Ig_Api_Response_Validation::class
        );

        /**
         * Init fake values
         */
        $this->media = new class () {};
        $this->media->media_type = 'type1234';
        $this->media->media_url = 'url1234';
        $this->media->permalink = 'link1234';
        $this->media->id = 'id1234';

        $this->error = new class () {};
        $this->error->message = 'Something wrong';
    }

    /**
     * Check the return has correct value.
     */
    public function test_user_pages_id()
    {
        $expect = $this->pages_id;

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0]->id = $expect;

        /**
         * Set fake response
         */
        $this->http
             ->method('send')
             ->willReturn($response);
        $this->validation
             ->method('validate_user_pages')
             ->willReturn(true);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Assert
         */
        $actual = $ctx->user_pages_id();
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the return has correct value.
     */
    public function test_ig_user_id()
    {
        $expect = $this->user_id;

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->instagram_business_account = new class () {};
        $response->instagram_business_account->id = $expect;

        /**
         * Set fake response
         */
        $this->http
             ->method('send')
             ->willReturn($response);
        $this->validation
             ->method('validate_ig_user')
             ->willReturn(true);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Assert
         */
        $actual = $ctx->ig_user_id($this->pages_id);
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the return has correct value.
     */
    public function test_hashtag_id()
    {
        $expect = $this->hashtag_id;

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0]->id = $expect;

        /**
         * Set fake response
         */
        $this->http
             ->method('send')
             ->willReturn($response);
        $this->validation
             ->method('validate_search_hashtag')
             ->willReturn(true);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Assert
         */
        $actual = $ctx->hashtag_id(
            $this->user_id,
            $this->hashtag_name
        );
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the return has correct value.
     */
    public function test_medias_recent()
    {
        $expect = $this->media;

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0] = $expect;

        /**
         * Set fake response
         */
        $this->http
             ->method('send')
             ->willReturn($response);
        $this->validation
             ->method('validate_medias_by_hashtag')
             ->willReturn(true);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Assert
         */
        $actual = $ctx->medias_recent(
            $this->user_id,
            $this->hashtag_id
        );
        $this->assertEquals($expect, $actual[0]);
    }

    /**
     * Check the return has correct value.
     */
    public function test_medias_top()
    {
        $expect = $this->media;

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0] = $expect;

        /**
         * Set fake response
         */
        $this->http
             ->method('send')
             ->willReturn($response);
        $this->validation
             ->method('validate_medias_by_hashtag')
             ->willReturn(true);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Assert
         */
        $actual = $ctx->medias_top(
            $this->user_id,
            $this->hashtag_id
        );
        $this->assertEquals($expect, $actual[0]);
    }

    /**
     * Check the return has correct value.
     */
    public function test_medias_next()
    {
        $expect = $this->media;

        /**
         * Create fake data
         */
        $query = 'query1234';
        $max = 200;
        $count = 0;

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0] = $expect;

        /**
         * Set fake response
         */
        $this->http
             ->method('send')
             ->willReturn($response);
        $this->validation
             ->method('validate_medias_by_hashtag')
             ->willReturn(true);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Execute
         */
        $actual = $ctx->medias_next(
            $query,
            $max,
            $count
        );

        /**
         * Assert
         */
        $this->assertEquals($expect, $actual[0]);
    }

    /**
     * Check the return has correct value.
     */
    public function test_check_paging_field()
    {
        /**
         * Create fake response
         */
        $correct = new class () {};
        $correct->paging = new class () {};
        $correct->paging->next = 'query1234';

        $wrong_1 = new class () {};

        $wrong_2 = new class () {};
        $wrong_2->paging = '';

        $wrong_3 = new class () {};
        $wrong_3->paging = new class () {};

        $wrong_4 = new class () {};
        $wrong_4->paging = new class () {};
        $wrong_4->paging->next = new class () {};

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Assert proper case:
         */
        $actual = $ctx->check_paging_field(
            $correct
        );
        $this->assertTrue($actual);

        /**
         * Assert wrong case:
         * paging does not exist
         */
        $actual = $ctx->check_paging_field(
            $wrong_1
        );
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * paging does not object
         */
        $actual = $ctx->check_paging_field(
            $wrong_2
        );
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * next does not exist
         */
        $actual = $ctx->check_paging_field(
            $wrong_3
        );
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * next does not string
         */
        $actual = $ctx->check_paging_field(
            $wrong_4
        );
        $this->assertFalse($actual);
    }

    /**
     * Should be error.
     * Should check error from request.
     */
    public function test_user_pages_id_error_from_request()
    {
        /**
         * Create fake response
         */
        $response = new class () {};
        $response->error = $this->error;

        /**
         * Set fake response
         */
        $this->http->method('send')->willReturn($response);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Expect exception thrown
         */
        $this->expectException(Exception::class);
        $ctx->user_pages_id();
    }

    /**
     * Should be error.
     * Should check error from request.
     */
    public function test_ig_user_id_error_from_request()
    {
        /**
         * Create fake response
         */
        $response = new class () {};
        $response->error = $this->error;

        /**
         * Set fake response
         */
        $this->http->method('send')->willReturn($response);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Expect exception thrown
         */
        $this->expectException(Exception::class);
        $ctx->ig_user_id('');
    }

    /**
     * Should be error.
     * Should check error from request.
     */
    public function test_hashtag_id_error_from_request()
    {
        /**
         * Create fake response
         */
        $response = new class () {};
        $response->error = $this->error;

        /**
         * Set fake response
         */
        $this->http->method('send')->willReturn($response);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Expect exception thrown
         */
        $this->expectException(Exception::class);
        $ctx->hashtag_id('', '');
    }

    /**
     * Should be error.
     * Should check error from request.
     */
    public function test_medias_recent_error_from_request()
    {
        /**
         * Create fake response
         */
        $response = new class () {};
        $response->error = $this->error;

        /**
         * Set fake response
         */
        $this->http->method('send')->willReturn($response);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Expect exception thrown
         */
        $this->expectException(Exception::class);
        $ctx->medias_recent('', '');
    }

    /**
     * Should be error.
     * Should check error from request.
     */
    public function test_medias_top_error_from_request()
    {
        /**
         * Create fake response
         */
        $response = new class () {};
        $response->error = $this->error;

        /**
         * Set fake response
         */
        $this->http->method('send')->willReturn($response);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Expect exception thrown
         */
        $this->expectException(Exception::class);
        $ctx->medias_top('', '');
    }

    /**
     * Should be error.
     * Should check error from request.
     */
    public function test_medias_next_error_from_request()
    {
        /**
         * Create fake response
         */
        $response = new class () {};
        $response->error = $this->error;

        /**
         * Set fake response
         */
        $this->http->method('send')->willReturn($response);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Expect exception thrown
         */
        $this->expectException(Exception::class);
        $ctx->medias_next(
            '',
            0,
            0
        );
    }

    /**
     * Check the return has correct value.
     */
    public function test_medias_next_with_count_than_max()
    {
        /**
         * Create fake data
         */
        $query = 'query1234';
        $max = 0;
        $count = 10;

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0] = $this->media;

        /**
         * Set fake response
         */
        $this->http
             ->method('send')
             ->willReturn($response);
        $this->validation
             ->method('validate_medias_by_hashtag')
             ->willReturn(true);

        /**
         * Init context class
         */
        $ctx = new Albamn_Hskwakr_Ig_Api_Context(
            $this->http,
            $this->query,
            $this->validation,
            $this->token
        );

        /**
         * Execute
         */
        $actual = $ctx->medias_next(
            $query,
            $max,
            $count
        );

        /**
         * Assert
         */
        $this->assertTrue(empty($actual));
    }
}
