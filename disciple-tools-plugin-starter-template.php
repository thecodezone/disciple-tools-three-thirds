<?php
/**
 * Plugin Name: Disciple Tools - Plugin Starter Template
 * Plugin URI: https://github.com/DiscipleTools/disciple-tools-plugin-starter-template
 * Description: Disciple Tools - Plugin Starter Template is intended to help developers and integrator jumpstart their extension of the Disciple Tools system.
 * Text Domain: disciple-tools-plugin-starter-template
 * Domain Path: /languages
 * Version:  1.3
 * Author URI: https://github.com/DiscipleTools
 * GitHub Plugin URI: https://github.com/DiscipleTools/disciple-tools-plugin-starter-template
 * Requires at least: 4.7.0
 * (Requires 4.7+ because of the integration of the REST API at 4.7 and the security requirements of this milestone version.)
 * Tested up to: 5.6
 *
 * @package Disciple_Tools
 * @link    https://github.com/DiscipleTools
 * @license GPL-2.0 or later
 *          https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Refactoring (renaming) this plugin as your own:
 * 1. @todo Refactor all occurrences of the name DT_Plugin_Starter, dt_plugin_starter, dt-plugin-starter, plugin-starter-template, starter_post_type, and Plugin Starter
 * 2. @todo Rename the `disciple-tools-plugin-starter-template.php and menu-and-tabs.php files.
 * 3. @todo Update the README.md and LICENSE
 * 4. @todo Update the default.pot file if you intend to make your plugin multilingual. Use a tool like POEdit
 * 5. @todo Change the translation domain to in the phpcs.xml your plugin's domain: @todo
 * 6. @todo Replace the 'sample' namespace in this and the rest-api.php files
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Gets the instance of the `DT_Plugin_Starter` class.
 *
 * @since  0.1
 * @access public
 * @return object|bool
 */
function dt_plugin_starter() {
    $dt_plugin_starter_required_dt_theme_version = '1.0';
    $wp_theme = wp_get_theme();
    $version = $wp_theme->version;

    /*
     * Check if the Disciple.Tools theme is loaded and is the latest required version
     */
    $is_theme_dt = strpos( $wp_theme->get_template(), "disciple-tools-theme" ) !== false || $wp_theme->name === "Disciple Tools";
    if ( $is_theme_dt && version_compare( $version, $dt_plugin_starter_required_dt_theme_version, "<" ) ) {
        add_action( 'admin_notices', 'dt_plugin_starter_hook_admin_notice' );
        add_action( 'wp_ajax_dismissed_notice_handler', 'dt_hook_ajax_notice_handler' );
        return false;
    }
    if ( !$is_theme_dt ){
        return false;
    }
    /**
     * Load useful function from the theme
     */
    if ( !defined( 'DT_FUNCTIONS_READY' ) ){
        require_once get_template_directory() . '/dt-core/global-functions.php';
    }

    /*
     * Don't load the plugin on every rest request. Only those with the 'sample' namespace
     */
    $is_rest = dt_is_rest();
    //@todo change 'sample' if you want the plugin to be set up when using rest api calls other than ones with the 'sample' namespace
    if ( ! $is_rest ){
        return DT_Plugin_Starter::instance();
    }
    // @todo remove this "else if", if you are not building the chart section
    else if ( strpos( dt_get_url_path(), 'metrics' ) !== false || ( $is_rest && strpos( dt_get_url_path(), 'dt-plugin-starter-metrics' ) !== false ) ){
        return DT_Plugin_Starter::instance();
    }
    // @todo remove this "else if", if not using rest-api.php
    else if ( strpos( dt_get_url_path(), 'dt_plugin_starter_template' ) !== false ) {
        return DT_Plugin_Starter::instance();
    }
    // @todo remove if not using a post type
    else if ( strpos( dt_get_url_path(), 'starter_post_type' ) !== false) {
        return DT_Plugin_Starter::instance();
    }
    return false;
}
add_action( 'after_setup_theme', 'dt_plugin_starter', 20 );

/**
 * Singleton class for setting up the plugin.
 *
 * @since  0.1
 * @access public
 */
class DT_Plugin_Starter {

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {

        /**
         * @todo Decide if you want to use the REST API example
         * To remove: delete this following line and remove the folder named /rest-api
         */
        require_once( 'rest-api/rest-api.php' ); // adds starter rest api class

        /**
         * @todo Decide if you want to create a new post type
         * To remove: delete the line below and remove the folder named /post-type
         */
        require_once( 'post-type/loader.php' ); // add starter post type extension to Disciple Tools system

        /**
         * @todo Decide if you want to create a custom site-to-site link
         * To remove: delete the line below and remove the folder named /site-link
         */
        require_once( 'site-link/custom-site-to-site-links.php' ); // add site to site link class and capabilities

        /**
         * @todo Decide if you want to add new charts to the metrics section
         * To remove: delete the line below and remove the folder named /charts
         */
        require_once( 'charts/charts-loader.php' );  // add custom charts to the metrics area

        /**
         * @todo Decide if you want to add a custom tile
         * To remove: delete the line below and remove the folder named /tile
         */
        require_once( 'tile/custom-tile.php' ); // add custom tile

        /**
         * @todo Decide if you want to add a custom admin page in the admin area
         * To remove: delete the 3 lines below and remove the folder named /admin
         */
        if ( is_admin() ) {
            require_once( 'admin/admin-menu-and-tabs.php' ); // adds starter admin page and section for plugin
        }

        /**
         * @todo Decide if you want to support localization of your plugin
         * To remove: delete the line below and remove the folder named /languages
         */
        add_action( 'after_setup_theme', array( $this, 'i18n' ), 51 ); // adds internationalize the text strings used.

        /**
         * @todo Decide if you want to support remote plugin updating with new versions of your plugin
         * To remove: delete the section of code below and delete the file called version-control.json in the plugin root
         *
         * This section runs the remote plugin updating service, so you can issue distributed updates to your plugin
         *
         * @note See the instructions for version updating to understand the steps involved.
         * @link https://github.com/DiscipleTools/disciple-tools-plugin-starter-template/wiki/Configuring-Remote-Updating-System
         *
         * @todo Enable this section with your own hosted file
         * @todo An example of this file can be found in (version-control.json)
         * @todo Github is a good option for delivering static json.
         */
        if ( is_admin() ){
            if ( ! class_exists( 'Puc_v4_Factory' ) ) {
                require( get_template_directory() . '/dt-core/libraries/plugin-update-checker/plugin-update-checker.php' );
            }

            // @todo change this url
            $hosted_json = "https://raw.githubusercontent.com/DiscipleTools/disciple-tools-plugin-starter-template/master/version-control.json";

            Puc_v4_Factory::buildUpdateChecker(
                $hosted_json,
                __FILE__,
                'disciple-tools-plugin-starter-template' // change this token
            );
        }

        /**
         * @todo Decide if you want to customize links for your plugin in the plugin admin area
         * To remove: delete the lines below and remove the function named
         */
        if ( is_admin() ) { // adds links to the plugin description area in the plugin admin list.
            add_filter( 'plugin_row_meta', [ $this, 'plugin_description_links' ], 10, 4 );
        }

    }

    /**
     * Filters the array of row meta for each/specific plugin in the Plugins list table.
     * Appends additional links below each/specific plugin on the plugins page.
     */
    public function plugin_description_links( $links_array, $plugin_file_name, $plugin_data, $status ) {
        if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
            // You can still use `array_unshift()` to add links at the beginning.

            $links_array[] = '<a href="https://disciple.tools">Disciple.Tools Community</a>'; // @todo replace with your links.
            // @todo add other links here
        }

        return $links_array;
    }

    /**
     * Method that runs only when the plugin is activated.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    public static function activation() {
        // @todo add elements here that need to fire on activation
    }

    /**
     * Method that runs only when the plugin is deactivated.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    public static function deactivation() {
        // @todo add functions here that need to happen on deactivation
        delete_option( 'dismissed-dt-plugin-starter' );
    }

    /**
     * Loads the translation files.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    public function i18n() {
        //Take from loadTextDomain() in /disciple-tools-theme/dt-core/libraries/plugin-update-checker/Puc/v4p5/UpdateChecker.php
        $domain = 'disciple-tools-plugin-starter-template'; // this must be the same as the slug for the plugin
        $locale = apply_filters(
            'plugin_locale',
            ( is_admin() && function_exists( 'get_user_locale' ) ) ? get_user_locale() : get_locale(),
            $domain
        );

        $mo_file = $domain . '-' . $locale . '.mo';
        $path = realpath( dirname( __FILE__ ) . '/languages' );

        if ($path && file_exists( $path )) {
            load_textdomain( $domain, $path . '/' . $mo_file );
        }
    }

    /**
     * Magic method to output a string if trying to use the object as a string.
     *
     * @since  0.1
     * @access public
     * @return string
     */
    public function __toString() {
        return 'disciple-tools-plugin-starter-template';
    }

    /**
     * Magic method to keep the object from being cloned.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, 'Whoah, partner!', '0.1' );
    }

    /**
     * Magic method to keep the object from being unserialized.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, 'Whoah, partner!', '0.1' );
    }

    /**
     * Magic method to prevent a fatal error when calling a method that doesn't exist.
     *
     * @param string $method
     * @param array $args
     * @return null
     * @since  0.1
     * @access public
     */
    public function __call( $method = '', $args = array() ) {
        _doing_it_wrong( "dt_plugin_starter::" . esc_html( $method ), 'Method does not exist.', '0.1' );
        unset( $method, $args );
        return null;
    }
}


// Register activation hook.
register_activation_hook( __FILE__, [ 'DT_Plugin_Starter', 'activation' ] );
register_deactivation_hook( __FILE__, [ 'DT_Plugin_Starter', 'deactivation' ] );


if ( ! function_exists( 'dt_plugin_starter_hook_admin_notice' ) ) {
    function dt_plugin_starter_hook_admin_notice() {
        global $dt_plugin_starter_required_dt_theme_version;
        $wp_theme = wp_get_theme();
        $current_version = $wp_theme->version;
        $message = "'Disciple Tools - Plugin Starter' plugin requires 'Disciple Tools' theme to work. Please activate 'Disciple Tools' theme or make sure it is latest version.";
        if ( $wp_theme->get_template() === "disciple-tools-theme" ){
            $message .= ' ' . sprintf( esc_html( 'Current Disciple Tools version: %1$s, required version: %2$s' ), esc_html( $current_version ), esc_html( $dt_plugin_starter_required_dt_theme_version ) );
        }
        // Check if it's been dismissed...
        if ( ! get_option( 'dismissed-dt-plugin-starter', false ) ) { ?>
            <div class="notice notice-error notice-dt-plugin-starter is-dismissible" data-notice="dt-plugin-starter">
                <p><?php echo esc_html( $message );?></p>
            </div>
            <script>
                jQuery(function($) {
                    $( document ).on( 'click', '.notice-dt-plugin-starter .notice-dismiss', function () {
                        $.ajax( ajaxurl, {
                            type: 'POST',
                            data: {
                                action: 'dismissed_notice_handler',
                                type: 'dt-plugin-starter',
                                security: '<?php echo esc_html( wp_create_nonce( 'wp_rest_dismiss' ) ) ?>'
                            }
                        })
                    });
                });
            </script>
        <?php }
    }
}

/**
 * AJAX handler to store the state of dismissible notices.
 */
if ( ! function_exists( "dt_hook_ajax_notice_handler" )){
    function dt_hook_ajax_notice_handler(){
        check_ajax_referer( 'wp_rest_dismiss', 'security' );
        if ( isset( $_POST["type"] ) ){
            $type = sanitize_text_field( wp_unslash( $_POST["type"] ) );
            update_option( 'dismissed-' . $type, true );
        }
    }
}
