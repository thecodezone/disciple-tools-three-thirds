<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.


class Disciple_Tools_Three_Thirds_Magic_Redirect  {
    const PATH = '/3/3';
    public $paths = [
        '3/3',
        'three-thirds'
    ];
    public $auth;

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        $this->auth = Disciple_Tools_Three_Thirds_Meetings_Auth::instance();
        $path = dt_get_url_path();
        if ( !in_array( $path, $this->paths ) ) {
            return;
        }

        if ( !is_user_logged_in() ) {
            $this->auth->redirect_to_login();
        }

        if ( !Disciple_Tools_Three_Thirds_Magic_App::is_activated() ) {
            $this->auth->activate();
        }

        $this->auth->redirect_to_app();
    }
}

Disciple_Tools_Three_Thirds_Magic_Redirect::instance();
