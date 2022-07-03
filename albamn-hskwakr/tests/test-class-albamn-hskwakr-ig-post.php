<?php
/**
 * The test cases for Albamn_Hskwakr_Ig_Post
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Ig_Post
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Ig_Post_Test extends WP_UnitTestCase
{
    private $medias_correct;
    private $medias_wrong;

    public function setUp()
    {
        /**
         * Prepare fake data
         * Correct values
         */
        $correct_image = new class () {};
        $correct_image->media_type = 'IMAGE';
        $correct_image->media_type_list = array();
        $correct_image->media_url = 'url1234';
        $correct_image->media_url_list = array();
        $correct_image->permalink = 'link1234';
        $correct_image->id = 'id1234';
        $correct_image->visibility = true;

        $correct_video = new class () {};
        $correct_video->media_type = 'VIDEO';
        $correct_video->media_type_list = array();
        $correct_video->media_url = 'url1234';
        $correct_video->media_url_list = array();
        $correct_video->permalink = 'link1234';
        $correct_video->id = 'id1234';
        $correct_video->visibility = true;

        $correct_album = new class () {};
        $correct_album->media_type = 'CAROUSEL_ALBUM';
        $correct_album->media_type_list = array('IMAGE');
        $correct_album->media_url = '';
        $correct_album->media_url_list = array('list1234');
        $correct_album->permalink = 'link1234';
        $correct_album->id = 'id1234';
        $correct_album->visibility = true;

        $this->medias_correct = array(
            'image' => $correct_image,
            'video' => $correct_video,
            'album' => $correct_album
        );

        /**
         * Prepare fake data
         * Wrong values
         */
        $wrong_type = new class () {};
        $wrong_type->media_type = 'OTHER';
        $wrong_type->media_type_list = array();
        $wrong_type->media_url = 'url1234';
        $wrong_type->media_url_list = array();
        $wrong_type->permalink = 'link1234';
        $wrong_type->id = 'id1234';
        $wrong_type->visibility = true;

        $wrong_prop_1 = new class () {};
        $wrong_prop_1->media_type = 'IMAGE';
        $wrong_prop_1->media_type_list = array();
        $wrong_prop_1->media_url = '';
        $wrong_prop_1->media_url_list = array();
        $wrong_prop_1->permalink = 'link1234';
        $wrong_prop_1->id = 'id1234';
        $wrong_prop_1->visibility = true;

        $wrong_prop_2 = new class () {};
        $wrong_prop_2->media_type = 'IMAGE';
        $wrong_prop_2->media_type_list = array();
        $wrong_prop_2->media_url = '';
        $wrong_prop_2->media_url_list = array();
        $wrong_prop_2->permalink = 'link1234';
        $wrong_prop_2->id = 'id1234';
        $wrong_prop_2->visibility = true;

        $wrong_prop_3 = new class () {};
        $wrong_prop_3->media_type = 'IMAGE';
        $wrong_prop_3->media_type_list = array();
        $wrong_prop_3->media_url = 'url1234';
        $wrong_prop_3->media_url_list = array();
        $wrong_prop_3->permalink = 'link1234';
        $wrong_prop_3->id = '';
        $wrong_prop_3->visibility = true;

        $wrong_prop_4 = new class () {};
        $wrong_prop_4->media_type = 'CAROUSEL_ALBUM';
        $wrong_prop_4->media_type_list = array('IMAGE');
        $wrong_prop_4->media_url = '';
        $wrong_prop_4->media_url_list = array();
        $wrong_prop_4->permalink = 'link1234';
        $wrong_prop_4->id = '';
        $wrong_prop_4->visibility = true;

        $wrong_prop_5 = new class () {};
        $wrong_prop_5->media_type = 'CAROUSEL_ALBUM';
        $wrong_prop_5->media_type_list = array();
        $wrong_prop_5->media_url = '';
        $wrong_prop_5->media_url_list = array('url1234');
        $wrong_prop_5->permalink = 'link1234';
        $wrong_prop_5->id = '';
        $wrong_prop_5->visibility = true;

        $this->medias_wrong = array(
            'type' => $wrong_type,
            'lack_of_type' => $wrong_prop_1,
            'lack_of_url' => $wrong_prop_2,
            'lack_of_id' => $wrong_prop_3,
            'lack_of_url_list' => $wrong_prop_4,
            'lack_of_type_list' => $wrong_prop_5,
        );
    }

    /**
     * Check the return value has expected structure
     */
    public function test_validate()
    {
        /**
         * Prepare
         */
        $create_post = function (object $arg) {
            return new Albamn_Hskwakr_Ig_Post(
                $arg->id,
                $arg->media_type,
                $arg->media_type_list,
                $arg->media_url,
                $arg->media_url_list,
                $arg->permalink,
                $arg->visibility
            );
        };

        /**
         * Asset: Propper case
         */
        $post = $create_post(
            $this->medias_correct['image']
        );
        $actual = $post->validate();
        $this->assertTrue($actual);

        /**
         * Asset: Propper case
         */
        $post = $create_post(
            $this->medias_correct['video']
        );
        $actual = $post->validate();
        $this->assertTrue($actual);

        /**
         * Asset: Propper case
         */
        $post = $create_post(
            $this->medias_correct['album']
        );
        $actual = $post->validate();
        $this->assertTrue($actual);

        /**
         * Asset: Wrong case
         * The media_type should be IMAGE or VIDEO
         */
        $post = $create_post(
            $this->medias_wrong['type']
        );
        $actual = $post->validate();
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have media_type
         */
        $post = $create_post(
            $this->medias_wrong['lack_of_type']
        );
        $actual = $post->validate();
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have media_url
         */
        $post = $create_post(
            $this->medias_wrong['lack_of_url']
        );
        $actual = $post->validate();
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have media_url_list
         */
        $post = $create_post(
            $this->medias_wrong['lack_of_url_list']
        );
        $actual = $post->validate();
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have id
         */
        $post = $create_post(
            $this->medias_wrong['lack_of_id']
        );
        $actual = $post->validate();
        $this->assertFalse($actual);
    }
}
