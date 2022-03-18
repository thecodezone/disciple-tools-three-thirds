<?php

class MeetingsEndpointTest extends TestCase {
    /**
     * Holds the WP REST Server object
     *
     * @var WP_REST_Server
     */
    private $server;

    /**
     * The dummy data
     * @var array
     */
    public $posts = [];

    /**
     * The meetings rest endpoint
     * @var string
     */
    public $endpoint = '';

    public function setUp() {
        $this->endpoint = '/' . Disciple_Tools_Three_Thirds_Endpoints::NAMESPACE . '/meetings';
        global $wp_rest_server;
        $this->server = $wp_rest_server = new \WP_REST_Server;
        do_action( 'rest_api_init' );
    }

    public function test_it_exists() {
        $this->acting_as_admin();
        $request = new WP_REST_Request( 'GET', $this->endpoint );
        $response = $this->server->dispatch( $request );
        $this->assertNotEquals(404, $response->get_status());
    }

    public function test_it_authorizes() {
        $this->acting_as('registered');
        $request = new WP_REST_Request( 'GET', $this->endpoint );
        $response = $this->server->dispatch( $request );
        $this->assertEquals(403, $response->get_status());
    }

    public function test_success() {
        $this->acting_as_admin();
        for ( $x = 0; $x < 5; $x++ ) {
            $posts[] = $this->factories->three_thirds_meeting();
        }
        $request = new WP_REST_Request( 'GET', $this->endpoint );
        $response = $this->server->dispatch( $request );
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertEquals(5, $data['total']);
        foreach($data['posts'] as $meeting) {
            $this->assertIsArray($meeting);
        }
    }

    public function test_it_only_returns_leaders_meetings() {
        $this->acting_as_admin();
        $leader_id = wp_create_user( $this->faker->userName, $this->faker->password, $this->faker->email );
        for ( $x = 0; $x < 5; $x++ ) {
            $posts[] = $this->factories->three_thirds_meeting([
                'assigned_to' => $leader_id
            ]);
        }
        for ( $x = 0; $x < 5; $x++ ) {
            $posts[] = $this->factories->three_thirds_meeting([
                'assigned_to' => get_current_user_id()
            ]);
        }
        $request = new WP_REST_Request( 'GET', $this->endpoint );
        $response = $this->server->dispatch( $request );
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertEquals(5, $data['total']);
    }
}

