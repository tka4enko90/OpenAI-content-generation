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
    private $error;
    public $base = 'get-titles';
    public function __construct(APIConnectOpenAi $openAI)
    {
        $this->openAI = $openAI;

    }

    public function request(\WP_REST_Request $request)
    {
        $args = [
            [
                "role" => "system",
                "content" => "Summarize and create 10 titles for articles return exact titles without points numbers in the beginning use user content"
            ],
            [
                "role" => "user",
                "content" => $request['content']
            ],
            [
                "role" => "system",
                "content" => 'wrap each titles special symbols as %% in start and end'
            ]
        ];
        $args = apply_filters('mopen_ai_get_titles_prompt', $args);

       return $this->openAI->sendRequest($args);
    }
}