<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

require_once 'app-rest-actions.php';

/**
 * Class Disciple_Tools_Three_Thirds_Magic_User_App
 */
class Disciple_Tools_Three_Thirds_Magic_App extends Disciple_Tools_Three_Thirds_Magic_Link {
    const META_KEY = 'threethirds_app_magic_key';
    const PATH = '/threethirds/app';

    public $page_title = '3/3rds Meetings';
    public $page_description = 'Facilitate 3/3rds meetings.';
    public $root = "threethirds";
    public $type = 'app';
    public $type_name = "3/3rds meeting";
    public $post_type = 'user';
    private $meta_key = '';
    public $show_bulk_send = false;
    public $show_app_tile = true;
    public $post_id;
    public $post;
    private $actions;

    private static $_instance = null;
    public $meta = []; // Allows for instance specific data.

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        $this->actions = Disciple_Tools_Three_Thirds_App_Rest_Actions::instance();

        /**
         * Specify metadata structure, specific to the processing of current
         * magic link type.
         *
         * - meta:              Magic link plugin related data.
         *      - app_type:     Flag indicating type to be processed by magic link plugin.
         *      - post_type     Magic link type post type.
         *      - contacts_only:    Boolean flag indicating how magic link type user assignments are to be handled within magic link plugin.
         *                          If True, lookup field to be provided within plugin for contacts only searching.
         *                          If false, Dropdown option to be provided for user, team or group selection.
         *      - fields:       List of fields to be displayed within magic link frontend form.
         */
        $this->meta = [
            'app_type'      => 'magic_link',
            'post_type'     => $this->post_type,
            'contacts_only' => false,
            'fields'        => [
                [
                    'id'    => 'name',
                    'label' => 'Name'
                ]
            ]
        ];

        $this->meta_key = static::META_KEY;

        parent::__construct();

        /**
         * tests if other URL
         */
        $url = dt_get_url_path();

        if ( strpos( $url, $this->root . '/' . $this->type ) !== false ) {
            /**
             * tests magic link parts are registered and have valid elements
             */
            //if ( !$this->check_parts_match() ) {
            //    return;
            //}

            /**
             * user_app and module section
             */
            add_filter( 'dt_settings_apps_list', [ $this, 'dt_settings_apps_list' ], 10, 1 );
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );

            add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 99 );
            add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
            add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );

            // load if valid url
            add_action( 'dt_blank_body', [ $this, 'body' ] );
        }

        if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
            add_filter( 'dt_allow_rest_access', [ $this, 'authorize_url' ], 10, 1 );
        }
    }

    public function wp_enqueue_scripts() {
        parent::wp_enqueue_scripts();
        wp_enqueue_script( Disciple_Tools_Three_Thirds::DOMAIN . "_app", Disciple_Tools_Three_Thirds::$URL . 'dist/app.js', [], filemtime( Disciple_Tools_Three_Thirds::$DIR . 'dist/app.js' ), true );
        wp_localize_script( Disciple_Tools_Three_Thirds::DOMAIN . "_app", 'magicLink', $this->localizations() );
    }

    /**
     * Has the user activated the app?
     * @return bool
     */
    public static function is_activated() {
        return !! get_user_option( self::META_KEY );
    }

    /**
     * Is the magic link valid?
     * @param WP_REST_Request $request
     * @return bool
     */
    public function validate_endpoint( WP_REST_Request $request ) {
        $magic = new DT_Magic_URL( $this->root );
        return $magic->verify_rest_endpoint_permissions_on_post( $request );
    }

    /**
     * Login without setting the auth cookie
     */
    private function login_for_request( WP_REST_Request $request ) {
        $user_id = $request->get_param('parts')['post_id'];
        $user = get_user_by( 'id', $user_id );
        if ( $user ) {
            wp_set_current_user( $user_id, $user->user_login );
        }
    }


    /**
     * Register REST Endpoints
     * @link https://github.com/DiscipleTools/disciple-tools-theme/wiki/Site-to-Site-Link for outside of wordpress authentication
     */
    public function add_endpoints() {
        $namespace = $this->root . '/v1';
        register_rest_route(
            $namespace, '/' . $this->type, [
                [
                    'methods'             => [ "POST", "GET" ],
                    'callback'            => [ $this, 'resolve_endpoint' ],
                    'permission_callback' => function ( WP_REST_Request $request ) {
                        $verified = $this->validate_endpoint( $request );
                        if ( $verified ) {
                            $this->login_for_request( $request );
                        }
                        return $verified;
                    },
                ],
            ]
        );
    }

    /**
     * Builds magic link type settings payload:
     * - key:               Unique magic link type key; which is usually composed of root, type and _magic_key suffix.
     * - url_base:          URL path information to map with parent magic link type.
     * - label:             Magic link type name.
     * - description:       Magic link type description.
     * - settings_display:  Boolean flag which determines if magic link type is to be listed within frontend user profile settings.
     *
     * @param $apps_list
     *
     * @return mixed
     */
    public function dt_settings_apps_list( $apps_list ) {
        $apps_list[ $this->meta_key ] = [
            'key'              => $this->meta_key,
            'url_base'         => $this->root . '/' . $this->type,
            'label'            => $this->page_title,
            'description'      => $this->page_description,
            'settings_display' => true
        ];

        return $apps_list;
    }

    public function resolve_endpoint( WP_REST_Request $request ) {
        $method = strtolower( $request->get_method() ) . '_' . $request->get_param( 'action' );
        if ( method_exists( $this->actions, $method ) ) {
            return $this->actions->$method( $request );
        } else {
            return new WP_REST_Response( 'Unsupported action.', 404 );
        }
    }
}

Disciple_Tools_Three_Thirds_Magic_App::instance();
