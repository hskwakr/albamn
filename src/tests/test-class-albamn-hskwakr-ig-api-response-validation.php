<?php
/**
 * The test cases for Albamn_Hskwakr_Ig_Api_Response_Validation
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Ig_Api_Response_Validation
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Api_Response_Validation_Test extends WP_UnitTestCase
{
    private $token = 'token1234';
    private $pages_id = 'page1234';
    private $user_id = 'user1234';
    private $hashtag_name = 'hashtagname1234';
    private $hashtag_id = 'hashtagid1234';
    private $media;

    public function setUp()
    {
        /**
         * Init fake values
         */
        $this->media = new class () {};
        $this->media->media_type = 'type1234';
        $this->media->media_url = 'url1234';
        $this->media->permalink = 'link1234';
        $this->media->id = 'id1234';
    }

    /**
     * Check the return has correct value.
     */
    public function test_validate_user_pages()
    {
        /**
         * Init validation class
         */
        $validation = new Albamn_Hskwakr_Ig_Api_Response_Validation();

        /**
         * Assert proper case:
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0]->id = $this->pages_id;
        $actual = $validation->validate_user_pages($response);
        $this->assertTrue($actual);

        /**
         * Assert wrong case:
         * id is not string
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0]->id = new class () {};
        $actual = $validation->validate_user_pages($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * does not have id
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $actual = $validation->validate_user_pages($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * missing array element
         */
        $response = new class () {};
        $response->data = array();
        $actual = $validation->validate_user_pages($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * data is not array
         */
        $response = new class () {};
        $response->data = new class () {};
        $actual = $validation->validate_user_pages($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * does not have data
         */
        $response = new class () {};
        $actual = $validation->validate_user_pages($response);
        $this->assertFalse($actual);
    }

    /**
     * Check the return has correct value.
     */
    public function test_validate_ig_user()
    {
        /**
         * Init validation class
         */
        $validation = new Albamn_Hskwakr_Ig_Api_Response_Validation();

        /**
         * Assert proper case:
         */
        $response = new class () {};
        $response->instagram_business_account = new class () {};
        $response->instagram_business_account->id = $this->user_id;
        $actual = $validation->validate_ig_user($response);
        $this->assertTrue($actual);

        /**
         * Assert wrong case:
         * id is not string
         */
        $response = new class () {};
        $response->instagram_business_account = new class () {};
        $response->instagram_business_account->id = new class () {};
        $actual = $validation->validate_ig_user($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * does not have id
         */
        $response = new class () {};
        $response->instagram_business_account = new class () {};
        $actual = $validation->validate_ig_user($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * instagram_business_account is not object
         */
        $response = new class () {};
        $response->instagram_business_account = '';
        $actual = $validation->validate_ig_user($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * does not have instagram_business_account
         */
        $response = new class () {};
        $actual = $validation->validate_ig_user($response);
        $this->assertFalse($actual);
    }

    /**
     * Check the return has correct value.
     */
    public function test_validate_search_hashtag()
    {
        /**
         * Init validation class
         */
        $validation = new Albamn_Hskwakr_Ig_Api_Response_Validation();

        /**
         * Assert proper case:
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0]->id = $this->pages_id;
        $actual = $validation->validate_search_hashtag($response);
        $this->assertTrue($actual);

        /**
         * Assert wrong case:
         * id is not string
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0]->id = new class () {};
        $actual = $validation->validate_search_hashtag($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * does not have id
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $actual = $validation->validate_search_hashtag($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * missing array element
         */
        $response = new class () {};
        $response->data = array();
        $actual = $validation->validate_search_hashtag($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * data is not array
         */
        $response = new class () {};
        $response->data = new class () {};
        $actual = $validation->validate_search_hashtag($response);
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * does not have data
         */
        $response = new class () {};
        $actual = $validation->validate_search_hashtag($response);
        $this->assertFalse($actual);
    }

    /**
     * Check the return has correct value.
     */
    public function test_validate_medias_by_hashtag()
    {
        /**
         * Init validation class
         */
        $validation = new Albamn_Hskwakr_Ig_Api_Response_Validation();

        /**
         * Assert proper case:
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0] = $this->media;
        $actual = $validation->validate_medias_by_hashtag(
            $response
        );
        $this->assertTrue($actual);

        /**
         * Assert proper case:
         * data is empty
         */
        $response = new class () {};
        $response->data = array();
        $actual = $validation->validate_medias_by_hashtag(
            $response
        );
        $this->assertTrue($actual);

        /**
         * Assert wrong case:
         * media_type is not string
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $response->data[0] = $this->media;
        $response->data[0]->media_type = new class () {};
        $actual = $validation->validate_medias_by_hashtag(
            $response
        );
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * does not have media_type
         */
        $response = new class () {};
        $response->data = array(new class () {});
        $actual = $validation->validate_medias_by_hashtag(
            $response
        );
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * data is not array
         */
        $response = new class () {};
        $response->data = new class () {};
        $actual = $validation->validate_medias_by_hashtag(
            $response
        );
        $this->assertFalse($actual);

        /**
         * Assert wrong case:
         * does not have data
         */
        $response = new class () {};
        $actual = $validation->validate_medias_by_hashtag(
            $response
        );
        $this->assertFalse($actual);
    }
}
