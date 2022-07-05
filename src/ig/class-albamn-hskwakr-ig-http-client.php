<?php

/**
 * The client for http access.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The client for http access.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Http_Client
{
    /**
     * Send a http request.
     *
     * @since    1.0.0
     * @param    string     $query
     * @return   mixed      The response of the http request.
     */
    public function send(string $query)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $query);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $r = (string)curl_exec($curl);
        curl_close($curl);

        return json_decode($r);
    }
}
