<?php

/**
 * API Get AI Titles
 * API Get AI Excerpts

 * @version 1.0.0
 */

namespace MOpenAi\api;

defined('ABSPATH') || exit();

/**
 * Class APIGetAIExcerpts
 * @package MOpenAi\api
 */
final class APIGetAIExcerpts
{
    public $base = 'get-excerpts';
    protected $options;
    private $openAI;
    public function __construct(APIConnectOpenAi $openAI)
    {
        $this->openAI = $openAI;
        $this->options = get_option('mopeanai_setting');
    }
    public function request(\WP_REST_Request $request)
    {
        return $this->openAI->sendRequest(APIPrompts::mopenPromptExcerpts($this->options['mopenai_model'], $request));
    }
}