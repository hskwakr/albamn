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
    private $token = 'token1234';

    public function setUp()
    {
        $this->http = $this->createMock(
            Albamn_Hskwakr_Ig_Http_Client::class
        );
        $this->query = $this->createMock(
            Albamn_Hskwakr_Ig_Query::class
        );
    }

    /**
     * Check the return has correct value.
     */
    public function test_user_pages_id()
    {
        $expect = 'page1234';

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0]->id = $expect;

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
        $page_id = 'page1234';
        $expect = 'user1234';

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->instagram_business_account = new class () {};
        $response->instagram_business_account->id = $expect;

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
            $this->token
        );

        /**
         * Assert
         */
        $actual = $ctx->ig_user_id($page_id);
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the return has correct value.
     */
    public function test_hashtag_id()
    {
        $user_id = 'user1234';
        $hashtag = 'hashtagname1234';
        $expect = 'hashtagid1234';

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0]->id = $expect;

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
            $this->token
        );

        /**
         * Assert
         */
        $actual = $ctx->hashtag_id($user_id, $hashtag);
        $this->assertSame($expect, $actual);
    }

    /**
     * Check the return has correct value.
     */
    public function test_medias_recent()
    {
        $user_id = 'user1234';
        $hashtag = 'hashtag1234';

        $expect = new class () {};
        $expect->media_type = 'type1234';
        $expect->media_url = 'url1234';
        $expect->permalink = 'link1234';
        $expect->id = 'id1234';

        /**
         * Create fake response
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0] = $expect;

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
            $this->token
        );

        /**
         * Assert
         */
        $actual = $ctx->medias_recent($user_id, $hashtag);
        $this->assertEquals($expect, $actual[0]);
    }

    /**
     * Check error handling
     */
    public function test_user_pages_id_error_handling()
    {
        /**
         * Create fake response
         */
        $response = new class () {};
        $response->error = new class () {};
        $response->error->message = 'Something wrong';

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
            $this->token
        );

        /**
         * Expect exception thrown
         */
        $this->expectException(Exception::class);
        $ctx->user_pages_id();
    }

    /**
     * Check error handling
     */
    public function test_ig_user_id_error_handling()
    {
        /**
         * Create fake response
         */
        $response = new class () {};
        $response->error = new class () {};
        $response->error->message = 'Something wrong';

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
            $this->token
        );

        /**
         * Expect exception thrown
         */
        $this->expectException(Exception::class);
        $ctx->ig_user_id('');
    }

    /**
     * Check error handling
     */
    public function test_hashtag_id_error_handling()
    {
        /**
         * Create fake response
         */
        $response = new class () {};
        $response->error = new class () {};
        $response->error->message = 'Something wrong';

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
            $this->token
        );

        /**
         * Expect exception thrown
         */
        $this->expectException(Exception::class);
        $ctx->hashtag_id('', '');
    }

    /**
     * Check error handling
     */
    public function test_medias_recent_error_handling()
    {
        /**
         * Create fake response
         */
        $response = new class () {};
        $response->error = new class () {};
        $response->error->message = 'Something wrong';

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
            $this->token
        );

        /**
         * Expect exception thrown
         */
        $this->expectException(Exception::class);
        $ctx->medias_recent('', '');
    }
}
