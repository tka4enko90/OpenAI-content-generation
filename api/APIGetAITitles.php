<?php

/**
 * API Get AI Titles
 * @version 1.0.0
 */

namespace MOpenAi\api;

defined('ABSPATH') || exit();


/**
 * Class APIGetAITitles
 * @package MOpenAi\api
 */
final class APIGetAITitles
{
    private $openAI;
    protected $options;
    private $error;
    public $base = 'get-titles';
    public function __construct(APIConnectOpenAi $openAI)
    {
        $this->openAI = $openAI;
        $this->options = get_option('mopeanai_setting');

    }

    /**
     * @param \WP_REST_Request $request
     * @return false|string
     */
    public function request(\WP_REST_Request $request)
    {
       return $this->openAI->sendRequest(APIPrompts::mopenPromptTitles($this->options['mopenai_model'], $request));
    }

}