<?php

/**
 * The permanent data access for instagram posts
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The permanent data access for instagram posts
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Post_Repository
{
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $albamn_hskwakr    The name of the plugin.
     */
    public function __construct($albamn_hskwakr)
    {
        $this->albamn_hskwakr = $albamn_hskwakr;
    }

    /**
     * Save Instagram post to DB
     *
     * @since    1.0.0
     * @param    string    $albamn_hskwakr    The name of the plugin.
     */
    public function save(
        Albamn_Hskwakr_Ig_Post $post
    ) {
        // wp_insert_post
        // add_post_meta
    }
}
