<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

/**
 * Handle the redirect URL. Does some work to check if the user is authorized and redirects them appropriately.
 * Class DT_33_Magic_Redirect
 */
class DT_33_Magic_Redirect  {
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
        $this->auth = DT_33_Auth::instance();
        $path = dt_get_url_path();

        /**
         * Is this a redirect URL?
         */
        if ( !in_array( $path, $this->paths ) ) {
            return;
        }

        /**
         * Redirect to the login app if the user is logged out
         */
        if ( !is_user_logged_in() ) {
            $this->auth->redirect_to_login();
        }

        /**
         * Auto-activate if the user visits this link to let the admin share an easy link to allow a user to use the magic link
         */
        if ( !DT_33_Magic_App::is_activated() ) {
            $this->auth->activate();
        }

        /**
         * All is good, redirect to the app.
         */
        $this->auth->redirect_to_app();
    }
}

DT_33_Magic_Redirect::instance();
