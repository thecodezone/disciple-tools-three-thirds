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
        if (isset($meeting['date'])) {
            $meeting['date']['formatted'] = gmdate( 'F j, Y', $meeting['date']['timestamp']);
        }

        return $meeting;
    }
}
