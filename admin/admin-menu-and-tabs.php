<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * TODO: 1.1
 * Class Disciple_Tools_Plugin_Starter_Template_Menu
 */
class Disciple_Tools_Three_Thirds_Settings_Menu {

    public $token = 'dt33_settings';
    public $page_title = '3/3rds Meetings';
    private $utilities;
    private static $_instance = null;

    /**
     * Disciple_Tools_Plugin_Starter_Template_Menu Instance
     *
     * Ensures only one instance of Disciple_Tools_Plugin_Starter_Template_Menu is loaded or can be loaded.
     *
     * @return Disciple_Tools_Plugin_Starter_Template_Menu instance
     * @since 0.1.0
     * @static
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()


    /**
     * Constructor function.
     * @access  public
     * @since   0.1.0
     */
    public function __construct() {

        $this->utilities = DT_33_Utilities::instance();

        add_action( "admin_menu", [ $this, "register_menu" ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

        $nonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( $_POST['_wpnonce'] ) : null;
        $verify_nonce = $nonce && wp_verify_nonce( $nonce, 'dt33_settings' );

        if ( $verify_nonce ) {
            // Change Custom Logo URL
            if ( isset( $_POST['custom_logo_url'] ) ) {

                $custom_logo_url = esc_url( sanitize_text_field( wp_unslash( $_POST['custom_logo_url'] ) ) );
                $this->utilities->add_or_update_option( 'dt33_logo_url', $custom_logo_url );
            }

            if ( isset( $_POST['default_logo_url'] ) ) {
                delete_option( 'dt33_logo_url' );
            }
            if ( isset( $_POST['dt33_redirect_path'] ) ) {
                //phpcs ignore
                $this->utilities->add_or_update_option( 'dt33_redirect_path', sanitize_text_field( wp_unslash( $_POST['dt33_redirect_path'] ) ) );
            }
            if ( isset( $_POST['dt33_allow_dt_access'] ) ) {
                $this->utilities->add_or_update_option( 'dt33_allow_dt_access', sanitize_key( $_POST['dt33_allow_dt_access'] ) );
            } else {
                $this->utilities->add_or_update_option( 'dt33_allow_dt_access', 'off' );
            }
        }

    } // End __construct()

    public function admin_enqueue_scripts() {
        wp_enqueue_script( 'lodash' );
    }


    /**
     * Loads the subnav page
     * @since 0.1
     */


    public function register_menu() {
        add_submenu_page( 'dt_extensions', $this->page_title, $this->page_title, 'manage_dt', $this->token, [ $this, 'content' ] );
    }

    /**
     * Menu stub. Replaced when Disciple.Tools Theme fully loads.
     */
    public function extensions_menu() {
    }

    /**
     * Builds page contents
     * @since 0.1
     */
    public function content() {

        if ( !current_user_can( 'manage_dt' ) ) { // manage dt is a permission that is specific to Disciple.Tools and allows admins, strategists and dispatchers into the wp-admin
            wp_die( 'You do not have sufficient permissions to access this page.' );
        }

        if ( isset( $_GET["tab"] ) ) {
            $tab = sanitize_key( wp_unslash( $_GET["tab"] ) );
        } else {
            $tab = 'general';
        }

        $link = 'admin.php?page=' . $this->token . '&tab=';

        ?>
        <div class="wrap">
            <h2><?php echo esc_html( $this->page_title ) ?></h2>
            <?php
            $object = new Disciple_Tools_Three_Thirds_Settings_Tab_General();
            $object->content();
            ?>


        </div><!-- End wrap -->

        <?php
    }
}

Disciple_Tools_Three_Thirds_Settings_Menu::instance();

require_once 'general-tab.php';
