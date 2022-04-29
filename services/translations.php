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
            'all'                   => __( 'All', Disciple_Tools_Three_Thirds::DOMAIN ),
            'accepted_christ_label' => __( 'Who accepted Christ?', Disciple_Tools_Three_Thirds::DOMAIN ),
            'application'           => __( 'Application', Disciple_Tools_Three_Thirds::DOMAIN ),
            'create'                => __( 'Create New Meeting', Disciple_Tools_Three_Thirds::DOMAIN ),
            'create_account'        => __( 'Create Account', Disciple_Tools_Three_Thirds::DOMAIN ),
            'deactivated'           => __( 'The app has not yet been activated. Activate the app in your', Disciple_Tools_Three_Thirds::DOMAIN ),
            'description'           => __( 'Description', Disciple_Tools_Three_Thirds::DOMAIN ),
            'disciple_tools'        => __( 'disciple.tools', Disciple_Tools_Three_Thirds::DOMAIN ),
            'form_error'            => __( 'There was an error. Please try again.', Disciple_Tools_Three_Thirds::DOMAIN ),
            'go_to_login'           => __( 'Click here to login.', Disciple_Tools_Three_Thirds::DOMAIN ),
            'load_more'             => __( 'Load more', Disciple_Tools_Three_Thirds::DOMAIN ),
            'learn_more_about'      => __( 'Learn more about', Disciple_Tools_Three_Thirds::DOMAIN ),
            'looking_back'          => __( 'Looking Back', Disciple_Tools_Three_Thirds::DOMAIN ),
            'looking_up'            => __( 'Looking Up', Disciple_Tools_Three_Thirds::DOMAIN ),
            'looking_ahead'         => __( 'Looking Ahead', Disciple_Tools_Three_Thirds::DOMAIN ),
            'login'                 => __( 'Login', Disciple_Tools_Three_Thirds::DOMAIN ),
            'logout'                => __( 'Logout', Disciple_Tools_Three_Thirds::DOMAIN ),
            'next'                  => __( 'Next', Disciple_Tools_Three_Thirds::DOMAIN ),
            'no_group'              => __( 'No Group', Disciple_Tools_Three_Thirds::DOMAIN ),
            'on_zume'               => __( 'on Zúme', Disciple_Tools_Three_Thirds::DOMAIN ),
            'page_not_found'        => __( 'Page not found.', Disciple_Tools_Three_Thirds::DOMAIN ),
            'people'                => __( 'People', Disciple_Tools_Three_Thirds::DOMAIN ),
            'powered_by'            => __( 'Powered by', Disciple_Tools_Three_Thirds::DOMAIN ),
            'prayer_requests'       => __( 'Prayer Requests', Disciple_Tools_Three_Thirds::DOMAIN ),
            'previous'              => __( 'Previous', Disciple_Tools_Three_Thirds::DOMAIN ),
            'meeting_date'          => __( 'Meeting Date', Disciple_Tools_Three_Thirds::DOMAIN ),
            'meeting_found'         => __( 'meeting found', Disciple_Tools_Three_Thirds::DOMAIN ),
            'meetings_found'        => __( 'meetings found', Disciple_Tools_Three_Thirds::DOMAIN ),
            'registered'            => __( 'Your account has been created.', Disciple_Tools_Three_Thirds::DOMAIN ),
            'reset_password'        => __( 'Reset Password', Disciple_Tools_Three_Thirds::DOMAIN ),
            'return_home'           => __( 'Return home.', Disciple_Tools_Three_Thirds::DOMAIN ),
            'settings'              => __( 'settings', Disciple_Tools_Three_Thirds::DOMAIN ),
            'notes'                 => __( 'Notes', Disciple_Tools_Three_Thirds::DOMAIN ),
            'number_shared_label'   => __( 'How many did you share with?', Disciple_Tools_Three_Thirds::DOMAIN ),
            'sign_in'               => __( 'Sign in', Disciple_Tools_Three_Thirds::DOMAIN ),
            'submit'                => __( 'Submit', Disciple_Tools_Three_Thirds::DOMAIN ),
            'title'                 => __( '3/3rds Meetings', Disciple_Tools_Three_Thirds::DOMAIN ),
        ];
    }

    public function find( $key ) {
        return $this->all()[ $key ] ?? '';
    }

    public function e( $key ) {
        echo $this->find( $key );
    }
}
