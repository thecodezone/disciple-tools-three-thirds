<?php

class DT_33_Auth {
    private static $_instance = null;

    public function __construct() {
        $app_meta_key = DT_33_Magic_App::META_KEY;
    }

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function activate() {
        $app_user_key = get_user_option( DT_33_Magic_App::META_KEY );
        if (!$app_user_key) {
            update_user_option( get_current_user_id(), DT_33_Magic_App::META_KEY, dt_create_unique_key() );
        }
    }

    private function get_app_link() {
        $app_user_key = get_user_option( DT_33_Magic_App::META_KEY );
        $app_url_base =   trim(site_url(), '/' ) . DT_33_Magic_App::PATH;
        return $app_user_key ? $app_url_base . '/' . $app_user_key : '';
    }

    public function redirect_to_app() {
        if (!DT_33_Magic_App::is_activated()) {
            return;
        }
        wp_redirect($this->get_app_link());
        exit;
    }

    public function redirect_to_login() {
        wp_redirect(DT_33_Magic_Login::PATH);
        exit;
    }

}
