<?php

/**
 * The list of the pagers for the plugin admin.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 */

/**
 * The list of the pagers for the plugin admin.
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Pager_List
{
    /**
     * The list of the pagers
     *
     * @since    1.0.0
     * @access   private
     * @var      array<string, Albamn_Hskwakr_Admin_Displayable>   $list
     */
    private $list;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->list = array();
    }

    /**
     * Add a pager to the list
     *
     * @since    1.0.0
     * @param    string     $name
     * @param    Albamn_Hskwakr_Admin_Displayable     $pager
     */
    public function add(
        string $name,
        Albamn_Hskwakr_Admin_Displayable $pager
    ): void {
    }

    /**
     * Add a pager to the list
     *
     * @since    1.0.0
     * @return   array<string, Albamn_Hskwakr_Admin_Displayable>
     */
    public function get(
    ): array {
        return $this->list;
    }

    /**
     * Find pager in list by name
     *
     * @since    1.0.0
     * @param    string     $name
     * @return   Albamn_Hskwakr_Admin_Displayable | null
     */
    public function find_by(
        string $name
    ) {
        return null;
    }
}
