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
        $this->openAI = new APIConnectOpenAi();
        $api_routes = [
            'get-titles'              => new APIGetAITitles($this->openAI),
            'get-excerpts'            => new APIGetAIExcerpts($this->openAI),
        ];

        foreach ($api_routes as $key => $value) {
            \register_rest_route(
                'mopen_ai/v1',
                $value->base,
                [
                    'methods' => $value->methods ?? \WP_REST_Server::READABLE,
                    'permission_callback' => [$this, 'check_nonce'],
                    'callback' => [$value, 'request'],
                ]
            );
        }
        do_action('mopen_ai_after_register_pos_rest_routes');
    }


    public function check_nonce($request) {
        $verify_nonce = wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest');
        $user_can_edit_posts = current_user_can( 'edit_posts' );
        $options = get_option('mopeanai_setting');
        $oai_key = $options['mopenai_api_token'];

        if (!$oai_key) {
            return new \WP_Error(
                'rest_forbidden',
                __( 'API key is empty.', 'mopenai' ),
                array( 'status' => 403 )
            );
        }
        if (!$verify_nonce && !$user_can_edit_posts) {
            return new \WP_Error(
                'rest_forbidden',
                __( 'Sorry, you do not have permission to access this resource.', 'mopenai' ),
                array( 'status' => 403 )
            );
        }
        return true;
    }


}