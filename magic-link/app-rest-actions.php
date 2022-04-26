<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

class Disciple_Tools_Three_Thirds_App_Rest_Actions {
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
        $this->transformers = Disciple_Tools_Three_Thirds_Transformers::instance();
        $this->utilities = Disciple_Tools_Three_Thirds_Meetings_Utilities::instance();
        $this->meetings = Disciple_Tools_Three_Thirds_Meetings_Repository::instance();
        $this->groups = Disciple_Tools_Three_Thirds_Groups_Repository::instance();
    }

    /**
     * Fetch meetings lead to the current user.
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function get_meetings( WP_REST_Request $request ) {
        //Defaults
        $sort = $request->has_param( 'sort' ) ? $request->get_param( 'sort' ) : '-date';
        $inital_posts_per_page = 5;
        $posts_per_page = $request->has_param( 'paged' ) ? 25 : $inital_posts_per_page; //Set the default depending if we are already paging
        $posts_per_page = $request->has_param( 'per_page' ) ? $request->has_param( 'per_page' ) : $posts_per_page;
        $paged = $request->has_param( 'paged' ) ? $request->get_param( 'paged' ) : 0;
        $search = $request->has_param( 'q' ) ? $request->get_param( 'q' ) : null;
        $filter = $request->has_param( 'filter' ) ? $request->get_param( 'filter' ) : null;

        //Build up the search params
        $params = [];
        $params['sort'] = $sort;
        $filtered = $this->meetings->filtered($search, $filter);
        $paginated = $this->utilities->paginate_posts_array($filtered, $paged, $posts_per_page, $inital_posts_per_page);
        $groups = $this->groups->all();

        $meetings = $this->transformers->meetings($paginated);
        $meetings['q'] = $search;
        $meetings['filter'] = $filter;

        return [
            'meetings' => $meetings,
            'groups' => $this->transformers->groups($groups)
        ];
    }

    /**
     * Fetch meetings lead to the current user.
     * @param WP_REST_Request $request
     * Error
     */
    public function get_meeting( WP_REST_Request $request ) {
        $meeting = $this->meetings->find( $request->get_param( 'meeting_id' ));
        if (!$meeting) {
            new WP_Error( 'no_posts', 'Meeting not found.', [ 'status' => 404 ] );
        }

        $previous_meeting = $this->meetings->previous($meeting);
        $result = $this->transformers->meeting( $meeting,);
        $result['previous_meeting'] = $previous_meeting;
        return $result;
    }
}

Disciple_Tools_Three_Thirds_App_Rest_Actions::instance();
