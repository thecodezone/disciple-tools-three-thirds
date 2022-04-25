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
        unset( $params['action'] );
        unset( $params['parts'] );
        $params['sort'] = $sort;
        $params['fields_to_return'] = array_keys(DT_Posts::get_post_settings(Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE )['fields']);


        //Query the posts
        $all = DT_Posts::list_posts( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, $params )['posts'];
        $filtered = $all;

        //Filter the posts
        if ($filter) {
            if ($filter === 'NO_GROUP') {
                //Only posts without groups
                $filtered = array_filter($filtered, function($meeting) {
                    $groups = $meeting['groups'] ?? [];
                    return !count($groups);
                });
            } elseif(is_numeric($filter)) {
                //Only posts in a group
                $filtered = array_filter($filtered, function($meeting) use ($filter) {
                    $groups = $meeting['groups'] ?? [];
                    $groups = array_filter($groups, function($group) use ($filter) {
                        return (string) $group["ID"] === (string) $filter;
                    });
                    return count($groups);
                });
            }
        }

        //Filter the meetings by search string
        if ($search) {
            $filtered = array_filter($filtered, function($meeting) use ($search) {
                return strpos(strtolower($meeting['name']), strtolower($search)) !== false;
            });
        }

        //Paginate the posts
        $paginated = $this->utilities->paginate_posts_array($filtered, $paged, $posts_per_page, $inital_posts_per_page);

        //Extract the groups that have meetings
        $groups = array_values(array_reduce($all, function($groups, $meeting) {
            if (!$meeting['groups'] || !count($meeting['groups'])) {
                return $groups;
            }

            foreach($meeting['groups'] as $group) {
                $groups[$group['ID']] = $group;
            }

            return $groups;
        }, []));

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
        return $this->transformers->meeting(
            DT_Posts::get_post( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, $request->get_param( 'meeting_id' ), true )
        );
    }
}

Disciple_Tools_Three_Thirds_App_Rest_Actions::instance();
