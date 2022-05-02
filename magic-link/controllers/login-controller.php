<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Disciple_Tools_Three_Thirds_Login_Controller
{
    private $transformers;
    private static $_instance = null;
    public $meta = []; // Allows for instance specific data.

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        $this->auth = Disciple_Tools_Three_Thirds_Meetings_Auth::instance();
        $this->transformers = Disciple_Tools_Three_Thirds_Transformers::instance();
    }

    /**
     * Login a user
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function post_login( WP_REST_Request $request ) {
        $user = wp_authenticate($request->get_param('username'), $request->get_param('password'));

        if ( is_wp_error($user) ) {
            $error = $user->get_error_message();

            //If the error links to lost password, inject the 3/3rds redirect
            $error = str_replace('?action=lostpassword', '?action=lostpassword?&redirect_to=/3/3', $error);
            return [
                'error' => $error
            ];
        }

        wp_set_auth_cookie( $user->ID );

        $this->auth->activate();

        return [
            'success' => true
        ];
    }

    /**
     * Create a user
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function post_register( WP_REST_Request $request ) {
        $user = wp_create_user( $request->get_param('username'), $request->get_param('password'), $request->get_param('email') );

        if ( is_wp_error($user) ) {
            return [
                'error' => $user->get_error_message()
            ];
        }

        wp_set_current_user( $user );

        if ($request->has_param('groups')) {
            foreach($request->get_param('groups') as $group_title) {
                if ($group_title) {
                    $group = Disciple_Tools_Three_Thirds_Groups_Repository::instance()->create( [
                        'title' => $group_title,
                    ] );

                }
            }
        }

        return [
            'success' => !!$user
        ];
    }
}

Disciple_Tools_Three_Thirds_Login_Controller::instance();
