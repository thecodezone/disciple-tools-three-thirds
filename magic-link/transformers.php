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
    public function meetings( $meetings, $with = [] ) {
        return $this->transform_posts($meetings, 'meeting', $with);
    }

    /**
     * Format meeting data for the front-end
     * @param $meeting
     * @return mixed
     * @throws Exception
     */
    public function meeting( $meeting, $with = [] ) {
        $date = $meeting['date'] ?? [];
        $date['formatted'] = gmdate( 'F j, Y', $date['timestamp']);
        return array_merge([
            'ID' => $meeting['ID'],
            'groups' => $this->groups($meeting['groups']),
            'assigned_to' => $meeting['assigned_to'] ?? null,
            'date' => $date,
            'name' => $meeting['name'] ?? '',
            'series' => $meeting['series'],
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
        ], $with);
    }

    /**
     * Format meeting data for the front-end
     * @return mixed
     * @throws Exception
     */
    public function groups( $groups, $with = [] ) {
        return $this->transform_posts($groups, 'group', $with);
    }

    /**
     * Format meeting data for the front-end
     * @param $meeting
     * @return mixed
     * @throws Exception
     */
    public function group( $group, $with = [] ) {
        return array_merge([
            'ID' => $group['ID'],
            'title' => $group['post_title']
        ], $with);
    }

    public function transform_posts($items, $type, $with = [])
    {
        if (!$items) {
            return [
                'total' => 0,
                'type' => $type,
                'posts' => []
            ];
        }

        if (isset($items['paged'])) {
            $items['posts'] = $this->map_posts($items['posts'], $type, $with);
            $items['type'] = $type;
            return $items;
        }

        if (isset($items['total']) && isset($items['posts'])) {
            return [
                'total' => $items['total'],
                'type' => $type,
                'posts' => $this->map_posts($items['posts'], $type, $with)
            ];
        }

        return [
            'total' => count($items),
            'type' => $type,
            'posts' => $this->map_posts($items, $type, $with)
        ];
    }

    public function map_posts($items, $type, $with = [])
    {
        return array_map(function($items) use ($type, $with) {
            return $this->transform($items, $type, $with);
        }, $items);
    }

    public function transform($item, $type, $with)
    {
        return $this->$type($item, $with);
    }
}
