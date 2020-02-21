<?php

/**
* @link              https://andrewbarber.me
* @since             0.1
* @package           rocketchat-exta-settings
*
* @wordpress-plugin
* Plugin Name: Extra Settings for RocketChat
* Plugin URI: https://andrewbarber.me

* Description: Extra settings for Rocket.Chat's Wordpress plugin. Helps display better on sites that have WooCommerce activated, adjust if data is collected from signed in users and more.
* Version: 0.1
* Author: Andrew A. Barber
* Author URI: https://andrewbarber.me/
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: rocketchat-extra-settings
**/

if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Helper Functions
 */

/**
 * A helper function to check if a plugin is active
 */

function check_for_plugin($pluginName){
    if(in_array($pluginName . '/' . $pluginName .'.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
        return true;    
    } else {
        return false;
    } 
}

/**
 * Screen and Setting adujstments for WP-Admin.
 */
add_action('admin_menu', 'rx_x_sttngs_setup_menu');

function rx_x_sttngs_setup_menu(){
    add_menu_page( 'RocketChat Extra Settings', 'RocketChat Settings', 'manage_options', 'rocketchat-exta-settings', 'rx_x_sttngs_admin_page_init', 'dashicons-format-chat' );
    add_action( 'admin_init', 'register_rx_x_sttngs' );
}

function register_rx_x_sttngs(){
    register_setting( 'rx_x_sttngs', 'rx_x_sttngs_username_pull' );
    register_setting( 'rx_x_sttngs', 'rx_x_sttngs_email_pull' );
    register_setting( 'rx_x_sttngs', 'rx_x_sttngs_display_chat_in_footer' );
    register_setting( 'rx_x_sttngs', 'rx_x_sttngs_display_chat_above_footer' );
    register_setting( 'rx_x_sttngs', 'rx_x_sttngs_rc_url' );
    register_setting( 'rx_x_sttngs', 'rx_x_sttngs_rc_old' );
}

function rx_x_sttngs_admin_page_init(){
    ?>
    <div class="wrap">
        <h1>Rocket Chat Extra Settings</h1>
        <p>If you like this plugin, please consider <a href="https://www.buymeacoffee.com/AndrewBarber" target="_blank">buying me a ☕  Coffee</a>!
        <br/><br/>
        <h2>Rocket.Chat Plugin Status</h2>
        <p>
            <?php echo (!check_for_plugin('rocketchat-livechat')) ? '<span class="dashicons dashicons-yes-alt" style="color: green;"></span> All systems are go!' : '<span class="dashicons dashicons-no-alt" style="color: red;"></span> Please delete (or deactivate) the <a href="plugins.php">original (and outdated) Rocket.Chat LiveChat plugin</a> first.'; ?> 
        </p>
        <br/>
        <?php
        if (!check_for_plugin('rocketchat-livechat')){
        ?>
            <h2>ShortCode</h2>
            <p>You can use the following <a href="https://support.wordpress.com/shortcodes/" target="_blank">ShortCode</a> to create a button to start a new LiveChat.</p>
            <p><code>[rocketchat title='Open Support Chat']</code></p>
            <p>Example...<br/>
                <button type="button" class="btn" id="rx_x_sttngs_shortcode_btn">Open Support Chat <span class="dashicons dashicons-format-status"></span></button>
            </p>
            <br/>
            <h2>Settings</h2>
            <form method="post" action="options.php">
            <?php settings_fields( 'rx_x_sttngs' ); ?>
            <?php do_settings_sections( 'rx_x_sttngs' ); ?>
            <?php $checked = ($options == 'true' ? ' checked="checked"' : ''); ?>
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">RocketChat URL</th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>RocketChat URL</span></legend>
                                    <label for="rx_x_sttngs_rc_url">
                                        <input type="text" name="rx_x_sttngs_rc_url" value="<?php echo get_option('rx_x_sttngs_rc_url') ?>" placeholder="eg. https://chat.domain.tld/" id="rx_x_sttngs_rc_url" size="100" class="" />
                                    </label>
                                    <br />
                                    <label for="rx_x_sttngs_rc_old">
                                        <input name="rx_x_sttngs_rc_old" type="checkbox" id="rx_x_sttngs_rc_old" value="1" <?php checked(1, get_option('rx_x_sttngs_rc_old'), true); ?> />
                                        I use an old version of Rocket.Chat (v1.5 and below)
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">User Details<br/>(for registered users)</th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>User Details for registered users</span></legend>
                                    <label for="rx_x_sttngs_username_pull">
                                        <input name="rx_x_sttngs_username_pull" type="checkbox" id="rx_x_sttngs_username_pull" value="1" <?php checked(1, get_option('rx_x_sttngs_username_pull'), true); ?> />
                                        Use first and surname (username if not set)
                                    </label>
                                    <br />
                                    <label for="rx_x_sttngs_email_pull">
                                        <input name="rx_x_sttngs_email_pull" type="checkbox" id="rx_x_sttngs_email_pull" value="1" <?php checked(1, get_option('rx_x_sttngs_email_pull'), true); ?> />
                                        Use email address
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
                        <?php 
                        if (check_for_plugin('woocommerce')){
                        ?>
                            <tr>
                                <th scope="row">Display Settings<br/>(WooCommerce)</th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Display Settings</span></legend>
                                        <label for="rx_x_sttngs_display_chat_in_footer">
                                            <input name="rx_x_sttngs_display_chat_in_footer" type="checkbox" id="rx_x_sttngs_display_chat_in_footer" value="1" <?php checked(1, get_option('rx_x_sttngs_display_chat_in_footer'), true); ?> />
                                            Show chat in the footer bar (on mobile)
                                        </label>
                                        <br />
                                        <label for="rx_x_sttngs_display_chat_above_footer">
                                            <input name="rx_x_sttngs_display_chat_above_footer" type="checkbox" id="rx_x_sttngs_display_chat_above_footer" value="1" <?php checked(1, get_option('rx_x_sttngs_display_chat_above_footer'), true); ?> />
                                            Show chat above the footer bar (on mobile)
                                        </label>
                                    </fieldset>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php submit_button(); ?>
            </form>
        <?php 
        }
        ?>
    </div>
    <?php
}

/**
 * Cofffffffeeeeeeeeeeeeeeeeeeee is life. ☕
 */
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'salcode_add_plugin_page_settings_link');
function salcode_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="https://www.buymeacoffee.com/AndrewBarber" target="_blank">☕  Coffee</a>';
	return $links;
}



/**
 * Pull RocketChat in
 */

add_action('wp_body_open', 'load_rocketchat');
function load_rocketchat(){
    $rx_x_sttngs_rc_url = esc_url( trailingslashit(get_option('rx_x_sttngs_rc_url')));
    $rx_x_sttngs_rc_old = get_option('rx_x_sttngs_rc_old');
    if (!check_for_plugin('rocketchat-livechat')){
        if(!(isset($rx_x_sttngs_rc_url) === true && $rx_x_sttngs_rc_url === '')){
            if($rx_x_sttngs_rc_old){
                echo '
                <!-- Start of Rocket.Chat Livechat Script -->
                <script type="text/javascript">
                (function(w, d, s, u) {
                    w.RocketChat = function(c) { w.RocketChat._.push(c) }; w.RocketChat._ = []; w.RocketChat.url = u;
                    var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
                    j.async = false; j.src = "' . $rx_x_sttngs_rc_url . 'livechat/1.0.0/rocketchat-livechat.min.js?_=201903270000";
                    h.parentNode.insertBefore(j, h);
                })(window, document, "script", "' . $rx_x_sttngs_rc_url . 'livechat");
                </script>
                <!-- End of Rocket.Chat Livechat Script -->
                ';
            } else {
                echo '
                <!-- Start of Rocket.Chat Livechat Script -->
                <script type="text/javascript">
                (function(w, d, s, u) {
                    w.RocketChat = function(c) { w.RocketChat._.push(c) }; w.RocketChat._ = []; w.RocketChat.url = u;
                    var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
                    j.async = false; j.src = "' . $rx_x_sttngs_rc_url . 'livechat/rocketchat-livechat.min.js?_=201903270000";
                    h.parentNode.insertBefore(j, h);
                })(window, document, "script", "' . $rx_x_sttngs_rc_url . 'livechat");
                </script>
                <!-- End of Rocket.Chat Livechat Script -->
                ';
            }
        }
    }
}


/**
 * Choose if we pull registered users details into rocket.chat
 */
add_action( 'wp_enqueue_scripts', 'add_user_details_to_rocketchat' );
function add_user_details_to_rocketchat(){
    $rx_x_sttngs_username_pull = get_option('rx_x_sttngs_username_pull');
    $rx_x_sttngs_email_pull = get_option('rx_x_sttngs_email_pull');
    if ($rx_x_sttngs_username_pull || $rx_x_sttngs_email_pull ){
        $user_id = get_current_user_id(); 
        $user_info = get_userdata($user_id);
        $userName = $user_info->first_name ? $user_info->first_name . ' ' . $user_info->last_name : $user_info->user_login;
        $userEmail = $user_info->user_email;
        
        echo '<script>
        window.onload = function(){';
        if ($rx_x_sttngs_username_pull){
            echo '
            RocketChat(function() {
                this.setGuestName("' . $userName . '");
            });';
        }
        if ($rx_x_sttngs_email_pull){
            echo '
            RocketChat(function() {
                this.setGuestEmail("' . $userEmail . '");
            });';
        }
        echo '
        }
        </script>';
    }
}

/**
 * Add an extra space onto the handheld footer bar
 */

add_action( 'storefront_handheld_footer_bar_links', 'display_chat_footer' );
function display_chat_footer($links){
    $rx_x_sttngs_display_chat_in_footer = get_option('rx_x_sttngs_display_chat_in_footer');

    if($rx_x_sttngs_display_chat_in_footer && check_for_plugin('woocommerce')){
        $new_links = array(
            'rocketchat' => array(
                'priority' => 10,
                'callback' => 'add_rt_link',
            ),
        );

        $links = array_merge( $new_links, $links );
    }         
    return $links;

}

/**
 * Add an extra item into the handheld footer bar for RocketChat
 */

function add_rt_link() {
    echo '<a href="#" id="loadRocketChatButton">' . __( 'RocketChat' ) . '<!-- TODO: LiveChat Offline/Online (See: https://forums.rocket.chat/t/livechat-status-online-offline/5906)  <span class="count"></span>--></a>';

    echo '
    <script>
	    window.onload = function(){

	        window.mobilecheck = () => {
                let check = false;
                (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
                return check;
            };
        
            if(window.mobilecheck()){
                document.getElementsByClassName("rocketchat-widget")[0].style.width = "1px";
                document.getElementsByClassName("rocketchat-widget")[0].style.height = "1px";
            }
        
            RocketChat(function() {
                if(window.mobilecheck()){
                    this.onChatMinimized(function() {
                        document.getElementsByClassName("rocketchat-widget")[0].style.width = "1px";
                        document.getElementsByClassName("rocketchat-widget")[0].style.height = "1px";
                    });
                }
            });

            document.getElementById("loadRocketChatButton").addEventListener("click", () => {
                RocketChat(function() {
                    this.maximizeWidget();
                });
            });
        }
    </script>
    ';

}

add_action('wp_enqueue_scripts', 'rx_x_sttngs_display_chat_in_footer_styles');
function rx_x_sttngs_display_chat_in_footer_styles() {
    $rx_x_sttngs_display_chat_in_footer = get_option('rx_x_sttngs_display_chat_in_footer');

    if($rx_x_sttngs_display_chat_in_footer && check_for_plugin('woocommerce')){
        wp_enqueue_style( 'rt_x_settings', plugin_dir_url( __FILE__ ) . 'css/rx_x_sttngs_display_chat_in_footer.css' );
    }
}

/**
 * Bump the icon above the footer bar
 */

add_action('wp_enqueue_scripts', 'rx_x_sttngs_display_chat_above_footer_styles');
function rx_x_sttngs_display_chat_above_footer_styles() {
    $rx_x_sttngs_display_chat_above_footer = get_option('rx_x_sttngs_display_chat_above_footer');

    if($rx_x_sttngs_display_chat_above_footer && check_for_plugin('woocommerce')){
        wp_enqueue_style( 'rt_x_settings', plugin_dir_url( __FILE__ ) . 'css/rx_x_sttngs_display_chat_above_footer.css' );
        echo '
        <script>
        window.onload = function(){

            RocketChat(function() {
                this.onChatMaximized(function() {
                    document.getElementsByClassName("rocketchat-widget")[0].style.marginBottom = "0";
                });
                this.onChatMinimized(function() {
                    document.getElementsByClassName("rocketchat-widget")[0].style.marginBottom = "60px";
                });
            });
        }
        </script>';
    }
}

/**
 * ShortCode Button
 */

add_shortcode('rocketchat', 'rx_x_sttngs_shortcode');
function rx_x_sttngs_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'title' => 'Live Chat',
    ), $atts, 'rocketchat' );

    return '<button type="button" class="btn" id="rx_x_sttngs_shortcode_btn" onClick="RocketChat(function() {this.maximizeWidget();});">'. $atts['title'] .' <span class="dashicons dashicons-format-status"></span></button>';
}

/**
 * Ensure DashIcons are used on frontend too
 */

add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
	wp_enqueue_style( 'dashicons' );
}




?>