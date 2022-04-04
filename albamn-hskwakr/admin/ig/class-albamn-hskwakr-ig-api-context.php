<?php

/**
 * The context for Instagram API.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The context for Instagram API.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Api_Context
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
     * The http client.
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Http_Client    $http
     */
    private $http;

    /**
     * The factory of query strings for the API.
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Query    $query
     */
    private $query;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Ig_Http_Client    $http
     * @param    Albamn_Hskwakr_Ig_Query          $query
     * @param    string                           $token
     */
    public function __construct(
        Albamn_Hskwakr_Ig_Http_Client $http,
        Albamn_Hskwakr_Ig_Query $query,
        string $token
    ) {
        $this->http = $http;
        $this->query = $query;
        $this->access_token = $token;
    }

    /**
     * Print the data as json format
     *
     * @since    1.0.0
     * @param    mixed      $data
     */
    public function print_json($data): void
    {
        echo '<pre>';
        echo json_encode($data, JSON_PRETTY_PRINT);
        echo '</pre>';
    }

    /**
     * Send a http request with query
     *
     * @since    1.0.0
     * @param    string     $query
     * @return   mixed      The response of the http request.
     */
    public function send_request(string $query)
    {
        return $this->http->send($query);
    }

    /**
     * Get Facebook user pages id
     *
     * @since    1.0.0
     * @return   string      The id of the user pages in Facebook.
     */
    public function user_pages_id(): string
    {
        /**
         * Get the response of the request
         * @var object
         */
        $response = $this->send_request(
            $this->query->user_pages()
        );

        /**
         * Check request error
         */
        if (isset($response->error)) {
            $this->error(
                'Failed to get user pages',
                (object)$response->error
            );
        }

        /**
         * @var array<object>
         */
        $data = $response->data;
        return (string)$data[0]->id;
    }

    /**
     * Get the Instagram business account id
     *
     * @since    1.0.0
     * @param    string     $page_id    The user pages id.
     * @return   string     The user id of instagram account.
     */
    public function ig_user_id(string $page_id): string
    {
        /**
         * Get the response of the request
         * @var object
         */
        $response = $this->send_request(
            $this->query->ig_user($page_id)
        );

        /**
         * Check request error
         */
        if (isset($response->error)) {
            $this->error(
                'Failed to get user id',
                (object)$response->error
            );
        }

        /**
         * @var object
         */
        $account = $response->instagram_business_account;
        return (string)$account->id;
    }

    /**
     * Get the hashtag id
     *
     * @since    1.0.0
     * @param    string     $user_id    The instagram account id.
     * @param    string     $hashtag    The hashtag name in instagram.
     * @return   string     The hashtag id.
     */
    public function hashtag_id(
        string $user_id,
        string $hashtag
    ): string {
        /**
         * Get the response of the request
         * @var object
         */
        $response = $this->send_request(
            $this->query->search_hashtag($user_id, $hashtag)
        );

        /**
         * Check request error
         */
        if (isset($response->error)) {
            $this->error(
                'Failed to search hashtag id',
                (object)$response->error
            );
        }

        /**
         * @var array<object>
         */
        $data = $response->data;
        return (string)$data[0]->id;
    }

    /**
     * Get the list of the most recent media objects
     *
     * @since    1.0.0
     * @param    string     $user_id      The instagram account id.
     * @param    string     $hashtag_id   The hashtag id.
     * @return   array      The list of the most recent media objects.
     */
    public function medias_recent(
        string $user_id,
        string $hashtag_id
    ): array {
        /**
         * Get the response of the request
         * @var object
         */
        $response = $this->send_request(
            $this->query->recent_medias_by_hashtag(
                $user_id,
                $hashtag_id
            )
        );

        /**
         * Check request error
         */
        if (isset($response->error)) {
            $this->error(
                'Failed to get recent medias by hashtag',
                (object)$response->error
            );
        }

        /**
         * @var array
         */
        return $response->data;
    }

    /**
     * Validate the response data
     * from user pages request.
     *
     * @since    1.0.0
     * @param    object     $res        The response data.
     * @return   bool       true        The data is expected.
     *                      false       The data is unexpected.
     */
    public function validate_user_pages_response(
        object $res
    ): bool {
        if (!isset($res->data)) {
            return false;
        }
        if (!is_array($res->data)) {
            return false;
        }
        if (!isset($res->data[0])) {
            return false;
        }
        if (!is_object($res->data[0])) {
            return false;
        }
        if (!isset($res->data[0]->id)) {
            return false;
        }
        if (!is_string($res->data[0]->id)) {
            return false;
        }

        return true;
    }

    /**
     * Validate the response data
     * from ig user request.
     *
     * @since    1.0.0
     * @param    object     $res        The response data.
     * @return   bool       true        The data is expected.
     *                      false       The data is unexpected.
     */
    public function validate_ig_user_response(
        object $res
    ): bool {
        if (!isset($res->instagram_business_account)) {
            return false;
        }
        if (!is_object($res->instagram_business_account)) {
            return false;
        }
        if (!isset($res->instagram_business_account->id)) {
            return false;
        }
        if (!is_string($res->instagram_business_account->id)) {
            return false;
        }

        return true;
    }

    /**
     * Validate the response data
     * from search hashtag request.
     *
     * @since    1.0.0
     * @param    object     $res        The response data.
     * @return   bool       true        The data is expected.
     *                      false       The data is unexpected.
     */
    public function validate_search_hashtag_response(
        object $res
    ): bool {
        if (!isset($res->data)) {
            return false;
        }
        if (!is_array($res->data)) {
            return false;
        }
        if (!isset($res->data[0])) {
            return false;
        }
        if (!is_object($res->data[0])) {
            return false;
        }
        if (!isset($res->data[0]->id)) {
            return false;
        }
        if (!is_string($res->data[0]->id)) {
            return false;
        }

        return true;
    }

    /**
     * Validate the response data
     * from recent medias by hashtag request.
     *
     * @since    1.0.0
     * @param    object     $res        The response data.
     * @return   bool       true        The data is expected.
     *                      false       The data is unexpected.
     */
    public function validate_recent_medias_by_hashtag_response(
        object $res
    ): bool {
        if (!isset($res->data)) {
            return false;
        }
        if (!is_array($res->data)) {
            return false;
        }
        if (!isset($res->data[0])) {
            return false;
        }
        if (!is_object($res->data[0])) {
            return false;
        }
        if (!isset($res->data[0]->media_type)) {
            return false;
        }
        if (!is_string($res->data[0]->media_type)) {
            return false;
        }

        return true;
    }

    /**
     * Error handling
     * Throw exception with error message
     *
     * @since    1.0.0
     * @param    string     $msg      The message.
     * @param    object     $error    The object that has message prop.
     */
    private function error(
        string $msg,
        object $error=null
    ): void {
        /**
         * Create an error based on args
         */
        if (isset($error->message)) {
            throw new Exception(
                $msg . ': ' . (string)$error->message,
            );
        } else {
            throw new Exception($msg);
        }
    }
}
