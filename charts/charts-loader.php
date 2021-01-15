<?php

class DT_Starter_Charts
{
    private static $_instance = null;
    public static function instance(){
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct(){
        // Load required files
        require_once( 'one-page-chart-template.php' );

        new DT_Starter_Chart_Template();

    } // End __construct
}
DT_Starter_Charts::instance();
