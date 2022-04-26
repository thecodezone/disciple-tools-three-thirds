<?php

class Disciple_Tools_Three_Thirds_Groups_Repository {
    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->meetings = Disciple_Tools_Three_Thirds_Meetings_Repository::instance();
    }

    /**
     * Extract the groups that have meetings
     * @param array $params
     * @return array
     */
    public function all( $params = [] ) {
        $groups = array_values( array_reduce( $this->meetings->all( $params ), function ( $groups, $meeting ) {
            if ( !$meeting['groups'] || !count( $meeting['groups'] ) ) {
                return $groups;
            }

            foreach ( $meeting['groups'] as $group ) {
                $groups[ $group['ID'] ] = $group;
            }

            return $groups;
        }, [] ) );

        //ABC order
        usort($groups, function($a, $b) {
            return strcmp($a["title"], $b["title"]);
        });

        return $groups;
    }
}
