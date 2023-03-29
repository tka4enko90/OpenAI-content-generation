<?php
/*
Plugin Name: OpenAI Generation
Description: OpenAI Generation
Version: 1.0.1
Text Domain: mopenai
Domain Path: /lang
*/


if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once(__DIR__ . '/admin/settings-page.php');

require_once(__DIR__ . '/vendor/autoload.php');


use Symfony\Component\HttpClient\Psr18Client;
use Tectalic\OpenAi\Authentication;
use Tectalic\OpenAi\Client;
use Tectalic\OpenAi\Manager;
use Tectalic\OpenAi\Models\Completions\CreateRequest;
use MOpenAi\api\APIGetAITitles;
use MOpenAi\admin\AdminEditors;
use MOpenAi\gutenberg\GutenbergBlocks;
use MOpenAi\api\APIRegisterRoutes;

if (! defined('ABSPATH')) {
    exit;
}
define('PLUGIN_DIR', plugin_dir_url(__FILE__));

add_action('init', function (){
    new APIRegisterRoutes();
    new AdminEditors();
    new GutenbergBlocks();
});
//$request = new APIGetAITitles();

//$response = $request->request('Connent');

add_action('wp_head', 'check_result');
function check_result()
{

//    die();
}




