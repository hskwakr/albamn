<?php

/**
 * The query for Instagram API.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The query for Instagram API.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Query
{
    /**
     * The access token of the Facebook app.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $access_token
     */
    private $access_token;

    /**
     * The base url of the Facebook API.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $base_url
     */
    private $base_url;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $base_url
     * @param    string    $token
     */
    public function __construct(
        string $base_url,
        string $token
    ) {
        $this->base_url = $base_url;
        $this->access_token = $token;
    }

    /**
     * The query string to get user pages info.
     *
     * @since    1.0.0
     * @return   string    The query string.
     */
    public function user_pages(): string
    {
        $endpoint = '/me/accounts?';
        $options =
        'access_token=' . $this->access_token;

        $query = $this->base_url . $endpoint . $options;
        return $query;
    }

    /**
     * The query string to get instagram user info.
     *
     * @since    1.0.0
     * @param    string    $id    The user pages id.
     * @return   string    The query string.
     */
    public function ig_user(string $id): string
    {
        $endpoint = '/' . $id . '?';
        $options =
        'access_token=' . $this->access_token .
        '&fields=instagram_business_account';

        $query = $this->base_url . $endpoint . $options;
        return $query;
    }

    /**
     * The query string to get hashtag info.
     *
     * @since    1.0.0
     * @param    string    $id         The instagram user id.
     * @param    string    $name       The name of the hashtag.
     * @return   string    The query string.
     */
    public function search_hashtag(
        string $id,
        string $name
    ): string {
        $endpoint = '/ig_hashtag_search?';
        $options =
        'access_token=' . $this->access_token .
        '&user_id=' . $id .
        '&q=' . $name;

        $query = $this->base_url . $endpoint . $options;
        return $query;
    }

    /**
     * The query string to get recent posts
     * searched by hashtag in instagram.
     *
     * @since    1.0.0
     * @param    string    $user       The instagram user id.
     * @param    string    $hashtag    The hashtag id.
     * @return   string    The query string.
     */
    public function recent_medias_by_hashtag(
        string $user,
        string $hashtag
    ): string {
        $endpoint = '/' . $hashtag . '/recent_media?';
        $options =
        'access_token=' . $this->access_token .
        '&user_id=' . $user .
        '&limit=' . '50' .
        '&fields=media_type,media_url,permalink,children{media_type,media_url}';

        $query = $this->base_url . $endpoint . $options;
        return $query;
    }

    /**
     * The query string to get top posts
     * searched by hashtag in instagram.
     *
     * @since    1.0.0
     * @param    string    $user       The instagram user id.
     * @param    string    $hashtag    The hashtag id.
     * @return   string    The query string.
     */
    public function top_medias_by_hashtag(
        string $user,
        string $hashtag
    ): string {
        $endpoint = '/' . $hashtag . '/top_media?';
        $options =
        'access_token=' . $this->access_token .
        '&user_id=' . $user .
        '&limit=' . '50' .
        '&fields=media_type,media_url,permalink,children{media_type,media_url}';

        $query = $this->base_url . $endpoint . $options;
        return $query;
    }
}
