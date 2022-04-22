<?php
/**
 * The test cases for Albamn_Hskwakr_Admin_Cpt
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 */

/**
 * The test cases for Albamn_Hskwakr_Admin_Cpt
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Cpt_Test extends WP_UnitTestCase
{
    private $cpt;
    private $id;
    private $version;

    public function setUp()
    {
        $this->id = 'id-1234';
        $this->version = 'version1234';
        $this->cpt = new Albamn_Hskwakr_Admin_Cpt(
            $this->id,
            $this->version
        );
    }

    /**
     * Check the return has correct structure.
     */
    public function test_hyphen_to_underbar()
    {
        /**
         * Prepare
         */
        $expect = 'id_1234';

        /**
         * Execute
         */
        $actual = $this->cpt->hyphen_to_underbar(
            $this->id
        );

        /**
         * Assert
         */
        $this->assertSame($expect, $actual);
    }
}

/**
 * The test cases for Albamn_Hskwakr_Admin_Cpt_Arg
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Cpt_Arg_Test extends WP_UnitTestCase
{
    private $arg;

    public function setUp()
    {
        /**
         * Create mock
         */
        $labels = $this->createMock(
            Albamn_Hskwakr_Admin_Cpt_Label::class
        );
        $supports = $this->createMock(
            Albamn_Hskwakr_Admin_Cpt_Support::class
        );

        /**
         * Instantiate
         */
        $this->arg = new Albamn_Hskwakr_Admin_Cpt_Arg(
            $labels,
            $supports,
            '',
            '',
            array(),
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true
        );
    }

    /**
     * Check the return value has expected structure
     */
    public function test_get_array()
    {
        /**
         * Prepare
         */
        $check = function (string $target, array $list): bool {
            /**
             * Check if there is a same name as $target in the array.
             *
             * true:  expected
             * false: unexpected
             */
            $flag = false;

            foreach ($list as $value) {
                if ($value == $target) {
                    $flag = true;
                    break;
                }
            }

            return $flag;
        };
        $props = get_class_vars(get_class($this->arg));
        $props = array_keys($props);

        /**
         * Execute
         */
        $arr = $this->arg->get_array();
        $arr = array_keys($arr);

        /**
         * Assert
         * Check the array keys are equivalent to class properties
         */
        $flag = true;
        foreach ($arr as $value) {
            if (!$check($value, $props)) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);

        /**
         * Assert
         * Check the class properties are equivalent to array keys
         */
        $flag = true;
        foreach ($props as $value) {
            if (!$check($value, $arr)) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);
    }

    /**
     * Check the return value has expected structure
     */
    public function test_get_array_should_have_only_string_keys()
    {
        /**
         * Execute
         */
        $arr = $this->arg->get_array();
        $keys = array_keys($arr);

        /**
         * Assert
         */
        $flag = true;
        foreach ($keys as $value) {
            if (!is_string($value)) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);
    }
}

/**
 * The test cases for Albamn_Hskwakr_Admin_Cpt_Label
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Cpt_Label_Test extends WP_UnitTestCase
{
    private $label;

    public function setUp()
    {
        /**
         * Instantiate
         */
        $this->label = new Albamn_Hskwakr_Admin_Cpt_Label(
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        );
    }

    /**
     * Check the return value has expected structure
     */
    public function test_get_array()
    {
        /**
         * Prepare
         */
        $check = function (string $target, array $list): bool {
            /**
             * Check if there is a same name as $target in the array.
             *
             * true:  expected
             * false: unexpected
             */
            $flag = false;

            foreach ($list as $value) {
                if ($value == $target) {
                    $flag = true;
                    break;
                }
            }

            return $flag;
        };
        $props = get_class_vars(get_class($this->label));
        $props = array_keys($props);

        /**
         * Execute
         */
        $arr = $this->label->get_array();
        $arr = array_keys($arr);

        /**
         * Assert
         * Check the array keys are equivalent to class properties
         */
        $flag = true;
        foreach ($arr as $value) {
            if (!$check($value, $props)) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);

        /**
         * Assert
         * Check the class properties are equivalent to array keys
         */
        $flag = true;
        foreach ($props as $value) {
            if (!$check($value, $arr)) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);
    }

    /**
     * Check the return value has expected structure
     */
    public function test_get_array_should_have_only_string_keys()
    {
        /**
         * Execute
         */
        $arr = $this->label->get_array();
        $keys = array_keys($arr);

        /**
         * Assert
         */
        $flag = true;
        foreach ($keys as $value) {
            if (!is_string($value)) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);
    }
}

/**
 * The test cases for Albamn_Hskwakr_Admin_Cpt_Support
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/tests
 * @author     hskwakr <33633391+hskwakr@users.noreply.github.com>
 */
class Albamn_Hskwakr_Admin_Cpt_Support_Test extends WP_UnitTestCase
{
    private $support;

    public function setUp()
    {
        /**
         * Instantiate
         */
        $this->support = new Albamn_Hskwakr_Admin_Cpt_Support(
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true
        );
    }

    /**
     * Check the return value has expected structure
     */
    public function test_get_array()
    {
        /**
         * Prepare
         */
        $check = function (string $target, array $list): bool {
            /**
             * Check if there is a same name as $target in the array.
             *
             * true:  expected
             * false: unexpected
             */
            $flag = false;

            foreach ($list as $value) {
                if ($value == $target) {
                    $flag = true;
                    break;
                }
            }

            return $flag;
        };
        $props = get_class_vars(get_class($this->support));
        $props = array_keys($props);
        $props = str_replace('_', '-', $props);

        /**
         * Execute
         * with every true param as constractor
         */
        $arr = $this->support->get_array();

        /**
         * Assert
         * Check the array keys are equivalent to class properties
         */
        $flag = true;
        foreach ($arr as $value) {
            if (!$check($value, $props)) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);

        /**
         * Assert
         * Check the class properties are equivalent to array keys
         */
        $flag = true;
        foreach ($props as $value) {
            if (!$check($value, $arr)) {
                $flag = false;
                break;
            }
        }
        $this->assertTrue($flag);
    }
}
