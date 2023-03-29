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
final class APIGetAITitles extends AbstractAPIConnectOpenAi
{
    public $base = 'get-titles';

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
//            return $this->createRequest($args)->toModel()->choices[0]->message->content;
            file_put_contents(ABSPATH . '/response_log.log', $this->createRequest($args)->toModel()->choices[0]->message->content, FILE_APPEND);
            preg_match_all('/%%(.*?)%%/', $this->createRequest($args)->toModel()->choices[0]->message->content, $matches);
            return json_encode($matches[1], false);
        } catch (ClientException $e) {
            error_log('Can\'t create request for title');
        }
    }

}