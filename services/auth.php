<?php

class Disciple_Tools_Three_Thirds_Meetings_Auth {
    private static $_instance = null;

    public function __construct() {
        $app_meta_key = Disciple_Tools_Three_Thirds_Magic_App::META_KEY;
    }

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function activate() {
        Disciple_Tools_Users::app_switch(get_current_user_id(), Disciple_Tools_Three_Thirds_Magic_App::META_KEY);
    }

    private function get_app_link() {
        $app_user_key = get_user_option( Disciple_Tools_Three_Thirds_Magic_App::META_KEY );
        $app_url_base = trailingslashit( trailingslashit( site_url() ) . Disciple_Tools_Three_Thirds_Magic_App::PATH );
        return $app_user_key ? $app_url_base . '/' . $app_user_key : '';
    }

    public function redirect_to_app() {
        if (!Disciple_Tools_Three_Thirds_Magic_App::is_activated()) {
            return;
        }
        wp_redirect($this->get_app_link());
        exit;
    }

    public function redirect_to_login() {
        wp_redirect(Disciple_Tools_Three_Thirds_Magic_Auth::PATH);
        exit;
    }
}
