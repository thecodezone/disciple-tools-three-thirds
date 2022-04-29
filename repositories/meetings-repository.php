<?php

class Disciple_Tools_Three_Thirds_Meetings_Repository {
    private static $_instance = null;
    private $cache;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function flush() {
        $this->cache = [];
    }

    /**
     * Return all three-thirds meetings
     */
    public function all( $params = [] ) {
        $params = array_merge([
            'fields_to_return' => array_keys( DT_Posts::get_post_settings( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE )['fields'] ),
            'sort' => '-date'
        ], $params);
        $cache_key = md5(wp_json_encode($params));
        if (isset($this->cache[$cache_key])) {
            return $this->cache[$cache_key];
        }
        $posts = DT_Posts::list_posts( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, $params )['posts'];
        $this->cache[$cache_key] = array_filter($posts, function($post) {
            return isset($post['type']) && $post['type']['key'] === Disciple_Tools_Three_Thirds_Meeting_Type::MEETING_TYPE;
        });
        return $this->cache[$cache_key];
    }

    /**
     * @param string $search
     * @param string $filter
     * @return mixed
     */
    public function filtered( $search = '', $filter = '' ) {
        $filtered = static::all();

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
        } else if($filter) {
            //Only posts in a series
            $filtered = array_filter($filtered, function($meeting) use ($filter) {
                return in_array($filter, $meeting['series'] ?? []);
            });
        }

        //Filter the meetings by search string
        if ($search) {
            $filtered = array_filter($filtered, function($meeting) use ($search) {
                return strpos(strtolower($meeting['name']), strtolower($search)) !== false;
            });
        }

        return $filtered;
    }

    /**
     * Find a three things meetings by ID
     */
    public function find( $id ) {
        return DT_Posts::get_post( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, (int) $id, true );
    }

    /**
     * Find all three thirds meetings in a group
     */
    public function in_groups($groups) {
        if (!is_array($groups)) {
            $groups = [$groups];
        }
        $group_ids = array_column($groups, 'ID');
        return array_filter(self::all(), function($meeting) use ($group_ids) {
            $meeting_group_ids = array_column($meeting['groups'], 'ID');
            return !!count(array_intersect($group_ids, $meeting_group_ids));
        });
    }

    /**
     * Find all three thirds meetings in a series
     */
    public function in_series($series) {
        if (!is_array($series)) {
            $series = [$series];
        }
        return array_filter(self::all(), function($meeting) use ($series) {
            return !!count(array_intersect($meeting['series'], $series));
        });
    }

    /**
     * Get the previous meeting
     */
    public function previous($meeting) {
        if (!$meeting['date']) {
            return null;
        }

        if (isset($meeting['series']) && count($meeting['series'])) {
            $meetings = $this->in_series($meeting['series']);
        } else if(isset($meeting['groups']) && count($meeting['groups'])) {
            $meetings = $this->in_groups($meeting['groups']);
        }


        if (!count($meetings)) {
            return null;
        }

        //Only get previous
        $meetings = array_filter($meetings, function($post) use ($meeting) {
            if (!$post['date']) {
                return false;
            }

            return $post['date']['timestamp'] < $meeting['date']['timestamp'];
        });

        return array_values($meetings)[0];
    }

    public function series( $params = [] ) {
        $series = array_reduce($this->all( $params ), function($series, $meeting) {
            $series = array_merge($series, $meeting['series'] ?? []);
            return $series;
        }, []);
        $series = array_unique($series);
        sort($series);
        return $series;
    }
}
