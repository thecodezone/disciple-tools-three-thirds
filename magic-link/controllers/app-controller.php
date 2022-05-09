<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

/**
 * Class DT_33_App_Controller
 */
class DT_33_App_Controller {
    private $transformers;
    private static $_instance = null;
    public $meta = []; // Allows for instance specific data.

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    /**
     * DT_33_App_Controller constructor.
     */
    public function __construct() {
        $this->transformers = DT_33_Transformers::instance();
        $this->utilities = DT_33_Utilities::instance();
        $this->meetings = DT_33_Meetings_Repository::instance();
        $this->groups = DT_33_Groups_Repository::instance();
    }

    /**
     * Handles GET requests to Search meetings lead to the current user.
     * @param WP_REST_Request $request
     * @return array|WP_Error
     * @throws Exception
     */
    public function get_search_meetings( WP_REST_Request $request ) {
        //Defaults
        $sort = $request->has_param( 'sort' ) ? $request->get_param( 'sort' ) : '-date';
        $initial_posts_per_page = 5;
        $posts_per_page = $request->has_param( 'paged' ) ? 25 : $initial_posts_per_page; //Set the default depending if we are already paging
        $posts_per_page = $request->has_param( 'per_page' ) ? $request->has_param( 'per_page' ) : $posts_per_page;
        $paged = $request->has_param( 'paged' ) ? $request->get_param( 'paged' ) : 0;
        $search = $request->has_param( 'q' ) ? $request->get_param( 'q' ) : null;
        $filter = $request->has_param( 'filter' ) ? $request->get_param( 'filter' ) : null;

        //Build up the search params
        $params = [];
        $params['sort'] = $sort;
        $filtered = $this->meetings->filtered( $search, $filter );
        $paginated = $this->utilities->paginate_posts_array( $filtered, $paged, $posts_per_page, $initial_posts_per_page );
        $groups = $this->groups->with_meetings();

        $meetings = $this->transformers->meetings( $paginated, ['groups'] );
        $meetings['q'] = $search;
        $meetings['filter'] = $filter;

        return [
            'meetings' => $meetings,
            'groups'   => $this->transformers->groups( $groups ),
        ];
    }

    /**
     * Handles GET request to fetch meetings lead to the current user.
     * @param WP_REST_Request $request
     * @return array|WP_Error
     * @throws Exception
     */
    public function get_meetings( WP_REST_Request $request ) {
        return $this->transformers->meetings(
            $this->meetings->all()
        );
    }

    /**
     * Handles a GET request to display a meeting's data
     * @param WP_REST_Request $request
     * Error
     * @return array|mixed
     * @throws Exception
     */
    public function get_meeting( WP_REST_Request $request ) {
        $meeting = $this->meetings->find( $request->get_param( 'meeting_id' ) );
        if ( !$meeting ) {
            new WP_Error( 'no_posts', 'Meeting not found.', [ 'status' => 404 ] );
        }

        $previous_meeting = $this->meetings->previous( $meeting );
        $result = $this->transformers->meeting( $meeting, [ 'three_thirds_previous_meetings', 'groups' ] );
        $result['previous_meeting'] = $this->transformers->meeting( $previous_meeting );
        return $result;
    }

    /**
     * Handles PUT request to save a meeting
     */
    public function put_meeting( WP_REST_Request $request ) {
        $meeting = $this->meetings->find( $request->get_param( 'ID' ) );

        if ( !$meeting ) {
            return new WP_Error( 'no_posts', 'Meeting not found.', [ 'status' => 404 ] );
        }

        $params = $request->get_params();

        //If groups are non-numeric, they are groups to be created.
        if ( isset( $params['groups'] ) && is_array( $params['groups'] ) ) {
            $params['groups'] = array_map( function ( $value ) {
                //It's an ID.
                if ( is_numeric( $value ) ) {
                    return $value;
                }

                //It might be an empty string.
                if ( !$value ) {
                    return $value;
                }


                //Is this a duplicate request?
                $group = $this->groups->find_by_title( $value );

                if ( $group ) {
                    return (string)$group['ID'];
                }

                //It's a title to be created.
                $group = $this->groups->create( [
                    'title' => $value,
                ] );

                if ( is_wp_error( $group ) ) {
                    return '';
                }

                return (string)$group['ID'];
            }, $params['groups'] );
        }


        $meeting = $this->meetings->save( $meeting['ID'], $params );
        if ( is_wp_error( $meeting ) ) {
            return $meeting;
        }

        return $this->transformers->meeting( $meeting );
    }

    public function post_meeting( WP_REST_Request $request ) {
        $params = $request->get_params();
        $meeting = $this->meetings->create($params);
        if ( is_wp_error( $meeting ) ) {
            return $meeting;
        }

        return $this->transformers->meeting( $meeting );
    }

    /**
     * Return GET request to get all the groups for the logged in user
     */
    public function get_groups( WP_REST_Request $request ) {
        return $this->transformers->groups(
            $this->groups->all()
        );
    }
}

DT_33_App_Controller::instance();
