<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

require_once 'controllers/login-controller.php';

/**
 * The logged out magic link to handle the login/register pages.
 */
class DT_33_Magic_Login extends DT_33_Magic_Link {
    const PATH = '/threethirds/login';

    public $magic = false;
    public $parts = false;
    public $page_title = '3/3rds Meetings';
    public $root = "threethirds";
    public $type = 'login';
    public static $token = 'three-thirds-login';
    private static $_instance = null;
    protected $controller;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        $this->controller = DT_33_Login_Controller::instance();
        parent::__construct();

        if ( $this->is_route() ) {
            if ( !dt_is_rest() && is_user_logged_in() ) {
                wp_redirect( '/3/3' );
                exit;
            }


            if ( $this->validate_parts() ) {
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
    }

    /**
     * Is the magic link URL valid?
     * @return bool
     */
    public function validate_parts() {
        return !$this->check_parts_match( false );
    }

    /**
     * Enqueue the scripts needed for the login pages
     */
    public function wp_enqueue_scripts() {
        parent::wp_enqueue_scripts();
        wp_enqueue_script( DT_33::DOMAIN . "_login", DT_33::$url . 'dist/login.js', [], filemtime( DT_33::$dir . 'dist/login.js' ), true );
        wp_localize_script( DT_33::DOMAIN . "_login", 'magicLink', $this->localizations() );
    }


    /**
     * We're just bootstrapping the react app
     */
    public function body() {
        ?>
        <div id="app"></div>
        <?php
    }
}

DT_33_Magic_Login::instance();
