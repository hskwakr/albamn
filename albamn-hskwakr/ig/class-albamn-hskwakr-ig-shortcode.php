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
class Albamn_Hskwakr_Ig_Shortcode
{
    /**
     * The DB access for Instagram posts
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Ig_Post_Repository    $repository
     */
    private $repository;

    /**
     * The formatter for Instagram medias
     *
     * @since    1.0.0
     * @access   private
     * @var      Albamn_Hskwakr_Admin_Ig_Formatter    $formatter
     */
    private $formatter;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    Albamn_Hskwakr_Ig_Post_Repository    $repository
     * @param    Albamn_Hskwakr_Admin_Ig_Formatter    $formatter
     */
    public function __construct(
        Albamn_Hskwakr_Ig_Post_Repository $repository,
        Albamn_Hskwakr_Admin_Ig_Formatter $formatter
    ) {
        $this->repository = $repository;
        $this->formatter = $formatter;
    }

    /**
     * Run the shortcode
     * to display list of Instagram posts
     *
     * @since    1.0.0
     * @return   string
     */
    public function run(): string
    {
        /**
         * Get Instagram posts
         *
         * @var array<Albamn_Hskwakr_Ig_Post> $posts
         */
        $posts = $this->get_all_posts();

        /**
         * Formatt Instagram posts to HTML
         */
        return $this->format_posts($posts);
    }

    /**
     * Get all Instagram posts
     *
     * @since    1.0.0
     * @return   array<Albamn_Hskwakr_Ig_Post>
     */
    public function get_all_posts(): array
    {
        /**
         * @var array<Albamn_Hskwakr_Ig_Post>
         */
        return $this->repository->get(-1);
    }

    /**
     * Formatt Instagram posts data to HTML
     *
     * @since    1.0.0
     * @param    array<Albamn_Hskwakr_Ig_Post>    $posts
     * @return   string
     */
    public function format_posts(array $posts): string
    {
        /**
         * Validate the posts
         */
        if (!$this->formatter->validate_medias($posts)) {
            return 'Filed to format';
        }

        /**
         * Format the posts
         */
        return $this->formatter->format_medias_importer($posts);
    }
}
