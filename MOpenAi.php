<?php
/*
Plugin Name: ChatGPT - OpenAI Content generation
Description: ChatGPT - OpenAI helps to create a title & an excerpt based on the content of post using ChatGPT API.
Version: 1.0
Author URI: https://markupus.com/
Text Domain: markupus
Domain Path: /lang
*/


if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once(__DIR__ . '/vendor/autoload.php');

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

            if ( !function_exists( 'use_block_editor_for_post' ) ) {

                deactivate_plugins( plugin_basename( __FILE__ ) );
                add_action( 'admin_notices', [$this, 'mopenai_gutenberg_admin_notice'] );

                return;
            }


            add_action( 'admin_init', [$this, 'check_editor'] );
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
         * Message about Gutenberg
         */

        public function mopenai_gutenberg_admin_notice() {
            echo '<div class="error"><p>' . __( 'The new text editor (Gutenberg) is not included. The plugin only works with the Gutenberg editor.', 'mopenai' ) . '</p></div>';
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }

        /**
         * Check if Gutenberg is enabled or not
         * @return bool
         */
        public function check_editor() {
            $check_editor = false;
            if (has_filter('use_block_editor_for_post') || is_plugin_active( 'classic-editor/classic-editor.php' )) {
                deactivate_plugins( plugin_basename( __FILE__ ) );
                add_action( 'admin_notices', [$this, 'mopenai_gutenberg_admin_notice'] );
                $check_editor = true;
            }
            return $check_editor;
        }

        /**
         * Plugin functionality initialization
         */
        public function initialization()
        {
            if (!$this->check_editor()) {
                new MOpenAIAdminSettingsPage();
                new APIRegisterRoutes();
                new GutenbergBlocks();
            }
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




