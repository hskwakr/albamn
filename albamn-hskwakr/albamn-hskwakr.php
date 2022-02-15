<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/hskwakr/albamn
 * @since             1.0.0
 * @package           Albamn_Hskwakr
 *
 * @wordpress-plugin
 * Plugin Name:       albamn
 * Plugin URI:        https://github.com/hskwakr/albamn
 * Description:       Make a list of instagram posts searched by hashtag
 * Version:           1.0.0
 * Author:            hskwakr
 * Author URI:        https://github.com/hskwakr
 * License:           MIT
 * License URI:       https://github.com/hskwakr/albamn
 * Text Domain:       albamn-hskwakr
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('ALBAMN_HSKWAKR_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-albamn-hskwakr-activator.php
 */
function activate_albamn_hskwakr()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-albamn-hskwakr-activator.php';
    Albamn_Hskwakr_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-albamn-hskwakr-deactivator.php
 */
function deactivate_albamn_hskwakr()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-albamn-hskwakr-deactivator.php';
    Albamn_Hskwakr_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_albamn_hskwakr');
register_deactivation_hook(__FILE__, 'deactivate_albamn_hskwakr');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-albamn-hskwakr.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_albamn_hskwakr()
{
    $plugin = new Albamn_Hskwakr();
    $plugin->run();
}
run_albamn_hskwakr();
