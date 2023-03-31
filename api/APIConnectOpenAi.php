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
    /**
     * Configuration Variable
     *
     * @var array

    /**
     * Constructor.
     */
    public function __construct()
    {
        $options = get_option('option_name1');
        $oai_key = $options['input'] ?? null;
        if (!$oai_key) {
            return;
        }

        $this->openaiClient = Manager::isGlobal() ? Manager::access() :  Manager::build(
            new \GuzzleHttp\Client(),
            new Authentication($oai_key)
        );
    }
    public function createRequest($args) {
        return $this->openaiClient->chatCompletions()->create(
            new \Tectalic\OpenAi\Models\ChatCompletions\CreateRequest([
                'model' => 'gpt-3.5-turbo',
                'messages' => $args,
            ])
        );
    }
}