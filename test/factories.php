<?php

class factories {
    public $faker;

    public function __construct() {
        $this->faker = Faker\Factory::create();
    }

    public function meeting( $params = [] ) {
        return DT_Posts::create_post( 'meeting', array_merge( [
            'type'          => 'default',
            'title'         => $this->faker->title,
            'date'          => $this->faker->date,
            'meeting_notes' => $this->faker->paragraph
        ], $params ) );
    }

    public function three_thirds_meeting( $params ) {
        $this->meeting( array_merge( [
            'type'                                     => Disciple_Tools_Three_Thirds_Meeting_Type::MEETING_TYPE,
            'three_thirds_looking_back_content'        => $this->faker->paragraph,
            'three_thirds_looking_back_number_shared'  => $this->faker->numberBetween( 0, 10 ),
            'three_thirds_looking_back_new_believers'  => $this->faker->numberBetween( 0, 10 ),
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
            'dt_three_thirds_magic_url'                => $this->faker->url
        ], $params ) );
    }
}
