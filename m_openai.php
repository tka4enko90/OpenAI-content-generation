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

$request = new APIGetAITitles();
$response = $request->request('Connent');
?>
    <pre>
    <?php print_r($response);?>
    </pre>
<?php
add_action('wp_head', 'check_result');
function check_result()
{

//    die();
}




