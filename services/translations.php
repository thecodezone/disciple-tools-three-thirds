<?php

/**
 * A place to keep all translatable strings
 * Class DT_33_Translations
 */
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
            'all'                   => __( 'All', 'dt33' ),
            'accepted_christ_label' => __( 'Who accepted Christ?', 'dt33' ),
            'application'           => __( 'Application', 'dt33' ),
            'create'                => __( 'Create New Meeting', 'dt33' ),
            'create_meeting'        => __( 'Create Meeting', 'dt33' ),
            'create_account'        => __( 'Create Account', 'dt33' ),
            'date'                  => __( 'Date', 'dt33' ),
            'deactivated'           => __( 'The app has not yet been activated. Activate the app in your', 'dt33' ),
            'description'           => __( 'Description', 'dt33' ),
            'details'               => __( 'Details', 'dt33' ),
            'disciple_tools'        => __( 'disciple.tools', 'dt33' ),
            'edit'                  => __( 'Edit', 'dt33' ),
            'edit_meeting'          => __( 'Edit Meeting', 'dt33' ),
            'form_error'            => __( 'There was an error. Please try again.', 'dt33' ),
            'go_to_login'           => __( 'Click here to login.', 'dt33' ),
            'group'                 => __( 'Group', 'dt33' ),
            'load_more'             => __( 'Load more', 'dt33' ),
            'learn_more_about'      => __( 'Learn more about', 'dt33' ),
            'looking_back'          => __( 'Looking Back', 'dt33' ),
            'looking_up'            => __( 'Looking Up', 'dt33' ),
            'looking_ahead'         => __( 'Looking Ahead', 'dt33' ),
            'login'                 => __( 'Login', 'dt33' ),
            'logout'                => __( 'Logout', 'dt33' ),
            'next'                  => __( 'Next', 'dt33' ),
            'no_group'              => __( 'No Group', 'dt33' ),
            'on_zume'               => __( 'on Zúme', 'dt33' ),
            'page_not_found'        => __( 'Page not found.', 'dt33' ),
            'people'                => __( 'People', 'dt33' ),
            'powered_by'            => __( 'Powered by', 'dt33' ),
            'prayer_requests'       => __( 'Prayer Requests', 'dt33' ),
            'prayer_requests_label' => __( 'Prayer requests go here.', 'dt33' ),
            'previous'              => __( 'Previous', 'dt33' ),
            'previous_meeting'      => __( 'Previous Meeting', 'dt33' ),
            'meeting'               => __( 'Meeting', 'dt33' ),
            'meeting_date'          => __( 'Meeting Date', 'dt33' ),
            'meeting_found'         => __( 'meeting found', 'dt33' ),
            'meetings_found'        => __( 'meetings found', 'dt33' ),
            'name'                  => __( 'Name', 'dt33' ),
            'registered'            => __( 'Your account has been created.', 'dt33' ),
            'reset_password'        => __( 'Reset Password', 'dt33' ),
            'return_home'           => __( 'Go to dashboard', 'dt33' ),
            'settings'              => __( 'Settings', 'dt33' ),
            'notes'                 => __( 'Notes', 'dt33' ),
            "notes_label"           => __( 'Notes go here', 'dt33' ),
            'number_present_label'  => __( 'How many members are present?', 'dt33' ),
            'number_shared_label'   => __( 'How many did you share with?', 'dt33' ),
            'practice'              => __( 'Practice', 'dt33' ),
            'share_goal_label'      => __( 'How many people are we going to share with?', 'dt33' ),
            'sign_in'               => __( 'Sign in', 'dt33' ),
            'submit'                => __( 'Submit', 'dt33' ),
            'title'                 => __( '3/3rds Meetings', 'dt33' ),
            'topic'                 => __( 'Topic', 'dt33' ),
        ];
    }

    public function find( $key ) {
        return $this->all()[ $key ] ?? '';
    }

    public function e( $key ) {
        echo wp_kses( $this->find( $key ) );
    }
}
