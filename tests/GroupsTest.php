<?php

/**
 * Class TestCase \PHPUnit\Framework\TestCase
 */
class GroupsTest extends TestCase {
    public function test_it_can_get_groups_with_meetings() {
        $this->acting_as_admin();

        $group = $this->factories->group();

        for ( $x = 0; $x < 2; $x++ ) {
            $this->factories->three_thirds_meeting( [
                'groups' => [
                    'values' => [ [ "value" => $group['ID'] ] ]
                ]
            ] );
        }
        $this->assertEquals( 1, count( DT_33_Groups_Repository::instance()->all() ) );
        $group = $this->factories->group();
        for ( $x = 0; $x < 3; $x++ ) {
            $this->factories->three_thirds_meeting( [
                'groups' => [
                    'values' => [ [ "value" => $group['ID'] ] ]
                ]
            ] );
        }
        for ( $x = 0; $x < 2; $x++ ) {
            $this->factories->group();
        }
        $groups = DT_33_Groups_Repository::instance()->with_meetings();
        $this->assertEquals( 2, count( $groups ) );
    }

    public function test_it_can_find_groups() {
        $this->acting_as_admin();
        $group = $this->factories->group();
        for ( $x = 0; $x < 3; $x++ ) {
            $this->factories->three_thirds_meeting( [
                'groups' => [
                    'values' => [ [ "value" => $this->factories->group()['ID'] ] ]
                ]
            ] );
        }
        $this->factories->three_thirds_meeting( [
            'groups' => [
                'values' => [ [ "value" => $group['ID'] ] ]
            ]
        ] );
        $this->assertEquals( $group['ID'], DT_33_Groups_Repository::instance()->find( $group['ID'] )['ID'] );
    }

    public function test_it_can_create_groups() {
        $this->acting_as_admin();

        $group = DT_33_Groups_Repository::instance()->create( [
            'title' => $this->faker->sentence
        ] );

        $post = DT_Posts::get_post('groups', $group['ID']);

        $this->assertEquals( $group['ID'], $post['ID'] );
    }
}
