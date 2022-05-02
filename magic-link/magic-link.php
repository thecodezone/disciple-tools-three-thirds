<?php

/**
 * Base for 3/3rds magic links
 * Class Disciple_Tools_Three_Thirds_Magic_Link
 */
abstract class Disciple_Tools_Three_Thirds_Magic_Link extends DT_Magic_Url_Base {
    protected $translations;
    protected $auth;
    protected $controller;

    public function __construct() {
        $this->magic = new DT_Magic_URL( $this->root );
        $this->parts = $this->magic->parse_url_parts();
        $this->translations = Disciple_Tools_Three_Thirds_Meetings_Translations::instance();

        if ($this->controller &&  dt_is_rest()) {
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


    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js[] = Disciple_Tools_Three_Thirds::DOMAIN;
        $allowed_js[] = Disciple_Tools_Three_Thirds::DOMAIN . "_app";
        $allowed_js[] = Disciple_Tools_Three_Thirds::DOMAIN . "_login";
        $allowed_js[] = Disciple_Tools_Three_Thirds::DOMAIN . '_fa';
        return $allowed_js;
    }

    public function dt_magic_url_base_allowed_css( $allowed_css ) {
        $blocked_css = [ 'site-css' ];

        $allowed_css[] = Disciple_Tools_Three_Thirds::DOMAIN;
        $allowed_css[] = 'font-poppins';
        $allowed_css[] = Disciple_Tools_Three_Thirds::DOMAIN . '_foundation';

        foreach ( $blocked_css as $blocked ) {
            if ( ( $key = array_search( $blocked, $allowed_css ) ) !== false ) {
                unset( $allowed_css[ $key ] );
            }
        }

        return $allowed_css;
    }

    /**
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
            'logout_url'   => wp_logout_url( Disciple_Tools_Three_Thirds_Magic_Redirect::PATH ),
            'reset_url'    => wp_lostpassword_url( Disciple_Tools_Three_Thirds_Magic_Redirect::PATH ),
            'redirect_url' => Disciple_Tools_Three_Thirds_Magic_Redirect::PATH,
            'files'        => [
                'logo' => Disciple_Tools_Three_Thirds::$URL . '/images/banner.png',
                'icon' => Disciple_Tools_Three_Thirds::$URL . '/images/icon.png'
            ], []
        ];
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'font-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap', [], 1 );

        wp_enqueue_style( Disciple_Tools_Three_Thirds::DOMAIN . '_foundation', Disciple_Tools_Three_Thirds::$URL . 'dist/foundation.css', [], filemtime( Disciple_Tools_Three_Thirds::$DIR . 'dist/foundation.css' ) );
        wp_enqueue_style( Disciple_Tools_Three_Thirds::DOMAIN, Disciple_Tools_Three_Thirds::$URL . 'dist/styles.css', [], filemtime( Disciple_Tools_Three_Thirds::$DIR . 'dist/styles.css' ) );
        wp_enqueue_script( Disciple_Tools_Three_Thirds::DOMAIN . '_fa', 'https://kit.fontawesome.com/dbfbaa4587.js' );
    }

    public function body() {
        ?>
        <div id="app"></div>
        <?php
    }

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

    public function resolve_endpoint( WP_REST_Request $request ) {
        $method = strtolower( $request->get_method() ) . '_' . $request->get_param( 'action' );
        if ( method_exists( $this->controller, $method ) ) {
            return $this->controller->$method( $request );
        } else {
            return new WP_REST_Response( 'Unsupported action.', 404 );
        }
    }
}
