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

add_action('wp_head', 'check_result');
function check_result()
{
    $options = get_option('option_name1');
    $oai_key = $options['input'] ?? null;

    if (!$oai_key) {
        return;
    }

    $openaiClient = Manager::build(
        new \GuzzleHttp\Client(),
        new Authentication($oai_key)
    );

    /** @var \Tectalic\OpenAi\Models\ChatCompletions\CreateResponse $response */
    $response = $openaiClient->chatCompletions()->create(
        new \Tectalic\OpenAi\Models\ChatCompletions\CreateRequest([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
//                    'content' => 'rewrite the following article in a more natural language english'
                    'content' => 'Can I provide to you article for rewrite the following article in a more natural language english for me?'
                ],
            ],
        ])
    )->toModel();



    echo '<pre>$response: ';
    print_r($response);
    echo '</pre>';
//    die();
}




