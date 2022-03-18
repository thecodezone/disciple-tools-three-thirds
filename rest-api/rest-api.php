<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Disciple_Tools_Three_Thirds_Endpoints
{
    const NAMESPACE = 'three-thirds/v1';
    /**
     * @todo Set the permissions your endpoint needs
     * @link https://github.com/DiscipleTools/Documentation/blob/master/theme-core/capabilities.md
     * @var string[]
     */
    public $permissions = [ 'access_meetings' ];

    //See https://github.com/DiscipleTools/disciple-tools-theme/wiki/Site-to-Site-Link for outside of wordpress authentication
    public function add_api_routes() {
        register_rest_route(
            self::NAMESPACE, '/meetings/(?P<id>\d+)', [
                'methods'  => "GET",
                'callback' => [ $this, 'meeting' ],
                'permission_callback' => function( WP_REST_Request $request ) {
                    return $this->has_permission();
                },
                'args' => array(
                    'id' => array(
                        'validate_callback' => function($param, $request, $key) {
                            return is_numeric( $param );
                        }
                    ),
                ),
            ]
        );

        register_rest_route(
            self::NAMESPACE, '/meetings', [
                'methods'  => "GET",
                'callback' => [ $this, 'meetings' ],
                'permission_callback' => function( WP_REST_Request $request ) {
                    return $this->has_permission();
                },
            ]
        );
    }

    /**
     * Fetch meetings lead to the current user.
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function meetings( WP_REST_Request $request ) {
        //Defaults
        $sort = $request->has_param('sort') ? $request->get_param('sort') : '-date';

        //Build up the search params
        $params = $request->get_json_params() ?? $request->get_query_params();
        $params['assigned_to'] = ['me'];
        $params['sort'] = $sort;
        $params['fields_to_return'] = [
            'type',
            'date'
        ];

        return DT_Posts::list_posts(Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, $params);
    }

    /**
     * Fetch meetings lead to the current user.
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function meeting( WP_REST_Request $request ) {
        return DT_Posts::get_post( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, $request->get_param('id'), true );
    }

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()
    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'add_api_routes' ] );
    }
    public function has_permission(){
        $pass = false;
        foreach ( $this->permissions as $permission ){
            if ( current_user_can( $permission ) ){
                $pass = true;
            }
        }
        return $pass;
    }
}
Disciple_Tools_Three_Thirds_Endpoints::instance();
