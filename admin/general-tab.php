<?php

/**
 * TODO 1.1
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

    public function custom_logo() {
        $custom_logo_url = get_option( 'dt33_logo_url' );
        $logo_url = DT_33::$url . '/images/icon.png';
        if ( ! empty( $custom_logo_url ) ) {
            $logo_url = $custom_logo_url;
        }
        ?>
        <table class="widefat striped">
            <thead>
            <tr>
                <td><?php esc_html_e( 'Logo', 'dt33' ); ?></td>
                <td><?php esc_html_e( 'Logo link (must be https)', 'dt33' ); ?></td>
                <td></td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><img height="22px" style="vertical-align:-webkit-baseline-middle;" src="<?php echo esc_html( $logo_url ); ?>"></td>
                <td><input type="text" name="custom_logo_url" value="<?php echo esc_html( $logo_url ); ?>"></td>
                <td><button class="button" name="default_logo_url">Default</button></td>
                <td><button class="button file-upload-display-uploader" data-form="dt33_settings" data-icon-input="custom_logo_url" style="margin-left:1%"><?php esc_html_e( 'Upload', 'disciple_tools' ); ?></button></td>
            </tr>
            <tr>
                <td colspan="4">
                </td>
            </tr>
            </tbody>
        </table>
        <small>Upload a custom logo or icon to display in the 3/3rds magic link menu and above the login form.</small>

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
                    <form method="POST" name="dt33_settings">
                        <?php wp_nonce_field( 'dt33_settings' ); ?>
                        <table class="widefat">
                            <tr>
                                <td>logo:</td>
                                <td>
                                    <?php $this->custom_logo(); ?>
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

