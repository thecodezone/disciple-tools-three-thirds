<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

require_once 'controllers/app-controller.php';

/**
 * Class DT_33_Magic_User_App
 */
class DT_33_Magic_App extends DT_33_Magic_Link {
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
    protected $controller;

    private static $_instance = null;
    public $meta = []; // Allows for instance specific data.

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        $this->controller = DT_33_App_Controller::instance();

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

        if ( $this->is_route() ) {
            /**
             * user_app and module section
             */
            add_filter( 'dt_settings_apps_list', [ $this, 'dt_settings_apps_list' ], 10, 1 );

            if ( !$this->validate_parts() ) {
                return;
            }

            add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 99 );
            add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
            add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );

            // load if valid url
            add_action( 'dt_blank_body', [ $this, 'body' ] );
        }
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

    public function wp_enqueue_scripts() {
        parent::wp_enqueue_scripts();
        wp_enqueue_script( DT_33::DOMAIN . "_app", DT_33::$URL . 'dist/app.js', [], filemtime( DT_33::$DIR . 'dist/app.js' ), true );
        wp_localize_script( DT_33::DOMAIN . "_app", 'magicLink', $this->localizations() );
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

    public function validate_request( WP_REST_Request $request ) {
        $verified = $this->validate_endpoint( $request );
        if ( $verified ) {
            $this->login_for_request( $request );
        }
        return $verified;
    }
}

DT_33_Magic_App::instance();
