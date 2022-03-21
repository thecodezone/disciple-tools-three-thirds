<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Disciple_Tools_Three_Thirds_Rest_Actions
{
    private $transformers;
    private static $_instance = null;
    public $meta = []; // Allows for instance specific data.

    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        $this->transformers = Disciple_Tools_Three_Thirds_Transformers::instance();
    }
    /**
     * Fetch meetings lead to the current user.
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function get_meetings( WP_REST_Request $request ) {
        //Defaults
        $sort = $request->has_param('sort') ? $request->get_param('sort') : '-date';

        //Build up the search params
        $params = $request->get_json_params() ?? $request->get_query_params();
        unset($params['action']);
        unset($params['parts']);
        $params['assigned_to'] = ['me'];
        $params['fields_to_return'] = [
            'type',
            'date'
        ];

        return $this->transformers->meetings(
            DT_Posts::list_posts(Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, $params)
        );
    }

    /**
     * Fetch meetings lead to the current user.
     * @param WP_REST_Request $request
     * Error
     */
    public function get_meeting( WP_REST_Request $request ) {
        return $this->transformers->meeting(
            DT_Posts::get_post( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, $request->get_param('id'), true )
        );
    }
}

Disciple_Tools_Three_Thirds_Rest_Actions::instance();
