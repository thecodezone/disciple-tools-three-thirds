<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

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
class Disciple_Tools_Three_Thirds_Magic_Auth extends Disciple_Tools_Three_Thirds_Magic_Link {
    const PATH = '/threethirds/auth';

    public $magic = false;
    public $parts = false;
    public $page_title = '3/3rds Meetings';
    public $root = "threethirds";
    public $type = 'auth';
    public static $token = 'three-thirds-login';
    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        parent::__construct();

        $this->magic = new DT_Magic_URL( $this->root );
        $this->parts = $this->magic->parse_url_parts();

        $url = dt_get_url_path();

        if ( strpos( $url, $this->root . '/' . $this->type ) !== false ) {
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
    }


    public function body() {
        ?>
        <div id="app"></div>
        <?php
    }
}

Disciple_Tools_Three_Thirds_Magic_Auth::instance();
