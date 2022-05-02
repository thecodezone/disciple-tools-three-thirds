<?php

/**
 * Class TestCase \PHPUnit\Framework\TestCase
 */
class MeetingsTest extends TestCase {
    public function test_it_has_meetings() {
        $this->acting_as_admin();
        $post = $this->factories->three_thirds_meeting();
        $this->assertArrayHasKey( 'post_type', $post );
        $this->assertEquals( DT_33_Meeting_Type::POST_TYPE, $post['post_type'] );
    }

    public function test_meetings_have_fields() {
        $this->acting_as_admin();
        $post = $this->factories->three_thirds_meeting();
        $this->assertArrayHasKey( 'three_thirds_looking_back_content', $post );
    }

    public function test_it_can_query_meetings() {
        $this->acting_as_admin();
        $count = 10;
        for ( $x = 0; $x < $count; $x++ ) {
            $this->factories->three_thirds_meeting();
        }
        $this->assertEquals( $count, count( DT_33_Meetings_Repository::instance()->all() ) );
    }

    public function test_only_includes_33_meetings() {
        $this->acting_as_admin();
        $count = 3;
        for ( $x = 0; $x < 4; $x++ ) {
            $this->factories->meeting();
        }
        for ( $x = 0; $x < $count; $x++ ) {
            $this->factories->three_thirds_meeting();
        }
        $this->assertEquals( $count, count( DT_33_Meetings_Repository::instance()->all() ) );
    }

    public function test_it_search_meetings() {
        $this->acting_as_admin();
        $this->factories->three_thirds_meeting( [
            'name' => 'title with needle'
        ] );
        $this->factories->three_thirds_meeting( [
            'name' => 'title has needle'
        ] );
        for ( $x = 0; $x < 5; $x++ ) {
            $this->factories->three_thirds_meeting();
        }
        $this->assertEquals(
            2,
            count( DT_33_Meetings_Repository::instance()->filtered( 'needle' ) )
        );
    }

    public function test_it_can_filter_out_groups() {
        $this->acting_as_admin();
        $count = 5;
        for ( $x = 0; $x < 3; $x++ ) {
            $this->factories->three_thirds_meeting( [
                'groups' => [
                    'values' => [ [ "value" => $this->factories->group()['ID'] ] ]
                ]
            ] );
        }

        for ( $x = 0; $x < $count; $x++ ) {
            $this->factories->three_thirds_meeting();
        }

        $this->assertEquals(
            $count,
            count( DT_33_Meetings_Repository::instance()->filtered( '', 'NO_GROUP' ) )
        );
    }

    public function test_it_can_filter_groups() {
        $this->acting_as_admin();
        $count = 2;
        $group = $this->factories->group();
        for ( $x = 0; $x < 3; $x++ ) {
            $this->factories->three_thirds_meeting( [
                'groups' => [
                    'values' => [ [ "value" => $this->factories->group()['ID'] ] ]
                ]
            ] );
        }

        for ( $x = 0; $x < $count; $x++ ) {
            $this->factories->three_thirds_meeting( [
                'groups' => [
                    'values' => [ [ "value" => $group['ID'] ] ]
                ]
            ] );
        }

        for ( $x = 0; $x < 3; $x++ ) {
            $this->factories->three_thirds_meeting();
        }

        $this->assertEquals(
            $count,
            count( DT_33_Meetings_Repository::instance()->filtered( '', $group['ID'] ) )
        );
    }

    public function test_it_can_filter_series() {
        $this->acting_as_admin();
        $count = 2;
        $series = 'series title';
        for ( $x = 0; $x < 3; $x++ ) {
            $this->factories->three_thirds_meeting( [
                'series' => [
                    'values' => [ [ "value" => 'some other series' ] ]
                ]
            ] );
        }

        for ( $x = 0; $x < $count; $x++ ) {
            $this->factories->three_thirds_meeting( [
                'series' => [
                    'values' => [ [ "value" => $series ] ]
                ]
            ] );
        }

        for ( $x = 0; $x < 3; $x++ ) {
            $this->factories->three_thirds_meeting();
        }

        $this->assertEquals(
            $count,
            count( DT_33_Meetings_Repository::instance()->filtered( '', $series ) )
        );
    }

    public function test_it_can_find_a_meeting() {
        $this->acting_as_admin();
        $meeting = $this->factories->three_thirds_meeting();
        $this->assertEquals( $meeting['ID'], DT_33_Meetings_Repository::instance()->find( $meeting['ID'] )['ID'] );
    }
}
