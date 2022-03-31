<?php
/**
 * The test cases for Albamn_Hskwakr_Ig_Query
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Ig_Query
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Query_Test extends WP_UnitTestCase
{
    private $query;
    private $base = 'base';
    private $token = 'token1234';

    public function setUp()
    {
        $this->query = new Albamn_Hskwakr_Ig_Query(
            $this->base,
            $this->token
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_user_pages()
    {
        $actual = $this->query->user_pages();

        /**
         * Should contain base url
         */
        $this->assertStringContainsStringIgnoringCase(
            $this->base,
            $actual
        );
        /**
         * Should contain access token
         */
        $this->assertStringContainsStringIgnoringCase(
            $this->token,
            $actual
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_ig_user()
    {
        $page_id = 'page1234';
        $actual = $this->query->ig_user($page_id);

        /**
         * Should contain base url
         */
        $this->assertStringContainsStringIgnoringCase(
            $this->base,
            $actual
        );
        /**
         * Should contain access token
         */
        $this->assertStringContainsStringIgnoringCase(
            $this->token,
            $actual
        );
        /**
         * Should contain page id
         */
        $this->assertStringContainsStringIgnoringCase(
            $page_id,
            $actual
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_search_hashtag()
    {
        $user_id = 'user1234';
        $hashtag_name = 'hashtag1234';
        $actual = $this->query->search_hashtag(
            $user_id,
            $hashtag_name
        );

        /**
         * Should contain base url
         */
        $this->assertStringContainsStringIgnoringCase(
            $this->base,
            $actual
        );
        /**
         * Should contain access token
         */
        $this->assertStringContainsStringIgnoringCase(
            $this->token,
            $actual
        );
        /**
         * Should contain user id
         */
        $this->assertStringContainsStringIgnoringCase(
            $user_id,
            $actual
        );
        /**
         * Should contain hashtag name
         */
        $this->assertStringContainsStringIgnoringCase(
            $hashtag_name,
            $actual
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_recent_medias_by_hashtag()
    {
        $user_id = 'user1234';
        $hashtag_id = 'hashtag1234';

        $actual = $this->query->recent_medias_by_hashtag(
            $user_id,
            $hashtag_id
        );

        /**
         * Should contain base url
         */
        $this->assertStringContainsStringIgnoringCase(
            $this->base,
            $actual
        );
        /**
         * Should contain access token
         */
        $this->assertStringContainsStringIgnoringCase(
            $this->token,
            $actual
        );
        /**
         * Should contain user id
         */
        $this->assertStringContainsStringIgnoringCase(
            $user_id,
            $actual
        );
        /**
         * Should contain hashtag id
         */
        $this->assertStringContainsStringIgnoringCase(
            $hashtag_id,
            $actual
        );
    }
}
