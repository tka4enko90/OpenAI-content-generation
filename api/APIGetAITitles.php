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
        try {
            file_put_contents(ABSPATH . '/response_log.log', $this->openAI->createRequest($args)->toModel()->choices[0]->message->content, FILE_APPEND);
            preg_match_all('/%%(.*?)%%/', $this->openAI->createRequest($args)->toModel()->choices[0]->message->content, $matches);
            return json_encode($matches[1], false);
        } catch (Exception $e) {
            error_log('Can\'t create request for title');
        }
    }
}