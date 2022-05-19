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
            'all'                   => __( 'All', 'disciple-tools-three-thirds' ),
            'accepted_christ_label' => __( 'Who accepted Christ?', 'disciple-tools-three-thirds' ),
            'application'           => __( 'Application', 'disciple-tools-three-thirds' ),
            'create'                => __( 'Create New Meeting', 'disciple-tools-three-thirds' ),
            'create_meeting'        => __( 'Create Meeting', 'disciple-tools-three-thirds' ),
            'create_account'        => __( 'Create Account', 'disciple-tools-three-thirds' ),
            'date'                  => __( 'Date', 'disciple-tools-three-thirds' ),
            'deactivated'           => __( 'The app has not yet been activated. Activate the app in your', 'disciple-tools-three-thirds' ),
            'description'           => __( 'Description', 'disciple-tools-three-thirds' ),
            'details'               => __( 'Details', 'disciple-tools-three-thirds' ),
            'disciple_tools'        => __( 'disciple.tools', 'disciple-tools-three-thirds' ),
            'edit'                  => __( 'Edit', 'disciple-tools-three-thirds' ),
            'edit_meeting'          => __( 'Edit Meeting', 'disciple-tools-three-thirds' ),
            'form_error'            => __( 'There was an error. Please try again.', 'disciple-tools-three-thirds' ),
            'go_to_login'           => __( 'Click here to login.', 'disciple-tools-three-thirds' ),
            'group'                 => __( 'Group', 'disciple-tools-three-thirds' ),
            'load_more'             => __( 'Load more', 'disciple-tools-three-thirds' ),
            'learn_more_about'      => __( 'Learn more about', 'disciple-tools-three-thirds' ),
            'looking_back'          => __( 'Looking Back', 'disciple-tools-three-thirds' ),
            'looking_up'            => __( 'Looking Up', 'disciple-tools-three-thirds' ),
            'looking_ahead'         => __( 'Looking Ahead', 'disciple-tools-three-thirds' ),
            'login'                 => __( 'Login', 'disciple-tools-three-thirds' ),
            'logout'                => __( 'Logout', 'disciple-tools-three-thirds' ),
            'next'                  => __( 'Next', 'disciple-tools-three-thirds' ),
            'no_group'              => __( 'No Group', 'disciple-tools-three-thirds' ),
            'on_zume'               => __( 'on Zúme', 'disciple-tools-three-thirds' ),
            'page_not_found'        => __( 'Page not found.', 'disciple-tools-three-thirds' ),
            'people'                => __( 'People', 'disciple-tools-three-thirds' ),
            'powered_by'            => __( 'Powered by', 'disciple-tools-three-thirds' ),
            'prayer_requests'       => __( 'Prayer Requests', 'disciple-tools-three-thirds' ),
            'prayer_requests_label' => __( 'Prayer requests go here.', 'disciple-tools-three-thirds' ),
            'previous'              => __( 'Previous', 'disciple-tools-three-thirds' ),
            'previous_meeting'      => __( 'Previous Meeting', 'disciple-tools-three-thirds' ),
            'meeting'               => __( 'Meeting', 'disciple-tools-three-thirds' ),
            'meeting_date'          => __( 'Meeting Date', 'disciple-tools-three-thirds' ),
            'meeting_found'         => __( 'meeting found', 'disciple-tools-three-thirds' ),
            'meetings_found'        => __( 'meetings found', 'disciple-tools-three-thirds' ),
            'name'                  => __( 'Name', 'disciple-tools-three-thirds' ),
            'registered'            => __( 'Your account has been created.', 'disciple-tools-three-thirds' ),
            'reset_password'        => __( 'Reset Password', 'disciple-tools-three-thirds' ),
            'return_home'           => __( 'Go to dashboard', 'disciple-tools-three-thirds' ),
            'settings'              => __( 'Settings', 'disciple-tools-three-thirds' ),
            'notes'                 => __( 'Notes', 'disciple-tools-three-thirds' ),
            "notes_label"           => __( 'Notes go here', 'disciple-tools-three-thirds' ),
            'number_present_label'  => __( 'How many members are present?', 'disciple-tools-three-thirds' ),
            'number_shared_label'   => __( 'How many did you share with?', 'disciple-tools-three-thirds' ),
            'practice'              => __( 'Practice', 'disciple-tools-three-thirds' ),
            'share_goal_label'      => __( 'How many people are we going to share with?', 'disciple-tools-three-thirds' ),
            'sign_in'               => __( 'Sign in', 'disciple-tools-three-thirds' ),
            'submit'                => __( 'Submit', 'disciple-tools-three-thirds' ),
            'title'                 => __( '3/3rds Meetings', 'disciple-tools-three-thirds' ),
            'topic'                 => __( 'Topic', 'disciple-tools-three-thirds' ),
        ];
    }

    public function find( $key ) {
        return $this->all()[ $key ] ?? '';
    }

    public function e( $key ) {
        echo wp_kses( $this->find( $key ) );
    }
}
