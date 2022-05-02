<?php

/**
 * Class TestCase \PHPUnit\Framework\TestCase
 */
abstract class TestCase extends WP_UnitTestCase {
    protected $faker;
    protected $factories;
    protected $users = [];

    public function __construct( $name = null, array $data = [], $dataName = '' ) {
        $this->faker = Faker\Factory::create();
        $this->factories = new factories();

        parent::__construct( $name, $data, $dataName );

        activate_plugin( 'disciple-tools-three-thirds/disciple-tools-three-thirds.php' );
        activate_plugin( 'disciple-tools-meetings/disciple-tools-meetings.php' );
    }

    public function acting_as_admin() {
        $this->acting_as( 'administrator' );
    }

    public function acting_as( $role ) {
        global $wpdb;
        $wpdb->show_errors();
        $wpdb->insert( $wpdb->users, [
            'user_login' => $this->faker->name,
            'user_pass' => wp_generate_password(),
            'user_email' => $this->faker->email
        ] );
        wp_set_current_user( $wpdb->insert_id );
        $user = wp_get_current_user();
        $user->set_role( $role );
        return $user;
    }

    public function setUp() {
        global $wpdb;
        $wpdb->query( 'START TRANSACTION' );
        parent::setUp();
    }

    public function tearDown() {
        global $wpdb;
        $wpdb->query( 'ROLLBACK' );
        DT_33_Meetings_Repository::instance()->flush();
        parent::tearDown();
    }
}
