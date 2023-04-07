<?php
/*
Plugin Name: ChatGPT - OpenAI Content generation
Description: ChatGPT - OpenAI helps to create a title & an excerpt based on the content of post using ChatGPT API.
Version: 1.1
Author URI: https://markupus.com/
Text Domain: markupus
Domain Path: /lang
*/


if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once(__DIR__ . '/vendor/autoload.php');

use MOpenAi\admin\AdminEditors;
use MOpenAi\gutenberg\GutenbergBlocks;
use MOpenAi\api\APIRegisterRoutes;
use MOpenAi\admin\MOpenAIAdminSettingsPage;

if (! defined('ABSPATH')) {
    exit;
}
require_once ABSPATH.'wp-admin/includes/plugin.php';

define('PLUGIN_DIR', plugin_dir_url(__FILE__));
define( 'MOPENAI_PLUGIN_FILE', __FILE__ );

if( ! class_exists('MOpenAi') ) {

    class MOpenAi
    {
        /**
         * MOpenAi constructor.
         */
        public function __construct()
        {

            if (version_compare(PHP_VERSION, '7.2', '<=')) {

                deactivate_plugins( plugin_basename( __FILE__ ) );
                add_action( 'admin_notices', [$this, 'mopenai_incompatible_admin_notice'] );

                return;
            }


            add_action('init', [$this, 'initialization']);
            add_action( 'plugins_loaded', [$this, 'mopenail_plugin_textdomain'] );
        }

        /**
         * Message about incompatible PHP version
         */

        public function mopenai_incompatible_admin_notice() {
            echo '<div class="error"><p>' . __( 'OpenAI Generation requires PHP 7.2 (or higher) to function properly. Please upgrade PHP. The Plugin has been auto-deactivated.', 'mopenai' ) . '</p></div>';
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }

        /**
         * Plugin functionality initialization
         */
        public function initialization()
        {
            new MOpenAIAdminSettingsPage();
            new APIRegisterRoutes();
            new AdminEditors();
            new GutenbergBlocks();
        }

        /**
         * Text domain for translations
         */
        public function mopenail_plugin_textdomain() {
            load_plugin_textdomain( 'mopenai', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );

        }
    }
}

new MOpenAi();




