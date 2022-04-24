<?php

/**
 * Base for 3/3rds magic links
 * Class Disciple_Tools_Three_Thirds_Magic_Link
 */
abstract class Disciple_Tools_Three_Thirds_Magic_Link extends DT_Magic_Url_Base {
    protected $translations;

    public function __construct() {
        $this->translations = Disciple_Tools_Three_Thirds_Meetings_Translations::instance();
        $this->actions = Disciple_Tools_Three_Thirds_Rest_Actions::instance();
        $this->auth = Disciple_Tools_Three_Thirds_Meetings_Auth::instance();

        parent::__construct();
    }


    public function dt_magic_url_base_allowed_js( $allowed_js ) {
        $allowed_js[] = Disciple_Tools_Three_Thirds::DOMAIN;
        $allowed_js[] = Disciple_Tools_Three_Thirds::DOMAIN . "_app";
        $allowed_js[] = Disciple_Tools_Three_Thirds::DOMAIN .'_fa';
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

    public function localizations() {
         $key = $this->parts ? $this->parts['public_key'] : '';
         return [
            'root'         => esc_url_raw( rest_url() ),
            'basename'     => esc_url_raw( '/' . $this->root . '/' . $this->type . '/' . $key),
            'nonce'        => wp_create_nonce( 'wp_rest' ),
            'parts'        => $this->parts,
            'translations' => $this->translations->all(),
            'user'         => wp_json_encode(wp_get_current_user()),
            'reset_url' => wp_lostpassword_url(Disciple_Tools_Three_Thirds_Magic_Redirect::PATH),
            'files' => [
                'logo' =>  Disciple_Tools_Three_Thirds::$URL . '/images/banner.png',
                'icon' =>  Disciple_Tools_Three_Thirds::$URL . '/images/icon.png'
            ], []
        ];
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'font-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap', [], 1 );

        wp_enqueue_style( Disciple_Tools_Three_Thirds::DOMAIN . '_foundation', Disciple_Tools_Three_Thirds::$URL . 'dist/foundation.css', [], filemtime( Disciple_Tools_Three_Thirds::$DIR . 'dist/foundation.css' ) );
        wp_enqueue_style( Disciple_Tools_Three_Thirds::DOMAIN, Disciple_Tools_Three_Thirds::$URL . 'dist/styles.css', [], filemtime( Disciple_Tools_Three_Thirds::$DIR . 'dist/styles.css' ) );
        wp_enqueue_script( Disciple_Tools_Three_Thirds::DOMAIN . "_app", Disciple_Tools_Three_Thirds::$URL . 'dist/app.js', [], filemtime( Disciple_Tools_Three_Thirds::$DIR . 'dist/app.js' ), true );
        wp_enqueue_script( Disciple_Tools_Three_Thirds::DOMAIN .'_fa', 'https://kit.fontawesome.com/dbfbaa4587.js');
        wp_localize_script( Disciple_Tools_Three_Thirds::DOMAIN. "_app", 'magicLink', $this->localizations() );
    }

    public function resolve_endpoint( WP_REST_Request $request ) {
        $method = strtolower( $request->get_method() ) . '_' . $request->get_param( 'action' );
        if ( method_exists( $this->actions, $method ) ) {
            return $this->actions->$method( $request );
        } else {
            return new WP_REST_Response( 'Unsupported action.', 404 );
        }
    }

    public function body() {
        ?>
        <div id="app"></div>
        <?php
    }
}
