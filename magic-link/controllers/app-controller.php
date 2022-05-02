<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

class Disciple_Tools_Three_Thirds_App_Controller {
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
            'groups' => $this->transformers->groups($groups),
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
        $result['previous_meeting'] = $result;
        return $result;
    }

    /**
     * Save a meeting
     */
    public function put_meeting( WP_REST_Request $request ) {
        $meeting = $this->meetings->find( $request->get_param( 'ID' ));

        if (!$meeting) {
            new WP_Error( 'no_posts', 'Meeting not found.', [ 'status' => 404 ] );
        }

        $params = array_merge(
            $meeting,
            $request->get_params()
        );

        $fields = [
            'series' => $this->utilities->format_array_field_value($params['series']),
            'three_thirds_looking_ahead_applications' => $params['three_thirds_looking_ahead_applications'],
            'three_thirds_looking_ahead_content' => $params['three_thirds_looking_ahead_content'],
            'three_thirds_looking_ahead_notes' => $params['three_thirds_looking_ahead_notes'],
            'three_thirds_looking_ahead_prayer_topics' => $params['three_thirds_looking_ahead_prayer_topics'],
            'three_thirds_looking_ahead_share_goal' => $params['three_thirds_looking_ahead_share_goal'],
            'three_thirds_looking_back_content' => $params['three_thirds_looking_back_content'],
            'three_thirds_looking_back_new_believers' => $this->utilities->format_array_field_value($params['three_thirds_looking_back_new_believers']),
            'three_thirds_looking_back_number_shared' => $params['three_thirds_looking_back_number_shared'],
            'three_thirds_looking_back_notes' => $params['three_thirds_looking_back_notes'],
            'three_thirds_looking_up_content' => $params['three_thirds_looking_up_notes'],
            'three_thirds_looking_up_number_attendees' => $params['three_thirds_looking_up_number_attendees'],
            'three_thirds_looking_up_practice' => $params['three_thirds_looking_up_practice'],
            'three_thirds_looking_up_topic' => $params['three_thirds_looking_up_topic'],
            'three_thirds_looking_up_notes' => $params['three_thirds_looking_up_notes'],
        ];

        return DT_Posts::update_post(
            Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE,
            $meeting['ID'],
            $fields
        );
    }
}

Disciple_Tools_Three_Thirds_App_Controller::instance();
