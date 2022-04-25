<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

require_once 'login-rest-actions.php';

/**
 * Adds a magic link home page to the Disciple Tools system.
 * @usage This could be used to add a microsite in front of the Disciple Tools system. Or used to hide the
 * Disciple Tools login behind a false store front. Or used to extend an entire application to the public out
 * in front of the Disciple Tools system.
 *
 * @example https://yoursite.com/(empty)
 *
 * @see https://disciple.tools/plugins/porch/
 * @see https://disciple.tools/plugins/disciple-tools-porch-template/
 */
class Disciple_Tools_Three_Thirds_Magic_Login extends Disciple_Tools_Three_Thirds_Magic_Link {
    const PATH = '/threethirds/login';

    public $magic = false;
    public $parts = false;
    public $page_title = '3/3rds Meetings';
    public $root = "threethirds";
    public $type = 'login';
    public static $token = 'three-thirds-login';
    private static $_instance = null;
    private $actions;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();
        $this->actions = Disciple_Tools_Three_Thirds_Login_Rest_Actions::instance();
        $this->magic = new DT_Magic_URL( $this->root );
        $this->parts = $this->magic->parse_url_parts();

        $url = dt_get_url_path();

        if ( strpos( $url, $this->root . '/' . $this->type ) !== false ) {

            if (!dt_is_rest() && is_user_logged_in()) {
                wp_redirect('/3/3');
                exit;
            }
            /**
             * tests magic link parts are registered and have valid elements
             */
            if ( !$this->check_parts_match( false ) ) {
                return;
            }


            // register url and access
            add_action( "template_redirect", [ $this, 'theme_redirect' ] );
            add_filter( 'dt_blank_access', function () {
                return true;
            }, 100, 1 );
            add_filter( 'dt_allow_non_login_access', function () {
                return true;
            }, 100, 1 );
            add_filter( 'dt_override_header_meta', function () {
                return true;
            }, 100, 1 );

            // header content
            add_filter( "dt_blank_title", [ $this, "page_tab_title" ] ); // adds basic title to browser tab
            add_action( 'wp_print_scripts', [ $this, 'print_scripts' ], 1500 ); // authorizes scripts
            add_action( 'wp_print_styles', [ $this, 'print_styles' ], 1500 ); // authorizes styles


            // page content
            add_action( 'dt_blank_head', [ $this, '_header' ] );
            add_action( 'dt_blank_footer', [ $this, '_footer' ] );
            add_action( 'dt_blank_body', [ $this, 'body' ] ); // body for no post key

            add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 99 );
            add_filter( 'dt_magic_url_base_allowed_css', [ $this, 'dt_magic_url_base_allowed_css' ], 10, 1 );
            add_filter( 'dt_magic_url_base_allowed_js', [ $this, 'dt_magic_url_base_allowed_js' ], 10, 1 );
        }

        if ( dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
            add_filter( 'dt_allow_rest_access', [ $this, 'authorize_url' ], 10, 1 );
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
                       return !is_user_logged_in();
                    },
                ],
            ]
        );
    }

    public function resolve_endpoint( WP_REST_Request $request ) {
        $method = strtolower( $request->get_method() ) . '_' . $request->get_param( 'action' );
        if ( method_exists( $this->actions, $method ) ) {
            return $this->actions->$method( $request );
        } else {
            return new WP_REST_Response( 'Unsupported action.', 404 );
        }
    }

    public function wp_enqueue_scripts() {
       parent::wp_enqueue_scripts();
       wp_enqueue_script( Disciple_Tools_Three_Thirds::DOMAIN . "_login", Disciple_Tools_Three_Thirds::$URL . 'dist/login.js', [], filemtime( Disciple_Tools_Three_Thirds::$DIR . 'dist/login.js' ), true );
       wp_localize_script( Disciple_Tools_Three_Thirds::DOMAIN . "_login", 'magicLink', $this->localizations() );
    }


    public function body() {
        ?>
        <div id="app"></div>
        <?php
    }
}

Disciple_Tools_Three_Thirds_Magic_Login::instance();
