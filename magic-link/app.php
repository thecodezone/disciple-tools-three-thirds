<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

require_once 'transformers.php';
require_once 'rest-actions.php';

/**
 * Class Disciple_Tools_Three_Thirds_Magic_User_App
 */
class Disciple_Tools_Three_Thirds_Magic_App extends DT_Magic_Url_Base {
    public $app_assets = Disciple_Tools_Three_Thirds::DOMAIN . '_' . 'app';
    public $page_title = '3/3rds Meetings';
    public $page_description = 'Facilitate 3/3rds meetings.';
    public $root = "three-thirds";
    public $type = 'meetings';
    public $type_name = "3/3rds meeting";
    public $post_type = 'user';
    private $meta_key = '';
    public $show_bulk_send = false;
    public $show_app_tile = true;
    public $post_id;
    public $post;
    public $actions;

    private static $_instance = null;
    public $meta = []; // Allows for instance specific data.

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {

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

        $this->meta_key = $this->root . '_' . $this->type . '_magic_key';
        $this->actions = Disciple_Tools_Three_Thirds_Rest_Actions::instance();
        parent::__construct();

        /**
         * user_app and module section
         */
        add_filter( 'dt_settings_apps_list', [ $this, 'dt_settings_apps_list' ], 10, 1 );
        add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );


        /**
         * tests if other URL
         */
        $url = dt_get_url_path();
        if ( strpos( $url, $this->root . '/' . $this->type ) === false ) {
            return;
        }
        /**
         * tests magic link parts are registered and have valid elements
         */
        if ( !$this->check_parts_match() ) {
            return;
        }

        // load if valid url
        add_action( 'dt_blank_body', [ $this, 'body' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 99 );
        add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
        add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
    }


    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js[] = $this->app_assets;
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $blocked_css = [ 'site-css' ];

        $allowed_css[] = $this->app_assets;
        $allowed_css[] = 'font-poppins';
        $allowed_css[] = $this->app_assets . '-foundation';

        foreach ( $blocked_css as $blocked ) {
            if ( ( $key = array_search( $blocked, $allowed_css ) ) !== false ) {
                unset( $allowed_css[ $key ] );
            }
        }

        return $allowed_css;
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'font-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap', [], 1 );
        wp_enqueue_style( $this->app_assets . '-foundation', Disciple_Tools_Three_Thirds::$URL . 'dist/foundation.css', [], filemtime( Disciple_Tools_Three_Thirds::$DIR . 'dist/foundation.css' ) );
        wp_enqueue_style( $this->app_assets, Disciple_Tools_Three_Thirds::$URL . 'dist/styles.css', [], filemtime( Disciple_Tools_Three_Thirds::$DIR . 'dist/styles.css' ) );
        wp_enqueue_script( $this->app_assets, Disciple_Tools_Three_Thirds::$URL . 'dist/app.js', [], filemtime( Disciple_Tools_Three_Thirds::$DIR . 'dist/app.js' ), true );
        wp_localize_script(
            $this->app_assets, 'magicLink', [
                'root'         => esc_url_raw( rest_url() ),
                'basename'     => esc_url_raw( '/' . $this->root . '/' . $this->type . '/' . $this->parts['public_key'] ),
                'nonce'        => wp_create_nonce( 'wp_rest' ),
                'parts'        => $this->parts,
                'translations' => [
                    'title'            => __( '3/3rds Meetings', Disciple_Tools_Three_Thirds::DOMAIN ),
                    'previous'         => __( 'Previous', Disciple_Tools_Three_Thirds::DOMAIN ),
                    'next'             => __( 'Next', Disciple_Tools_Three_Thirds::DOMAIN ),
                    'create'           => __( 'Create New Meeting', Disciple_Tools_Three_Thirds::DOMAIN ),
                    'learn_more_about' => __( 'Learn more about', Disciple_Tools_Three_Thirds::DOMAIN ),
                    'on_zume'          => __( 'on Zúme', Disciple_Tools_Three_Thirds::DOMAIN ),
                    'powered_by'       => __( 'Powered by', Disciple_Tools_Three_Thirds::DOMAIN ),
                    'disciple_tools'   => __( 'disciple.tools', Disciple_Tools_Three_Thirds::DOMAIN ),
                ],
            ]
        );
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

    public function body() {
        ?>
        <div id="app"></div>
        <?php
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
