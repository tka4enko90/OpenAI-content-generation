<?php

/**
 * API Register Route class
 *
 * @package MultiPOS - Point of Sale for WooCommerce
 * @version 1.0.0
 */

namespace MOpenAi\api;

use MOpenAi\api\APIGetAITitles;


/**
 * Register API Routes Class.
 */
class APIRegisterRoutes
{

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
//        add_filter('rest_pre_serve_request', array($this, 'initCors'), 1);
        add_action('rest_api_init', [$this, 'mopen_ai_register_api_routes']);
        update_option( "rewrite_rules", FALSE );
        $wp_rewrite->flush_rules( true );
    }


    /**
     * @param $value
     * @return mixed
     * Init cors for dev
     */
   public function initCors( $value ) {
        $origin = get_http_origin();
        $allowed_origins = ['localhost:8080'];

        if ( $origin && in_array( $origin, $allowed_origins ) ) {

            header( 'Access-Control-Allow-Origin: *' );
            header( 'Access-Control-Allow-Methods: POST, GET' );
            header( 'Access-Control-Allow-Headers: Content-Type, Authorization' );
            header( 'Access-Control-Allow-Credentials: true' );
        }

        return $value;
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

            $api_routes = [
                'get-titles'              => new APIGetAITitles(),
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