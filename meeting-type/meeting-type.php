<?php

/**
 * Register the 3/3rds meeting type. This is not a post type, but a type of a post type.
 *
 * Class DT_33_Meeting_Type
 */
class DT_33_Meeting_Type {
    const POST_TYPE = "meetings";
    const MEETING_TYPE = "three_thirds";

    private static $_instance = null;

    public $meetings_service = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->meetings_service = new DT_33_Utilities();
        add_filter( 'disciple_tools_meetings_types', [ $this, 'disciple_tools_meetings_types' ] );
        add_filter( 'dt_details_additional_tiles', [ $this, 'dt_details_additional_tiles' ], 100, 2 );
        add_filter( 'dt_custom_fields_settings', [ $this, 'dt_custom_fields_settings' ], 11, 2 );
        add_action( 'p2p_init', [ $this, 'p2p_init' ] );
    }

    /**
     * Add the meeting type to the meeting type field
     * @param $types
     * @return mixed
     */
    public function disciple_tools_meetings_types( $types ) {
        $types[ self::MEETING_TYPE ] = [
            "label"       => __( '3/3rds Meeting', 'disciple_tools_three_thirds' ),
            "description" => __( '3/3rds format meeting', 'disciple_tools_three_thirds' )
        ];
        return $types;
    }

    /**
     * Documentation
     * @link https://github.com/DiscipleTools/Documentation/blob/master/Theme-Core/fields.md#declaring-connection-fields
     */
    public function p2p_init(){
        /**
         * Connection to Leaders
         */
        p2p_register_connection_type(
            [
                'name'           => self::POST_TYPE."_to_previous",
                'from'           => self::POST_TYPE,
                'to'             => self::POST_TYPE,
            ]
        );
    }

    /**
     * @link https://github.com/DiscipleTools/Documentation/blob/master/Theme-Core/field-and-tiles.md
     */
    public function dt_details_additional_tiles( $tiles, $post_type = "" ) {
        if ( $post_type === self::POST_TYPE ) {
            $tiles["looking_back"] = [
                "label"       => __( "Looking Back", "disciple_tools_three_thirds" ),
                "description" => __( "A look back at the last meeting." ),
                "display_for" => [
                    "type" => [ self::MEETING_TYPE ],
                ]
            ];
            $tiles["looking_up"] = [
                "label"       => __( "Looking Up", "disciple_tools_three_thirds" ),
                "description" => __( "A look towards God for wisdom and growth." ),
                "display_for" => [
                    "type" => [ self::MEETING_TYPE ],
                ]
            ];
            $tiles["looking_ahead"] = [
                "label"       => __( "Looking Ahead", "disciple_tools_three_thirds" ),
                "description" => __( "A look towards the future." ),
                "display_for" => [
                    "type" => [ self::MEETING_TYPE ],
                ]
            ];

            $tile = $tiles['other'];
            unset( $tiles['other'] );
            $tiles['other'] = $tile;
        }

        return $tiles;
    }

    /**
     * Register the fields
     *
     * @param $fields
     * @param $post_type
     * @return mixed
     */
    public function dt_custom_fields_settings( $fields, $post_type ) {
        if ( $post_type === self::POST_TYPE ) {
            //General
            $fields['three_thirds_previous_meetings'] = [
                "name" => "Previous Meeting",
                "type" => "connection",
                "p2p_direction" => "to",
                "post_type" => self::POST_TYPE,
                "tile" => "status",
                "p2p_key" => "meetings_to_previous",
                "only_for_types" => [ self::MEETING_TYPE ]
            ];

            //Looking back
            $fields['three_thirds_looking_back_content'] = [
                "name"           => __( "Content", 'disciple_tools_three_thirds' ),
                "description"    => __( "Content or notes to guide the meeting leader.", 'disciple_tools_three_thirds' ),
                "type"           => "textarea",
                "tile"           => "looking_back",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/reading.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_back_number_shared'] = [
                "name"           => __( "Number Shared", 'disciple_tools_three_thirds' ),
                "description"    => __( "The number of times the gospel was shared by meeting members since the last meeting.", 'disciple_tools_three_thirds' ),
                "type"           => "number",
                "tile"           => "looking_back",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/tally.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_back_new_believers'] = [
                "name"           => __( "New Believers", 'disciple_tools_three_thirds' ),
                "description"    => __( "The names of new believers.", 'disciple_tools_three_thirds' ),
                "type"           => "tags",
                "tile"           => "looking_back",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/cross.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_back_notes'] = [
                "name"           => __( "Notes", 'disciple_tools_three_thirds' ),
                "description"    => __( "For use by the meeting leader during the meeting.", 'disciple_tools_three_thirds' ),
                "type"           => "textarea",
                "tile"           => "looking_back",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/comment.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];

            //Looking up
            $fields['three_thirds_looking_up_number_attendees'] = [
                "name"           => __( "Number in attendance", 'disciple_tools_three_thirds' ),
                "description"    => __( "The number of members at the meeting.", 'disciple_tools_three_thirds' ),
                "type"           => "number",
                "tile"           => "looking_up",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/group.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_up_topic'] = [
                "name"           => __( "Topic", 'disciple_tools_three_thirds' ),
                "description"    => __( "The topic of the meeting.", 'disciple_tools_three_thirds' ),
                "type"           => "text",
                "tile"           => "looking_up",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/trainings-hollow.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_up_content'] = [
                "name"           => __( "Content", 'disciple_tools_three_thirds' ),
                "description"    => __( "Content or notes to guide the meeting leader.", 'disciple_tools_three_thirds' ),
                "type"           => "textarea",
                "tile"           => "looking_up",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/reading.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_up_practice'] = [
                "name"           => __( "Practice", 'disciple_tools_three_thirds' ),
                "description"    => __( "The practice areas used at the meeting.", 'disciple_tools_three_thirds' ),
                "type"           => "textarea",
                "tile"           => "looking_up",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/coaching.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_up_notes'] = [
                "name"           => __( "Notes", 'disciple_tools_three_thirds' ),
                "description"    => __( "For use by the meeting leader during the meeting.", 'disciple_tools_three_thirds' ),
                "type"           => "textarea",
                "tile"           => "looking_up",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/comment.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];

            //Looking ahead
            $fields['three_thirds_looking_ahead_content'] = [
                "name"           => __( "Content", 'disciple_tools_three_thirds' ),
                "description"    => __( "Content or notes to guide the meeting leader.", 'disciple_tools_three_thirds' ),
                "type"           => "textarea",
                "tile"           => "looking_ahead",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/reading.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_ahead_share_goal'] = [
                "name"           => __( "Share goal", 'disciple_tools_three_thirds' ),
                "description"    => __( "The number of members in .", 'disciple_tools_three_thirds' ),
                "type"           => "number",
                "tile"           => "looking_ahead",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/tally.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_ahead_applications'] = [
                "name"           => __( "Application", 'disciple_tools_three_thirds' ),
                "description"    => __( "The application for the meeting.", 'disciple_tools_three_thirds' ),
                "type"           => "textarea",
                "tile"           => "looking_ahead",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/coach.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_ahead_prayer_topics'] = [
                "name"           => __( "Prayer topics", 'disciple_tools_three_thirds' ),
                "description"    => __( "Prayer topics or requests.", 'disciple_tools_three_thirds' ),
                "type"           => "textarea",
                "tile"           => "looking_ahead",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/list.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
            $fields['three_thirds_looking_ahead_notes'] = [
                "name"           => __( "Notes", 'disciple_tools_three_thirds' ),
                "description"    => __( "For use by the meeting leader during the meeting.", 'disciple_tools_three_thirds' ),
                "type"           => "textarea",
                "tile"           => "looking_ahead",
                "icon"           => get_template_directory_uri() . '/dt-assets/images/comment.svg',
                "only_for_types" => [ self::MEETING_TYPE ]
            ];
        }
        return $fields;
    }
}

DT_33_Meeting_Type::instance();
