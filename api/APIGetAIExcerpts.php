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
    private $openAI;
    public function __construct(APIConnectOpenAi $openAI)
    {
        $this->openAI = $openAI;
    }
    public function request(\WP_REST_Request $request)
    {
        $args = [
            [
                "role" => "system",
                "content" => "Write 5 different relevant excerpts in 200 words from the following user content, convincing the reader to click the link and read the full article:wrap each excerpt special symbols as %% in start and end"
            ],
            [
                "role" => "user",
                "content" => $request['content']
            ]
        ];
        try {
            preg_match_all('/%%(.*?)%%/', $this->openAI->createRequest($args)->toModel()->choices[0]->message->content, $matches);
            return json_encode($matches[1], false);
        } catch (Exception $e) {
            error_log('Can\'t create request for Excerpts');
        }
    }
}