<?php

class factories {
    public $faker;

    public function __construct() {
        $this->faker = Faker\Factory::create();
    }

    public function post( $type, $defaults = [], $params = [] ) {
        $result = DT_Posts::create_post( $type, array_merge($defaults, $params), false, false);
        if ( $result instanceof WP_Error ) {
           // dd( $result );
        }

        return $result;
    }

    public function meeting( $params = [], $type = 'default' ) {
        $result = $this->post(
            'meetings', [
                'name'          => $this->faker->sentence,
                'date'          => $this->faker->date( 'yyyy-mm-dd' ),
                'meeting_notes' => $this->faker->paragraph
            ], $params);

        if ( $result instanceof WP_Error ) {
           // dd( $result );
        }

        add_post_meta( $result['ID'], 'type', $type );

        return $result;
    }

    public function group( $params = [] ) {
        return $this->post( 'groups',[
            'title' => $this->faker->sentence
        ], $params);
    }

    public function three_thirds_meeting( $params = [] ) {
        return $this->meeting( array_merge( [], [
            'three_thirds_looking_back_content'        => $this->faker->paragraph,
            'three_thirds_looking_back_number_shared'  => $this->faker->numberBetween( 0, 10 ),
            'three_thirds_looking_back_new_believers'  => [
                'values' => $this->faker->randomElements( [
                    [ 'value' => $this->faker->name ],
                    [ 'value' => $this->faker->name ],
                    [ 'value' => $this->faker->name ],
                    [ 'value' => $this->faker->name ],
                    [ 'value' => $this->faker->name ],
                    [ 'value' => $this->faker->name ]
                ] )
            ],
            'three_thirds_looking_back_notes'          => $this->faker->paragraph,
            'three_thirds_looking_up_number_attendees' => $this->faker->numberBetween( 0, 10 ),
            'three_thirds_looking_up_topic'            => $this->faker->sentence,
            'three_thirds_looking_up_content'          => $this->faker->paragraph,
            'three_thirds_looking_up_practice'         => $this->faker->sentence,
            'three_thirds_looking_up_notes'            => $this->faker->paragraph,
            'three_thirds_looking_ahead_content'       => $this->faker->paragraph,
            'three_thirds_looking_ahead_share_goal'    => $this->faker->numberBetween( 0, 10 ),
            'three_thirds_looking_ahead_applications'  => $this->faker->sentence,
            'three_thirds_looking_ahead_prayer_topics' => $this->faker->paragraph,
            'three_thirds_looking_ahead_notes'         => $this->faker->paragraph,
            'assigned_to'                              => get_current_user_id()
        ], $params ), Disciple_Tools_Three_Thirds_Meeting_Type::MEETING_TYPE );
    }
}
