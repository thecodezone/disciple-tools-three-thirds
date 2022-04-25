<?php

class Disciple_Tools_Three_Thirds_Meetings_Utilities {
    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Check a meeting (by id) to see if it's a three-thirds meeting
     * @param $uri
     * @return bool
     */
    public function is_three_thirds_meeting( $id ) {
        $field = get_post_meta( $id, 'type' );
        if ( !is_array( $field ) ) {
            return false;
        }
        return in_array( 'three_thirds', $field );
    }

    public function paginate_posts_array( $posts, $paged, $per_page, $inital_offset = 0) {
        $offset = (($paged - 1) * $per_page) + $inital_offset;
        $limit = $offset + $per_page;
        $page = array_slice($posts, $offset, $limit);

        return [
            'posts' => $page,
            'per_page' => $per_page,
            'paged' => $paged,
            'total' => count($posts),
            'count' => count($page),
            'offset' => $offset,
            'limit' => $limit
        ];
    }
}
