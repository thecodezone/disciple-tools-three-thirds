<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * Class Disciple_Tools_Plugin_Starter_Template_Menu
 */
class Disciple_Tools_Three_Thirds_Settings_Menu {

    public $token = 'dt33_settings';
    public $page_title = 'Disciple Tools Three-Thirds Settings';

    private static $_instance = null;

    /**
     * Disciple_Tools_Plugin_Starter_Template_Menu Instance
     *
     * Ensures only one instance of Disciple_Tools_Plugin_Starter_Template_Menu is loaded or can be loaded.
     *
     * @since 0.1.0
     * @static
     * @return Disciple_Tools_Plugin_Starter_Template_Menu instance
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


        add_action( "admin_menu", array( $this, "register_menu" ) );

        $this->page_title = __( "Disciple Tools Three-Thirds Settings", 'disciple-tools-plugin-starter-template' );

        if ( isset( $_POST['dt33_icon'] ) && isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ) ) )
            {
            update_option( 'dt33_icon', sanitize_key( $_POST['dt33_icon'] ) );
        }
        if ( isset( $_POST['dt33_redirect_path'] ) && isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ) ) )
            {
            update_option( 'dt33_redirect_path', sanitize_key( $_POST['dt33_redirect_path'] ) );
        }
        if ( isset( $_POST['dt33_allow_dt_access'] ) && isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ) ) && $_POST['dt33_allow_dt_access'] =='on' )
            {
            update_option( 'dt33_allow_dt_access', sanitize_key( $_POST['dt33_allow_dt_access'] ) );
        }
        else {
            update_option( 'dt33_allow_dt_access', '' );
        }


    } // End __construct()


    /**
     * Loads the subnav page
     * @since 0.1
     */



    public function register_menu() {
        $this->page_title = __( "Disciple Tools Three-Thirds Settings", 'disciple-tools-plugin-starter-template' );

        add_submenu_page( 'dt_extensions', $this->page_title, $this->page_title, 'manage_dt', $this->token, [ $this, 'content' ] );

        add_action( 'dt33_admin_init', 'update_dt33_settings' );
    }

    public function update_dt33_settings() {
        register_setting( 'dt33_icon', 'dt33_redirect_path', 'dt33_allow_dt_access' );
    }

    /**
     * Menu stub. Replaced when Disciple.Tools Theme fully loads.
     */
    public function extensions_menu() {}

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

        $link = 'admin.php?page='.$this->token.'&tab=';

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

/**
 * Class Disciple_Tools_Plugin_Starter_Template_Tab_General
 */
class Disciple_Tools_Three_Thirds_Settings_Tab_General {
    public function content() {
        ?>
        <div class="wrap">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <!-- Main Column -->

                        <?php $this->main_column() ?>

                        <!-- End Main Column -->
                    </div><!-- end post-body-content -->
                    <div id="postbox-container-1" class="postbox-container">
                        <!-- Right Column -->

                        <?php $this->right_column() ?>

                        <!-- End Right Column -->
                    </div><!-- postbox-container 1 -->
                    <div id="postbox-container-2" class="postbox-container">
                    </div><!-- postbox-container 2 -->
                </div><!-- post-body meta box container -->
            </div><!--poststuff end -->
        </div><!-- wrap end -->
        <?php
    }

    public function main_column() {

        ?>
        <!-- Box -->
        <table class="widefat striped">
            <thead>
                <tr>
                    <th colspan=2>General Settings</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <form method="POST">
                        <?php settings_fields( 'info-settings' ); ?>
                        <?php do_settings_sections( 'info-setting' ); ?>
                            <table class="widefat">
                                <tr>
                                    <td>Icon:</td>
                                    <td><input type="file" name="dt33_icon" accept="image/*" style="width:100%"><small>Upload a custom logo or icon to display in the 3/3rds magic link menu and above the login form.</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Redirect Path: </td>
                                    <td><input name="dt33_redirect_path"type="text" style="width:100%" value="<?php echo esc_attr( get_option( 'dt33_redirect_path' ) );?>"><small>A URL path that redirects users to the login page or magic link. Default <em>/3/3</em></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Allow DT access for new users?</td>
                                    <td><input type="checkbox" name="dt33_allow_dt_access" <?php checked( get_option( 'dt33_allow_dt_access' ), 'on' );?>><small><br>Allow users registered through the magic link registration form to also access disciple tools.</small></td>
                                </tr>
                            </table>
                            <br>
                            <span style="float:right">
                                <button type="submit" class="button float-right">Save</button>
                            </span>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <!-- End Box -->
        <?php
    }

    public function right_column() {

        ?>
        <!-- Box -->

        <!-- End Box -->
        <?php
    }
}


/**
 * Class Disciple_Tools_Plugin_Starter_Template_Tab_Second
 */
class Disciple_Tools_Three_Thirds_Settings_Tab_Second {
    public function content() {
        ?>
        <div class="wrap">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <!-- Main Column -->

                        <?php $this->main_column() ?>

                        <!-- End Main Column -->
                    </div><!-- end post-body-content -->
                    <div id="postbox-container-1" class="postbox-container">
                        <!-- Right Column -->

                        <?php $this->right_column() ?>

                        <!-- End Right Column -->
                    </div><!-- postbox-container 1 -->
                    <div id="postbox-container-2" class="postbox-container">
                    </div><!-- postbox-container 2 -->
                </div><!-- post-body meta box container -->
            </div><!--poststuff end -->
        </div><!-- wrap end -->
        <?php
    }

    public function main_column() {
        ?>
        <!-- Box -->
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Header</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Content
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <!-- End Box -->
        <?php
    }

    public function right_column() {
        ?>
        <!-- Box -->
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Information</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    Content
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <!-- End Box -->
        <?php
    }
}

