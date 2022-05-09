<?php

class DT_33_Translations {
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
            'all'                   => __( 'All', DT_33::DOMAIN ),
            'accepted_christ_label' => __( 'Who accepted Christ?', DT_33::DOMAIN ),
            'application'           => __( 'Application', DT_33::DOMAIN ),
            'create'                => __( 'Create New Meeting', DT_33::DOMAIN ),
            'create_meeting'        => __( 'Create Meeting', DT_33::DOMAIN ),
            'create_account'        => __( 'Create Account', DT_33::DOMAIN ),
            'date'                  => __( 'Date', DT_33::DOMAIN ),
            'deactivated'           => __( 'The app has not yet been activated. Activate the app in your', DT_33::DOMAIN ),
            'description'           => __( 'Description', DT_33::DOMAIN ),
            'details'               => __( 'Details', DT_33::DOMAIN ),
            'disciple_tools'        => __( 'disciple.tools', DT_33::DOMAIN ),
            'edit'                  => __( 'Edit', DT_33::DOMAIN ),
            'edit_meeting'          => __( 'Edit Meeting', DT_33::DOMAIN ),
            'form_error'            => __( 'There was an error. Please try again.', DT_33::DOMAIN ),
            'go_to_login'           => __( 'Click here to login.', DT_33::DOMAIN ),
            'group'                 => __( 'Group', DT_33::DOMAIN ),
            'load_more'             => __( 'Load more', DT_33::DOMAIN ),
            'learn_more_about'      => __( 'Learn more about', DT_33::DOMAIN ),
            'looking_back'          => __( 'Looking Back', DT_33::DOMAIN ),
            'looking_up'            => __( 'Looking Up', DT_33::DOMAIN ),
            'looking_ahead'         => __( 'Looking Ahead', DT_33::DOMAIN ),
            'login'                 => __( 'Login', DT_33::DOMAIN ),
            'logout'                => __( 'Logout', DT_33::DOMAIN ),
            'next'                  => __( 'Next', DT_33::DOMAIN ),
            'no_group'              => __( 'No Group', DT_33::DOMAIN ),
            'on_zume'               => __( 'on Zúme', DT_33::DOMAIN ),
            'page_not_found'        => __( 'Page not found.', DT_33::DOMAIN ),
            'people'                => __( 'People', DT_33::DOMAIN ),
            'powered_by'            => __( 'Powered by', DT_33::DOMAIN ),
            'prayer_requests'       => __( 'Prayer Requests', DT_33::DOMAIN ),
            'prayer_requests_label' => __( 'Prayer requests go here.', DT_33::DOMAIN ),
            'previous'              => __( 'Previous', DT_33::DOMAIN ),
            'previous_meeting'      => __( 'Previous Meeting', DT_33::DOMAIN ),
            'meeting'               => __( 'Meeting', DT_33::DOMAIN ),
            'meeting_date'          => __( 'Meeting Date', DT_33::DOMAIN ),
            'meeting_found'         => __( 'meeting found', DT_33::DOMAIN ),
            'meetings_found'        => __( 'meetings found', DT_33::DOMAIN ),
            'name'                  => __( 'Name', DT_33::DOMAIN ),
            'registered'            => __( 'Your account has been created.', DT_33::DOMAIN ),
            'reset_password'        => __( 'Reset Password', DT_33::DOMAIN ),
            'return_home'           => __( 'Go to dashboard', DT_33::DOMAIN ),
            'settings'              => __( 'Settings', DT_33::DOMAIN ),
            'notes'                 => __( 'Notes', DT_33::DOMAIN ),
            "notes_label"           => __( 'Notes go here', DT_33::DOMAIN ),
            'number_present_label'  => __( 'How many members are present?', DT_33::DOMAIN ),
            'number_shared_label'   => __( 'How many did you share with?', DT_33::DOMAIN ),
            'practice'              => __( 'Practice', DT_33::DOMAIN ),
            'share_goal_label'      => __( 'How many people are we going to share with?', DT_33::DOMAIN ),
            'sign_in'               => __( 'Sign in', DT_33::DOMAIN ),
            'submit'                => __( 'Submit', DT_33::DOMAIN ),
            'title'                 => __( '3/3rds Meetings', DT_33::DOMAIN ),
            'topic'                 => __( 'Topic', DT_33::DOMAIN ),
        ];
    }

    public function find( $key ) {
        return $this->all()[ $key ] ?? '';
    }

    public function e( $key ) {
        echo $this->find( $key );
    }
}
