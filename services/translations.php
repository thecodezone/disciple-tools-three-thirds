<?php

class Disciple_Tools_Three_Thirds_Meetings_Translations {
    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Get all translations
     * @return array
     */
    public function all() {
        return [
            'create'           => __( 'Create New Meeting', Disciple_Tools_Three_Thirds::DOMAIN ),
            'create_account'   => __( 'Create Account', Disciple_Tools_Three_Thirds::DOMAIN ),
            'deactivated'      => __( 'The app has not yet been activated. Activate the app in your', Disciple_Tools_Three_Thirds::DOMAIN ),
            'disciple_tools'   => __( 'disciple.tools', Disciple_Tools_Three_Thirds::DOMAIN ),
            'learn_more_about' => __( 'Learn more about', Disciple_Tools_Three_Thirds::DOMAIN ),
            'login'            => __( 'Login', Disciple_Tools_Three_Thirds::DOMAIN ),
            'next'             => __( 'Next', Disciple_Tools_Three_Thirds::DOMAIN ),
            'on_zume'          => __( 'on Zúme', Disciple_Tools_Three_Thirds::DOMAIN ),
            'page_not_found'   => __( 'Page not found.', Disciple_Tools_Three_Thirds::DOMAIN ),
            'powered_by'       => __( 'Powered by', Disciple_Tools_Three_Thirds::DOMAIN ),
            'previous'         => __( 'Previous', Disciple_Tools_Three_Thirds::DOMAIN ),
            'reset_password'   => __( 'Reset Password', Disciple_Tools_Three_Thirds::DOMAIN ),
            'return_home'      => __( 'Return home.', Disciple_Tools_Three_Thirds::DOMAIN ),
            'settings'         => __( 'settings', Disciple_Tools_Three_Thirds::DOMAIN ),
            'sign_in'          => __( 'Sign in', Disciple_Tools_Three_Thirds::DOMAIN ),
            'submit'           => __( 'Submit', Disciple_Tools_Three_Thirds::DOMAIN ),
            'title'            => __( '3/3rds Meetings', Disciple_Tools_Three_Thirds::DOMAIN ),
        ];
    }

    public function find( $key ) {
        return $this->all()[ $key ] ?? '';
    }

    public function e( $key ) {
        echo $this->find( $key );
    }
}
