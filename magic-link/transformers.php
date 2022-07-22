<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

/**
 * Map posts to a format expected by the front-end
 *
 * Class DT_33_Transformers
 */
class DT_33_Transformers {
    private static $_instance = null;
    public $meta = []; // Allows for instance specific data.

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    /**
     * Format meetings data for the front-end
     * @param $meeting
     * @return mixed
     */
    public function meetings( $meetings, $with = [] ) {
        return $this->transform_posts( $meetings, 'meeting', $with );
    }

    /**
     * Format meeting data for the front-end
     * @param $meeting
     * @return mixed
     */
    public function meeting( $meeting, $with = [] ) {
        if ( !$meeting ) {
            return $meeting;
        }

        $date = $meeting['date'] ?? null;
        if ( is_array( $date ) && isset( $date['timestamp'] ) ) {
            $date['formatted'] = gmdate( get_option( 'date_format' ), $date['timestamp'] );
        }
        $label = $meeting['name'] ?? '';
        if ( is_array( $date ) && !empty( $date['formatted'] ) ) {
            $label .= ", " . $date['formatted'];
        }
        return [
            'value'                                    => $meeting['ID'],
            'label'                                    => $label,
            'ID'                                       => $meeting['ID'],
            'groups'                                   => in_array( 'groups', $with ) ? $this->groups( $meeting['groups'] ) : $this->ids( $meeting['groups'] ),
            'assigned_to'                              => $meeting['assigned_to'] ?? null,
            'date'                                     => $date,
            'name'                                     => $meeting['name'] ?? '',
            'three_thirds_previous_meetings'           => in_array( 'three_thirds_previous_meetings', $with ) ? $this->meetings( $meeting['three_thirds_previous_meetings'] ) : $this->ids( $meeting['three_thirds_previous_meetings'] ),
            'three_thirds_looking_back_content'        => $meeting['three_thirds_looking_back_content'] ?? '',
            'three_thirds_looking_back_number_shared'  => $meeting['three_thirds_looking_back_number_shared'] ?? 0,
            'three_thirds_looking_back_new_believers'  => $meeting['three_thirds_looking_back_new_believers'] ?? [],
            'three_thirds_looking_back_notes'          => $meeting['three_thirds_looking_back_notes'] ?? '',
            'three_thirds_looking_up_number_attendees' => $meeting['three_thirds_looking_up_number_attendees'] ?? '',
            'three_thirds_looking_up_topic'            => $meeting['three_thirds_looking_up_topic'] ?? '',
            'three_thirds_looking_up_content'          => $meeting['three_thirds_looking_up_content'] ?? '',
            'three_thirds_looking_up_practice'         => $meeting['three_thirds_looking_up_practice'] ?? '',
            'three_thirds_looking_up_notes'            => $meeting['three_thirds_looking_up_notes'] ?? '',
            'three_thirds_looking_ahead_content'       => $meeting['three_thirds_looking_ahead_content'] ?? '',
            'three_thirds_looking_ahead_share_goal'    => $meeting['three_thirds_looking_ahead_share_goal'] ?? 0,
            'three_thirds_looking_ahead_applications'  => $meeting['three_thirds_looking_ahead_applications'] ?? '',
            'three_thirds_looking_ahead_prayer_topics' => $meeting['three_thirds_looking_ahead_prayer_topics'] ?? '',
            'three_thirds_looking_ahead_notes'         => $meeting['three_thirds_looking_ahead_notes'] ?? '',
        ];
    }

    /**
     * Format meeting data for the front-end
     * @return mixed
     */
    public function groups( $groups, $with = [] ) {
        return $this->transform_posts( $groups, 'group', $with );
    }

    /**
     * Format meeting data for the front-end
     * @return mixed
     */
    public function ids( $posts ) {
        if ( !is_array( $posts ) ) {
            return [];
        }
        return array_map( function ( $post ) {
            return $post['ID'];
        }, $posts );
    }

    /**
     * Format meeting data for the front-end
     * @param $meeting
     * @return mixed
     */
    public function group( $group ) {
        return [
            'value' => $group['ID'],
            'label' => $group['post_title'],
            'ID'    => $group['ID'],
            'title' => $group['post_title']
        ];
    }

    /**
     * Trqnsform an array of posts
     * @param $items
     * @param $type
     * @param array $with
     * @return array
     */
    public function transform_posts( $items, $type, $with = [] ) {
        if ( !$items ) {
            return [
                'total' => 0,
                'type'  => $type,
                'posts' => []
            ];
        }

        if ( isset( $items['paged'] ) ) {
            $items['posts'] = $this->map_posts( $items['posts'], $type, $with );
            $items['type'] = $type;
            return $items;
        }

        if ( isset( $items['total'] ) && isset( $items['posts'] ) ) {
            return [
                'total' => $items['total'],
                'type'  => $type,
                'posts' => $this->map_posts( $items['posts'], $type, $with )
            ];
        }

        return [
            'total' => count( $items ),
            'type'  => $type,
            'posts' => $this->map_posts( $items, $type, $with )
        ];
    }

    /**
     * Take an array of posts and map it to the appropriate transformer
     * @param $items
     * @param $type
     * @param array $with
     * @return array
     */
    public function map_posts( $items, $type, $with = [] ) {
        return array_map( function ( $items ) use ( $type, $with ) {
            return $this->transform( $items, $type, $with );
        }, $items );
    }

    /**
     * Transform an item by type
     * @param $item
     * @param $type
     * @param array $with
     * @return mixed
     */
    public function transform( $item, $type, $with = [] ) {
        return $this->$type( $item, $with );
    }
}
