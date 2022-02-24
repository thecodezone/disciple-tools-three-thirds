<?php

class ApiTest extends TestCase
{
    /**
     * Holds the WP REST Server object
     *
     * @var WP_REST_Server
     */
    private $server;

    public $posts = [];

    /**
     * Create a user and a post for our test.
     */
    public function setUp() {;
        // Initiating the REST API.
        global $wp_rest_server;
        $this->server = $wp_rest_server = new \WP_REST_Server;
        do_action( 'rest_api_init' );
        $this->actingAsAdmin();

        for ( $x = 0; $x < 30; $x++ ) {
            $this->posts[] = $this->three_thirds_meeting();
        }
    }

    public function test_has_meetings() {
        $this->assertCount(30, $this->posts);
        foreach ($this->posts as $post) {
            $this->assertArrayHasKey('post_type', $post);
            $this->assertEquals( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, $post['post_type'] );
        }
    }

    public function test_it_fetches_meetings() {
        $request  = new WP_REST_Request( 'GET', '/d9/v1/author/' . $this->user_id );

        $this->assertCount(30, $this->posts);
        foreach ($this->posts as $post) {
            $this->assertArrayHasKey('post_type', $post);
            $this->assertEquals( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, $post['post_type'] );
        }
    }
}

