<?php

class PluginTest extends TestCase
{
    /**
     * @test
     */
    public function test_plugin_installed() {
        activate_plugin( 'disciple-tools-three-thirds/disciple-tools-three-thirds.php' );

        $this->assertContains(
            'disciple-tools-three-thirds/disciple-tools-three-thirds.php',
            get_option( 'active_plugins' )
        );
    }
}

