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




