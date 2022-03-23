<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Disciple_Tools_Three_Thirds_Transformers {
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
     * @throws Exception
     */
    public function meetings( $meetings ) {
        if (!$meetings) {
            return [
                'total' => 0,
                'posts' => []
            ];
        }

        return [
            'total' => $meetings['total'],
            'posts' => array_map(function($meeting) {
                return $this->meeting($meeting);
            }, $meetings['posts'])
        ];
    }

    /**
     * Format meeting data for the front-end
     * @param $meeting
     * @return mixed
     * @throws Exception
     */
    public function meeting( $meeting ) {
        $date = $meeting['date'] ?? [];
        $date['formatted'] = gmdate( 'F j, Y', $date['timestamp']);

        return [
            'ID' => $meeting['ID'],
            'assigned_to' => $meeting['assigned_to'] ?? null,
            'date' => $date,
            'name' => $meeting['name'] ?? '',
            'three_thirds_looking_back_content' => $meeting['three_thirds_looking_back_content'] ?? '',
            'three_thirds_looking_back_number_shared' => $meeting['three_thirds_looking_back_number_shared'] ?? 0,
            'three_thirds_looking_back_new_believers' => $meeting['three_thirds_looking_back_new_believers'] ?? [],
            'three_thirds_looking_back_notes' => $meeting['three_thirds_looking_back_notes'] ?? '',
            'three_thirds_looking_up_number_attendees' => $meeting['three_thirds_looking_up_number_attendees'] ?? '',
            'three_thirds_looking_up_topic' => $meeting['three_thirds_looking_up_topic'] ?? '',
            'three_thirds_looking_up_content' => $meeting['three_thirds_looking_up_content'] ?? '',
            'three_thirds_looking_up_practice' => $meeting['three_thirds_looking_up_practice'] ?? '',
            'three_thirds_looking_up_notes' => $meeting['three_thirds_looking_up_notes'] ?? '',
            'three_thirds_looking_ahead_content' => $meeting['three_thirds_looking_ahead_content'] ?? '',
            'three_thirds_looking_ahead_share_goal' => $meeting['three_thirds_looking_ahead_share_goal'] ?? 0,
            'three_thirds_looking_ahead_applications' => $meeting['three_thirds_looking_ahead_applications'] ?? '',
            'three_thirds_looking_ahead_prayer_topics' => $meeting['three_thirds_looking_ahead_prayer_topics'] ?? '',
            'three_thirds_looking_ahead_notes' => $meeting['three_thirds_looking_ahead_notes'] ?? '',
        ];
    }
}
