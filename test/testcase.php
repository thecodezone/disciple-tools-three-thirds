<?php

/**
 * Class TestCase \PHPUnit\Framework\TestCas
 */
abstract class TestCase extends WP_UnitTestCase {
    protected $faker;
    protected $factories;

    public function __construct( $name = null, array $data = [], $dataName = '' ) {
        $this->faker = Faker\Factory::create();
        $this->factories = new factories();

        parent::__construct( $name, $data, $dataName );

        activate_plugin( 'disciple-tools-three-thirds/disciple-tools-three-thirds.php' );
        activate_plugin( 'disciple-tools-meetings/disciple-tools-meetings.php' );
    }

    public function actingAsAdmin() {
        $this->acting_as( 'administrator' );
    }

    public function acting_as( $role ) {
        $user_id = wp_create_user( $this->faker->userName, $this->faker->password, $this->faker->email );
        wp_set_current_user( $user_id );
        $user = wp_get_current_user();
        $user->set_role( $role );
    }

    public function setUp() {
        global $wpdb;
        $wpdb->query( 'START TRANSACTION' );
        parent::setUp();
    }

    public function tearDown() {
        global $wpdb;
        $wpdb->query( 'ROLLBACK' );
        parent::tearDown();
    }

    public function three_thirds_meeting( $data = [] ) {
        return DT_Posts::create_post( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, [
            'title' => $this->faker->title,
        ] );
    }
}
