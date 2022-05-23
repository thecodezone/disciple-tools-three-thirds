<?php

class DT_33_Meetings_Repository {
    private static $_instance = null;
    private $cache;

    /**
     * Fields defaults that should be included when saving meetings.
     * @var array[]
     */
    public static $force_fields = [
        'groups' => [],
        'three_thirds_previous_meetings' => [],
        'three_thirds_looking_back_new_believers' => []
    ];

    /**
     * Fields that are arrays
     * @var string[]
     */
    public static $array_fields = [
        'groups',
        'three_thirds_previous_meetings',
        'three_thirds_looking_back_new_believers'
    ];

    /**
     * Fields that are allowed be included when saving meetings.
     * @var string[]
     */
    public static $whitelist = [
        'type',
        'name',
        'groups',
        'date',
        'three_thirds_previous_meetings',
        'three_thirds_looking_ahead_applications',
        'three_thirds_looking_ahead_content',
        'three_thirds_looking_ahead_notes',
        'three_thirds_looking_ahead_prayer_topics',
        'three_thirds_looking_ahead_share_goal',
        'three_thirds_looking_back_content',
        'three_thirds_looking_back_new_believers',
        'three_thirds_looking_back_number_shared',
        'three_thirds_looking_back_notes',
        'three_thirds_looking_up_content',
        'three_thirds_looking_up_number_attendees',
        'three_thirds_looking_up_practice',
        'three_thirds_looking_up_topic',
        'three_thirds_looking_up_notes',
    ];

    private function args() {
        return [
            'fields_to_return' => array_keys( DT_Posts::get_post_settings( DT_33_Meeting_Type::POST_TYPE )['fields'] ),
            'sort'             => '-date',
            'type'             => [ 'key' => DT_33_Meeting_Type::MEETING_TYPE ],
        ];
    }

    /**
     * @return DT_33_Meetings_Repository|null
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * DT_33_Meetings_Repository constructor.
     */
    public function __construct() {
        $this->utilities = DT_33_Utilities::instance();
    }

    /**
     * Return all three-thirds meetings
     */
    public function all( $params = [] ) {
        $params = array_merge( $this->args(), $params );
        return DT_Posts::list_posts( DT_33_Meeting_Type::POST_TYPE, $params )['posts'];
    }

    /**
     * Filter meetings by a search term or a group
     * @param string $search
     * @param string $filter Group ID or NO_GROUP
     * @return mixed
     */
    public function filtered( $search = '', $filter = '' ) {
        $filtered = static::all();

        if ( $filter === 'NO_GROUP' ) {
            //Only posts without groups
            $filtered = array_filter( $filtered, function ( $meeting ) {
                $groups = $meeting['groups'] ?? [];
                return !count( $groups );
            } );
        } elseif ( $filter && is_numeric( $filter ) ) {
            //Only posts in a group
            $filtered = array_filter( $filtered, function ( $meeting ) use ( $filter ) {
                $groups = $meeting['groups'] ?? [];
                $groups = array_filter( $groups, function ( $group ) use ( $filter ) {
                    return (string) $group["ID"] === (string) $filter;
                } );
                return count( $groups );
            } );
        }

        //Filter the meetings by search string
        if ( $search ) {
            $filtered = array_filter( $filtered, function ( $meeting ) use ( $search ) {
                return strpos( strtolower( $meeting['name'] ), strtolower( $search ) ) !== false;
            } );
        }

        return $filtered;
    }

    /**
     * Search meetings
     * @param $search
     * @return array|WP_Error|WP_Query
     */
    public function search( $search ) {
        return DT_Posts::get_viewable_compact( 'meetings', $search, $this->args() );
    }

    /**
     * Find a three things meetings by ID
     */
    public function find( $id ) {
        $post = DT_Posts::get_post( DT_33_Meeting_Type::POST_TYPE, (int) $id, true );
        if ( $post['three_thirds_previous_meetings'] ) {
            $post['three_thirds_previous_meetings'] = array_map(function( $previous ) {
                return DT_Posts::get_post( DT_33_Meeting_Type::POST_TYPE, (int) $previous['ID'], true );
            }, $post['three_thirds_previous_meetings']);
        }
        return $post;
    }

    /**
     * Find all three thirds meetings in a group
     */
    public function in_groups( $groups ) {
        if ( !is_array( $groups ) ) {
            $groups = [ $groups ];
        }
        $group_ids = array_column( $groups, 'ID' );
        return array_filter( self::all(), function ( $meeting ) use ( $group_ids ) {
            $meeting_group_ids = array_column( $meeting['groups'], 'ID' );
            return ! !count( array_intersect( $group_ids, $meeting_group_ids ) );
        } );
    }

    /**
     * Get the previous meeting WP_POST
     * @param $meeting
     * @return mixed|null
     */
    private function previous_raw( $meeting ) {
        $meetings = $meeting['three_thirds_previous_meetings'];

        //Are there previous meetings?
        if ( !$meetings ) {
            return null;
        }

        if ( !count( $meetings ) ) {
            return null;
        }


        //Do we have a date to check against?
        if ( !$meeting['date'] ) {
            return $meetings[0];
        }

        //Do we need to find the previous by date?
        if ( count( $meetings ) === 1 ) {
            return $meetings[0];
        }


        //Only get meetings with dates
        $with_dates = array_filter( $meetings, function ( $post ) use ( $meeting ) {
            if ( !$post['date'] ) {
                return false;
            }
        } );

        if ( !count( $with_dates ) ) {
            return $meetings[0];
        }

        usort( $previous_meetings, function ( $a, $b ) {
            return $a['date']['timestamp'] <=> $b['date']['timestamp'];
        } );

        return $previous_meetings[0];
    }

    /**
     * Get the previous meeting DT_POST.
     * If more than one meeting exists, only take the latest.
     */
    public function previous( $meeting ) {
        $previous = $this->previous_raw( $meeting );
        if ( !$previous ) {
            return $previous;
        }
        return $this->find( $previous['ID'] );
    }

    /**
     * Save a meeting
     * @param $id
     * @param $fields
     * @return array|int[]|WP_Error
     */
    public function save( $id, $fields ) {
        $meeting = $this->find( $id );
        if ( !$meeting['type'] || !$meeting['type']['key'] === DT_33_Meeting_Type::MEETING_TYPE ) {
            return new WP_Error( 500, 'Incorrect meeting type' );
        }
        return DT_Posts::update_post(
            DT_33_Meeting_Type::POST_TYPE,
            $id,
            $this->prepare_fields( $fields )
        );
    }

    /**
     * Create a meeting
     * @param $fields
     * @return array|false|int|WP_Error|null
     */
    public function create( $fields ) {
        $fields['type'] = DT_33_Meeting_Type::MEETING_TYPE;
        return DT_Posts::create_post(
            DT_33_Meeting_Type::POST_TYPE,
            $this->prepare_fields( $fields )
        );
    }

    /**
     * Prepare the fields for save/create, removing any unneeded fields, or formatting fields for the dt_post.
     * @param $fields
     * @return array
     */
    protected function prepare_fields( $fields ) {
        $fields = array_merge( self::$force_fields, $fields );
        $fields = array_intersect_key( $fields, array_flip( self::$whitelist ) );

        foreach ( self::$array_fields as $name ) {

            if ( !isset( $fields[ $name ] ) ) {
                continue;
            }

            if ( is_array( $fields[ $name ] ) && isset( $fields[ $name ]['values'] ) ) {
                continue;
            }


            $fields[ $name ] = $this->utilities->format_array_field_value( $fields[ $name ] );
        }

        return $fields;
    }

}
