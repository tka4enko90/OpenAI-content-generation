<?php

/**
 * Abstract API Connect to OpenAi
 */

namespace MOpenAi\api;

use GuzzleHttp\Client;
use Symfony\Component\HttpClient\Psr18Client;
use Tectalic\OpenAi\Authentication;
use Tectalic\OpenAi\Manager;
use Tectalic\OpenAi\Models\ChatCompletions\CreateRequest;
defined('ABSPATH') || exit();


/**
 * Class APIConnectOpenAi
 * @package MOpenAi\api
 */
final class APIConnectOpenAi
{
    protected $openaiClient;

    protected $options;
    protected $error;
    /**
     * Configuration Variable
     *
     * @var array

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->options = get_option('mopeanai_setting');
        $oai_key = isset($this->options['mopenai_api_token']) ? $this->options['mopenai_api_token'] : null;

        if (!$oai_key) {
            return;
        }

        $this->openaiClient = Manager::isGlobal() ? Manager::access() :  Manager::build(
            new Client(),
            new Authentication($oai_key)
        );
    }

    public function createRequest($args) {

        $this::errorRequestHelper($args);

       return $this->openaiClient->chatCompletions()->create(
            new CreateRequest([
                'model' => $this->options['mopenai_model'],
                'messages' => $args,
            ])
        );
    }

    /**
     * @param $args
     * @return false|string
     */
    public function sendRequest($args) {

        try {
            $response = $this->createRequest($args);

            if ($this::errorAPIHandler($response)) return $this::errorAPIHandler($response);

            preg_match_all('/%%(.*?)%%/', $response->toModel()->choices[0]->message->content, $matches);

            return json_encode($matches[1], false);

        } catch (\Exception $e) {
            error_log('Can\'t create request', $e);
        }
    }

    /**
     * @param $args
     * @return false|string
     */
    private static function errorAPIHandler($args) {

        if (is_array($args) && isset($args['error'])) {
            return json_encode($args, false);
        }

        if ($args && isset($args->toArray()['error'])) {
            return json_encode($args->toArray(), false);
        }
    }

    /**
     * @param $args
     * @return array
     */
    private static function errorRequestHelper($args) {
        if (empty($args[1]['content'])) {
            return [ 'error' => ['message' => __('No content to generate', 'mopenai')] ];
        }
    }
}