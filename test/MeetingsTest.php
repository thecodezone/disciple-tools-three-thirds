<?php

class MeetingsTest extends TestCase {
    public function test_it_has_meetings() {
        $this->acting_as_admin();
        $post = $this->factories->three_thirds_meeting();
        $this->assertArrayHasKey( 'post_type', $post );
        $this->assertEquals( Disciple_Tools_Three_Thirds_Meeting_Type::POST_TYPE, $post['post_type'] );
    }

    public function test_meetings_have_fields() {
        $this->acting_as_admin();
        $post = $this->factories->three_thirds_meeting();
        $this->assertArrayHasKey('three_thirds_looking_back_content', $post);
    }
}
