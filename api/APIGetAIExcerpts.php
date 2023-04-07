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

        if (!$this->check_nonce()) {
            return json_encode([ 'error' => ['message' => __('Request security check failed', 'mopenai')] ]);
        } elseif (!$request['content']) {
            return json_encode([ 'error' => ['message' => __('No content to generate', 'mopenai')] ]);
        }


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

            if (isset($this->openAI->createRequest($args)->toArray()['error'])) {

                return json_encode($this->openAI->createRequest($args)->toArray(), false);

            } else {
                preg_match_all('/%%(.*?)%%/', $this->openAI->createRequest($args)->toModel()->choices[0]->message->content, $matches);
                return json_encode($matches[1], false);
            }
        } catch (Exception $e) {
            error_log('Can\'t create request for Excerpts');
        }
    }

    public function check_nonce() {
        $verify_nonce = wp_verify_nonce( $_SERVER['HTTP_X_WP_NONCE'], 'wp_rest' );
        $nonce = false;
        if ($verify_nonce) {
            $nonce = true;
        }
        return $nonce;
    }
}