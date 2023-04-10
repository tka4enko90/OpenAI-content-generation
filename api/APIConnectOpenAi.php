<?php

/**
 * Abstract API Connect to OpenAi
 */

namespace MOpenAi\api;

use Symfony\Component\HttpClient\Psr18Client;
use Tectalic\OpenAi\Authentication;
use Tectalic\OpenAi\Client;
use Tectalic\OpenAi\Manager;
use Tectalic\OpenAi\Models\Completions\CreateRequest;

defined('ABSPATH') || exit();


/**
 * Class APIConnectOpenAi
 * @package MOpenAi\api
 */
final class APIConnectOpenAi
{
    protected $openaiClient;

    protected $options;
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
            new \GuzzleHttp\Client(),
            new Authentication($oai_key)
        );
    }

    public function createRequest($args) {

        $this->errorRequestHelper($args);

        return $this->openaiClient->chatCompletions()->create(
            new \Tectalic\OpenAi\Models\ChatCompletions\CreateRequest([
                'model' => $this->options['mopenai_model'],
                'messages' => $args,
            ])
        );
    }
    private function errorRequestHelper($args) {
        if (empty($args[1]['content'])) {
            return [ 'error' => ['message' => __('No content to generate', 'mopenai')] ];
        }
    }
}