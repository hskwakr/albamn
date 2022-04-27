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
        $correct_image->media_url = 'url1234';
        $correct_image->permalink = 'link1234';
        $correct_image->id = 'id1234';

        $correct_video = new class () {};
        $correct_video->media_type = 'VIDEO';
        $correct_video->media_url = 'url1234';
        $correct_video->permalink = 'link1234';
        $correct_video->id = 'id1234';

        $this->medias_correct = array(
            'image' => $correct_image,
            'video' => $correct_video
        );

        /**
         * Prepare fake data
         * Wrong values
         */
        $wrong_type = new class () {};
        $wrong_type->media_type = 'OTHER';
        $wrong_type->media_url = 'url1234';
        $wrong_type->permalink = 'link1234';
        $wrong_type->id = 'id1234';

        $wrong_prop_1 = new class () {};
        $wrong_prop_1->media_type = 'IMAGE';
        $wrong_prop_1->media_url = '';
        $wrong_prop_1->permalink = 'link1234';
        $wrong_prop_1->id = 'id1234';

        $wrong_prop_2 = new class () {};
        $wrong_prop_2->media_type = 'IMAGE';
        $wrong_prop_2->media_url = '';
        $wrong_prop_2->permalink = 'link1234';
        $wrong_prop_2->id = 'id1234';

        $wrong_prop_3 = new class () {};
        $wrong_prop_3->media_type = 'IMAGE';
        $wrong_prop_3->media_url = 'url1234';
        $wrong_prop_3->permalink = 'link1234';
        $wrong_prop_3->id = '';

        $this->medias_wrong = array(
            'type' => $wrong_type,
            'lack_of_type' => $wrong_prop_1,
            'lack_of_url' => $wrong_prop_2,
            'lack_of_id' => $wrong_prop_3
        );
    }

    /**
     * Check the return value has expected structure
     */
    public function test_validate()
    {
        /**
         * Asset: Propper case
         */
        $post = new Albamn_Hskwakr_Ig_Post(
            $this->medias_correct['image']->id,
            $this->medias_correct['image']->media_type,
            $this->medias_correct['image']->media_url,
            $this->medias_correct['image']->permalink
        );
        $actual = $post->validate();
        $this->assertTrue($actual);

        /**
         * Asset: Propper case
         */
        $post = new Albamn_Hskwakr_Ig_Post(
            $this->medias_correct['video']->id,
            $this->medias_correct['video']->media_type,
            $this->medias_correct['video']->media_url,
            $this->medias_correct['video']->permalink
        );
        $actual = $post->validate();
        $this->assertTrue($actual);

        /**
         * Asset: Wrong case
         * The media_type should be IMAGE or VIDEO
         */
        $post = new Albamn_Hskwakr_Ig_Post(
            $this->medias_wrong['type']->id,
            $this->medias_wrong['type']->media_type,
            $this->medias_wrong['type']->media_url,
            $this->medias_wrong['type']->permalink
        );
        $actual = $post->validate();
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have media_type
         */
        $post = new Albamn_Hskwakr_Ig_Post(
            $this->medias_wrong['lack_of_type']->id,
            $this->medias_wrong['lack_of_type']->media_type,
            $this->medias_wrong['lack_of_type']->media_url,
            $this->medias_wrong['lack_of_type']->permalink
        );
        $actual = $post->validate();
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have media_url
         */
        $post = new Albamn_Hskwakr_Ig_Post(
            $this->medias_wrong['lack_of_url']->id,
            $this->medias_wrong['lack_of_url']->media_type,
            $this->medias_wrong['lack_of_url']->media_url,
            $this->medias_wrong['lack_of_url']->permalink
        );
        $actual = $post->validate();
        $this->assertFalse($actual);

        /**
         * Asset: Wrong case
         * The object does not have id
         */
        $post = new Albamn_Hskwakr_Ig_Post(
            $this->medias_wrong['lack_of_id']->id,
            $this->medias_wrong['lack_of_id']->media_type,
            $this->medias_wrong['lack_of_id']->media_url,
            $this->medias_wrong['lack_of_id']->permalink
        );
        $actual = $post->validate();
        $this->assertFalse($actual);
    }
}
