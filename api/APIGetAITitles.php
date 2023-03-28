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
    public function request($content)
    {
        $args = [
            [
                "role" => "system",
                "content" => "Create 10 SEO titles for articles"
            ],
            [
                "role" => "user",
                "content" => $content
            ]
        ];
        try {
            return $this->createRequest($args)->toModel()->choices[0]->message->content;
        } catch (ClientException $e) {
            error_log('Can\'t create request for title');
        }
    }

}