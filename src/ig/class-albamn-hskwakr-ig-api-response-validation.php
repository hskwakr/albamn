<?php

/**
 * The validation for response from Instagram API.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The validation for response from Instagram API.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Api_Response_Validation
{
    /**
     * Validate the response data
     * from user pages request.
     *
     * @since    1.0.0
     * @param    object     $res        The response data.
     * @return   bool       true        The data is expected.
     *                      false       The data is unexpected.
     */
    public function validate_user_pages(
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
    public function validate_ig_user(
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
    public function validate_search_hashtag(
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
    public function validate_medias_by_hashtag(
        object $res
    ): bool {
        if (!isset($res->data)) {
            return false;
        }
        if (!is_array($res->data)) {
            return false;
        }

        foreach ($res->data as $v) {
            if (!is_object($v)) {
                return false;
            }
            if (!isset($v->media_type)) {
                return false;
            }
            if (!is_string($v->media_type)) {
                return false;
            }
        }

        return true;
    }
}
