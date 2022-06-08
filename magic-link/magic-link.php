<?php

/**
 * Base for 3/3rds magic links
 * Class DT_33_Magic_Link
 */
abstract class DT_33_Magic_Link extends DT_Magic_Url_Base {
    protected $translations;
    protected $auth;
    protected $controller;

    public function __construct() {
        $this->magic = new DT_Magic_URL( $this->root );
        $this->parts = $this->magic->parse_url_parts();
        $this->translations = DT_33_Translations::instance();

        if ( $this->controller && dt_is_rest() ) {
            add_action( 'rest_api_init', [ $this, 'add_endpoints' ] );
            add_filter( 'dt_allow_rest_access', [ $this, 'authorize_url' ], 10, 1 );
        }
        parent::__construct();
    }

    public function validate_parts() {
        return $this->check_parts_match();
    }

    /**
     * Test if it's the URL
     * @return bool
     */
    public function is_route() {
        $url = dt_get_url_path();
        return strpos( $url, $this->root . '/' . $this->type ) !== false;
    }


    /**
     * JS the magic link is allowed to use
     * @param $allowed_js
     * @return mixed
     */
    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js[] = DT_33::DOMAIN;
        $allowed_js[] = DT_33::DOMAIN . "_app";
        $allowed_js[] = DT_33::DOMAIN . "_login";
        $allowed_js[] = DT_33::DOMAIN . '_fa';
        return $allowed_js;
    }

    /**
     * CSS the magic link is allowed to load
     * @param $allowed_css
     * @return mixed
     */
    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $blocked_css = [ 'site-css' ];

        $allowed_css[] = DT_33::DOMAIN;
        $allowed_css[] = 'font-poppins';
        $allowed_css[] = DT_33::DOMAIN . '_foundation';

        foreach ( $blocked_css as $blocked ) {
            $key = array_search( $blocked, $allowed_css );
            if ( $key !== false ) {
                unset( $allowed_css[ $key ] );
            }
        }

        return $allowed_css;
    }

    /**
     * Data we're passing to JS
     * @return array
     */
    public function localizations() {
        $key = $this->parts ? $this->parts['public_key'] : '';
        return [
            'root'         => esc_url_raw( rest_url() ),
            'basename'     => esc_url_raw( '/' . $this->root . '/' . $this->type . '/' . $key ),
            'nonce'        => wp_create_nonce( 'wp_rest' ),
            'parts'        => $this->parts,
            'translations' => $this->translations->all(),
            'user'         => wp_json_encode( wp_get_current_user() ),
            'logout_url'   => wp_logout_url( DT_33_Magic_Redirect::PATH ),
            'reset_url'    => wp_lostpassword_url( DT_33_Magic_Redirect::PATH ),
            'redirect_url' => DT_33_Magic_Redirect::PATH,
            'files'        => [
                'logo' => DT_33::$url . '/images/banner.png',
                'icon' => DT_33::$url . '/images/icon.png'
            ],
            []
        ];
    }

    /**
     * Enqueue the CSS and JS
     */
    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'font-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap', [], 1 );
        wp_enqueue_style( DT_33::DOMAIN . '_foundation', DT_33::$url . 'dist/foundation.css', [], filemtime( DT_33::$dir . 'dist/foundation.css' ) );
        wp_enqueue_style( DT_33::DOMAIN, DT_33::$url . 'dist/styles.css', [], filemtime( DT_33::$dir . 'dist/styles.css' ) );
        wp_enqueue_script( DT_33::DOMAIN . '_fa', 'https://kit.fontawesome.com/dbfbaa4587.js', [], 1 );
    }

    /**
     * We are bootstrapping react
     */
    public function body() {
        ?>
        <div id="app"></div>
        <?php
    }

    /**
     * This is extended to app and login
     * @param WP_REST_Request $request
     * @return bool
     */
    public function validate_request( WP_REST_Request $request ) {
        return true;
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
                    'methods'             => [ "POST", "GET", "PUT" ],
                    'callback'            => [ $this, 'resolve_endpoint' ],
                    'permission_callback' => [ $this, 'validate_request' ],
                ],
            ]
        );
    }

    /**
     *  Overload API requests to the controllers
     *
     * @see /magic-link/controllers
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function resolve_endpoint( WP_REST_Request $request ) {
        $method = strtolower( $request->get_method() ) . '_' . $request->get_param( 'action' );
        if ( method_exists( $this->controller, $method ) ) {
            return $this->controller->$method( $request );
        } else {
            return new WP_REST_Response( 'Unsupported action.', 404 );
        }
    }
}
