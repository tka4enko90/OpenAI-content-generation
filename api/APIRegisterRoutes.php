<?php

/**
 * API Register Route class
 *
 * @package MultiPOS - Point of Sale for WooCommerce
 * @version 1.0.0
 */

namespace MOpenAi\api;

use MOpenAi\api\APIConnectOpenAi;

/**
 * Register API Routes Class.
 */
class APIRegisterRoutes
{
    private $openAI;
    /**
     * Configuration Variable
     *
     * @var array


    /**
     * Constructor.
     */
    public function __construct()
    {
        global $wp_rewrite;
        add_action('rest_api_init', [$this, 'mopen_ai_register_api_routes']);
        update_option( "rewrite_rules", FALSE );
        $wp_rewrite->flush_rules( true );
    }

    /**
     * Register API routes function
     *
     * @return \WP_Error
     */
    public function mopen_ai_register_api_routes()
    {

        do_action('mopen_ai_before_register_pos_rest_routes');

        if (!is_admin()) {
            $this->openAI = new APIConnectOpenAi();
            $api_routes = [
                'get-titles'              => new APIGetAITitles($this->openAI),
                'get-excerpts'              => new APIGetAIExcerpts($this->openAI),
            ];

            foreach ($api_routes as $key => $value) {
                \register_rest_route(
                    'mopen_ai/v1',
                    $value->base,
                    [
                        'methods' => isset($value->methods) ? $value->methods : \WP_REST_Server::READABLE,
                        'permission_callback' => function ($request) {
                            return true;
                        },
                        'callback' => [$value, 'request'],
                    ]
                );
            }
        }
        do_action('mopen_ai_after_register_pos_rest_routes');
    }
}