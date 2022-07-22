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
     * The validation for response from Instagram API
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Api_Response_Validation    $validation
     */
    private $validation;

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
        Albamn_Hskwakr_Ig_Api_Response_Validation $validation,
        string $token
    ) {
        $this->http = $http;
        $this->query = $query;
        $this->validation = $validation;
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
        $error = 'Failed to get user pages';

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
                $error,
                (object)$response->error
            );
        }

        /**
         * Validate the response
         */
        if (!$this->validation->validate_user_pages($response)) {
            $this->error(
                $error . ': Unexpected response'
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
        $error = 'Failed to get user id';

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
                $error,
                (object)$response->error
            );
        }

        /**
         * Validate the response
         */
        if (!$this->validation->validate_ig_user($response)) {
            $this->error(
                $error . ': Unexpected response'
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
        $error = 'Failed to search hashtag id';

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
                $error,
                (object)$response->error
            );
        }

        /**
         * Validate the response
         */
        if (!$this->validation->validate_search_hashtag($response)) {
            $this->error(
                $error . ': Unexpected response'
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
        string $hashtag_id,
        int $max = 200
    ): array {
        /**
         * The list of media objects.
         */
        $medias = array();

        /**
         * Error message
         */
        $error = 'Failed to get recent medias by hashtag';

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
                $error,
                (object)$response->error
            );
        }

        /**
         * Validate the response
         */
        if (!$this->validation->validate_medias_by_hashtag($response)) {
            $this->error(
                $error . ': Unexpected response'
            );
        }

        /**
         * Set medias
         *
         * @var array $response->data
         */
        $medias = $response->data;

        /**
         * Check request paging
         */
        //if ($this->check_paging_field($response)) {
        //    /**
        //     * Get next page medias
        //     *
        //     * @var object $response->paging
        //     * @var string $response->paging->next
        //     */
        //    $result = $this->medias_next(
        //        $response->paging->next,
        //        $max,
        //        count($medias)
        //    );

        //    /**
        //     * Set medias
        //     */
        //    $medias = array_merge($medias, $result);
        //}

        return $medias;
    }

    /**
     * Get the list of the most top media objects
     *
     * @since    1.0.0
     * @param    string     $user_id      The instagram account id.
     * @param    string     $hashtag_id   The hashtag id.
     * @return   array      The list of the most top media objects.
     */
    public function medias_top(
        string $user_id,
        string $hashtag_id,
        int $max = 200
    ): array {
        /**
         * The list of media objects.
         */
        $medias = array();

        /**
         * Error message
         */
        $error = 'Failed to get top medias by hashtag';

        /**
         * Get the response of the request
         * @var object
         */
        $response = $this->send_request(
            $this->query->top_medias_by_hashtag(
                $user_id,
                $hashtag_id
            )
        );

        /**
         * Check request error
         */
        if (isset($response->error)) {
            $this->error(
                $error,
                (object)$response->error
            );
        }

        /**
         * Validate the response
         */
        if (!$this->validation->validate_medias_by_hashtag($response)) {
            $this->error(
                $error . ': Unexpected response'
            );
        }

        /**
         * Set medias
         *
         * @var array $response->data
         */
        $medias = $response->data;

        /**
         * Check request paging
         */
        //if ($this->check_paging_field($response)) {
        //    /**
        //     * Get next page medias
        //     *
        //     * @var object $response->paging
        //     * @var string $response->paging->next
        //     */
        //    $result = $this->medias_next(
        //        $response->paging->next,
        //        $max,
        //        count($medias)
        //    );

        //    /**
        //     * Set medias
        //     */
        //    $medias = array_merge($medias, $result);
        //}

        return $medias;
    }

    /**
     * Get the list of the next media objects
     *
     * @since    1.0.0
     * @param    string     $next      The instagram account id.
     * @param    int        $max       The max amount of posts to get.
     * @param    int        $count     The current amount of posts.
     * @return   array      The list of next page media objects.
     */
    public function medias_next(
        string $query,
        int $max,
        int $count
    ): array {
        /**
         * The list of media objects.
         */
        $medias = array();

        /**
         * Error message
         */
        $error = 'Failed to get next medias by hashtag';

        /**
         * Get the response of the request
         * @var object
         */
        $response = $this->send_request(
            $query
        );

        /**
         * Check request error
         */
        if (isset($response->error)) {
            $this->error(
                $error,
                (object)$response->error
            );
        }

        /**
         * Validate the response
         */
        if (!$this->validation->validate_medias_by_hashtag($response)) {
            $this->error(
                $error . ': Unexpected response'
            );
        }

        /**
         * Set medias
         *
         * @var array $response->data
         */
        $medias = $response->data;

        /**
         * Calc current amount we have
         */
        $current_amount = $count + count($medias);

        /**
         * Calc the amount to remove
         */
        $remove_amount = $current_amount - $max;
        if ($remove_amount > 0) {
            /**
             * Remove elements from the array
             */
            for ($i = 0; $i < $remove_amount; $i++) {
                array_pop($medias);
            }

            return $medias;
        }

        /**
         * Check request paging
         */
        if ($this->check_paging_field($response)) {
            /**
             * Get next page medias
             *
             * @var object $response->paging
             * @var string $response->paging->next
             */
            $result = $this->medias_next(
                $response->paging->next,
                $max,
                $current_amount
            );

            /**
             * Set medias
             */
            $medias = array_merge($medias, $result);
        }

        return $medias;
    }

    /**
     * Check the paging field in the response data
     *
     * @since    1.0.0
     * @param    object     $res        The response data.
     * @return   bool       true        The data is expected.
     *                      false       The data is unexpected.
     */
    public function check_paging_field(
        object $res
    ): bool {
        if (!isset($res->paging)) {
            return false;
        }
        if (!is_object($res->paging)) {
            return false;
        }
        if (!isset($res->paging->next)) {
            return false;
        }
        if (!is_string($res->paging->next)) {
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
