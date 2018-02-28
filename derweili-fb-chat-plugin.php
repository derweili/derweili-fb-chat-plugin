<?php
/**
 * Plugin Name:     Facebook Chat Opt-In
 * Description:     Facebook Chat Opt-In Plugin
 * Author:          derweili
 * Author URI:      http://derweili.de
 * Text Domain:     derweili-fb-chat-plugin
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Derweili_Fb_Chat_Plugin
 */

// Your code starts here.


class Derweili_FB_Chat_Plugin
{

    /*
     * @version
     */
    private $version = '0.1';

    /*
     * @slug
     */
    private $slug = 'derweili-fb-chat-plugin';

    private $plugin_dir = __FILE__ ;

    /*
     * @cookie_name
     */
    private static $cookie_name = 'derweili_fb_chat_opt_in';


    public function get_version(){
        return $this->version;
    }

    public function get_slug(){
        return $this->slug;
    }

    public function run(){

        $this->load_dependencies();



    }

    private function load_dependencies(){

        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts') );
        add_action('wp_head', array(&$this, 'load_fb_code'), 10000);
        add_action('customize_register',array(&$this, 'register_customizer_settings'));

    }


    public function enqueue_scripts(){

        wp_enqueue_script( 'derweili_fb_chat_plugin',  plugin_dir_url($this->plugin_dir) . 'assets/js/derweili-chat-plugin.js', array('jquery'), '0.1', true  );
        wp_enqueue_style( 'derweili_fb_chat_plugin',  plugin_dir_url($this->plugin_dir) . 'assets/css/derweili-chat-plugin.css', [], '0.1' );

    }

    private function is_cookie_set(){
        return isset( $_COOKIE[Derweili_FB_Chat_Plugin::$cookie_name] ) && $_COOKIE[Derweili_FB_Chat_Plugin::$cookie_name];
    }


    public function load_fb_code(){

        if( ! get_theme_mod('derweili_fb_chat_app_id', null) || ! get_theme_mod('derweili_fb_chat_page_id', null) ) return;

        if( $this->is_cookie_set() ):

    ?>

        <script>
            window.fbAsyncInit = function() {
                console.log('fbinit');
                FB.init({
                    appId            : "<?php echo get_theme_mod('derweili_fb_chat_app_id', ''); ?>",
                    autoLogAppEvents : true,
                    xfbml            : true,
                    version          : 'v2.12'
                });
            };
            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/de_DE/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

    <?php
        else:
    ?>

        <div id="derweili-fb-chat-icon">
            <svg x="0" y="0" width="60" height="60"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g><g><circle fill="" cx="30" cy="30" r="30"></circle><g transform="translate(10.000000, 11.000000)" fill="#FFFFFF"><path d="M0,18.7150914 C0,8.37723141 8.956743,0 20,0 C31.043257,0 40,8.37723141 40,18.7150914 C40,29.0529515 31.043257,37.4301829 20,37.4301829 C18,37.4301829 16.0763359,37.1551856 14.2544529,36.6459314 L6.95652174,40 L6.95652174,33.0434783 C2.44929143,29.6044708 0,24.5969773 0,18.7150914 Z M16.9276495,19.6993886 L22.109375,25.0798234 L33.0434783,13.4782609 L23.0672554,18.9962636 L17.890625,13.6158288 L6.95652174,25.2173913 L16.9276495,19.6993886 Z"></path></g></g></g></g></svg>
<!--            <path d="M0,18.7150914 C0,8.37723141 8.956743,0 20,0 C31.043257,0 40,8.37723141 40,18.7150914 C40,29.0529515 31.043257,37.4301829 20,37.4301829 C18,37.4301829 16.0763359,37.1551856 14.2544529,36.6459314 L6.95652174,40 L6.95652174,33.0434783 C2.44929143,29.6044708 0,24.5969773 0,18.7150914 Z M16.9276495,19.6993886 L22.109375,25.0798234 L33.0434783,13.4782609 L23.0672554,18.9962636 L17.890625,13.6158288 L6.95652174,25.2173913 L16.9276495,19.6993886 Z"></path>-->
        </div>

        <div id="derweili-fb-chat-opt-in-message" data-cookie-name="<?php echo Derweili_FB_Chat_Plugin::$cookie_name; ?>" data-app-id="<?php echo get_theme_mod('derweili_fb_chat_app_id', ''); ?>">
            <div class="inner">
                <h6><?php echo get_theme_mod('derweili_fb_chat_infotext_headline', '#0084ff'); ?></h6>
                <p>
                    <?php echo get_theme_mod('derweili_fb_chat_infotext', '#0084ff'); ?>
                </p>
                <div class="button-section">
                    <a id="accept" class="button"><?php echo get_theme_mod('derweili_fb_chat_start_chat_button_text', 'Start chat'); ?></a>
                    <?php if( get_theme_mod('derweili_fb_chat_privacy_link', null) ) : ?>

                        <a href="<?php echo get_permalink(get_theme_mod('derweili_fb_chat_privacy_link', null)); ?>"><?php echo get_theme_mod('derweili_fb_chat_privacy_policy_link', __('Privacy Policy')); ?></a>
                    <?php endif; ?>

                </div>
            </div>
            <div class="close">
                <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDIxMi45ODIgMjEyLjk4MiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjEyLjk4MiAyMTIuOTgyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCI+CjxnIGlkPSJDbG9zZSI+Cgk8cGF0aCBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7IiBkPSJNMTMxLjgwNCwxMDYuNDkxbDc1LjkzNi03NS45MzZjNi45OS02Ljk5LDYuOTktMTguMzIzLDAtMjUuMzEyICAgYy02Ljk5LTYuOTktMTguMzIyLTYuOTktMjUuMzEyLDBsLTc1LjkzNyw3NS45MzdMMzAuNTU0LDUuMjQyYy02Ljk5LTYuOTktMTguMzIyLTYuOTktMjUuMzEyLDBjLTYuOTg5LDYuOTktNi45ODksMTguMzIzLDAsMjUuMzEyICAgbDc1LjkzNyw3NS45MzZMNS4yNDIsMTgyLjQyN2MtNi45ODksNi45OS02Ljk4OSwxOC4zMjMsMCwyNS4zMTJjNi45OSw2Ljk5LDE4LjMyMiw2Ljk5LDI1LjMxMiwwbDc1LjkzNy03NS45MzdsNzUuOTM3LDc1LjkzNyAgIGM2Ljk4OSw2Ljk5LDE4LjMyMiw2Ljk5LDI1LjMxMiwwYzYuOTktNi45OSw2Ljk5LTE4LjMyMiwwLTI1LjMxMkwxMzEuODA0LDEwNi40OTF6IiBmaWxsPSIjMDAwMDAwIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />            </div>
            </div>



    <?php
        endif;
    ?>

        <div class="fb-customerchat"
             page_id="<?php echo get_theme_mod('derweili_fb_chat_page_id', '#0084ff'); ?>"
             theme_color="<?php echo get_theme_mod('derweili_fb_chat_theme_color', ''); ?>"
             <?php if( get_theme_mod('derweili_fb_chat_logged_in_greeting', null) ) : ?>
                logged_in_greeting="<?php echo get_theme_mod('derweili_fb_chat_logged_in_greeting', '#0084ff'); ?>"
             <?php endif; ?>
            <?php if( get_theme_mod('derweili_fb_chat_logged_out_greeting', null) ) : ?>
                logged_out_greeting="<?php echo get_theme_mod('derweili_fb_chat_logged_out_greeting', '#0084ff'); ?>"
            <?php endif; ?>
        >
        </div>

        <?php
    }



    public static function opt_out_cookie( $atts, $content = "" ){

        return "<a href=\"#\" class=\"derweili-fb-opt-out-link\" data-cookie-name='" . Derweili_FB_Chat_Plugin::$cookie_name . "'>" . $content . "</a>";

    }



    public function register_customizer_settings($wp_customize){


        $wp_customize->add_section( 'derweili_fb_chat_settings_section', array(
            'title' => __( 'Facebook Chat Settings' ),
            'priority' => 100,
        ) );

        $wp_customize->add_setting(
            'derweili_fb_chat_app_id',
            array(
                'default' => '',
                'transport' => 'refresh'
            )
        );
        $wp_customize->add_setting(
            'derweili_fb_chat_page_id',
            array(
                'default' => '',
                'transport' => 'refresh'
            )
        );
        $wp_customize->add_setting(
            'derweili_fb_chat_theme_color',
            array(
                'default' => '',
                'transport' => 'refresh'
            )
        );
        $wp_customize->add_setting(
            'derweili_fb_chat_logged_in_greeting',
            array(
                'default' => '',
                'transport' => 'refresh'
            )
        );
        $wp_customize->add_setting(
            'derweili_fb_chat_logged_out_greeting',
            array(
                'default' => '',
                'transport' => 'refresh'
            )
        );
        $wp_customize->add_setting(
            'derweili_fb_chat_infotext_headline',
            array(
                'default' => '',
                'transport' => 'refresh'
            )
        );
        $wp_customize->add_setting(
            'derweili_fb_chat_infotext',
            array(
                'default' => '',
                'transport' => 'refresh'
            )
        );
        $wp_customize->add_setting(
            'derweili_fb_chat_privacy_link',
            array(
                'default' => '',
                'transport' => 'refresh'
            )
        );

        $wp_customize->add_setting(
            'derweili_fb_chat_start_chat_button_text',
            array(
                'default' => 'Start chat',
                'transport' => 'refresh'
            )
        );

        $wp_customize->add_setting(
            'derweili_fb_chat_privacy_policy_link',
            array(
                'default' => __('Privacy Policy'),
                'transport' => 'refresh'
            )
        );

        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'derweili_fb_chat_app_id', array(
            'label'        => __('Facebook App ID'),
            'section'    => 'derweili_fb_chat_settings_section',
            'settings'   => 'derweili_fb_chat_app_id',
        ) ) );


        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'derweili_fb_chat_page_id', array(
            'label'        => __('Page ID'),
            'section'    => 'derweili_fb_chat_settings_section',
            'settings'   => 'derweili_fb_chat_page_id',
        ) ) );


        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'derweili_fb_chat_theme_color', array(
            'label'        => __('Theme Color'),
            'section'    => 'derweili_fb_chat_settings_section',
            'settings'   => 'derweili_fb_chat_theme_color',
        ) ) );


        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'derweili_fb_chat_logged_in_greeting', array(
            'label'        => __('Logged in greeting'),
            'section'    => 'derweili_fb_chat_settings_section',
            'settings'   => 'derweili_fb_chat_logged_in_greeting',
        ) ) );

        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'derweili_fb_chat_logged_out_greeting', array(
            'label'        => __('Logged out greeting'),
            'section'    => 'derweili_fb_chat_settings_section',
            'settings'   => 'derweili_fb_chat_logged_out_greeting',
        ) ) );


        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'derweili_fb_chat_infotext_headline', array(
            'label'        => __('Infotext Headline'),
            'section'    => 'derweili_fb_chat_settings_section',
            'settings'   => 'derweili_fb_chat_infotext_headline',
        ) ) );

        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'derweili_fb_chat_start_chat_button_text', array(
            'label'        => __('Start chat button text'),
            'section'    => 'derweili_fb_chat_settings_section',
            'settings'   => 'derweili_fb_chat_start_chat_button_text',
        ) ) );




        $wp_customize->add_control( 'derweili_fb_chat_infotext', array(
            'type' => 'textarea',
            'priority' => 10, // Within the section.
            'section' => 'derweili_fb_chat_settings_section', // Required, core or custom.
            'label' => __( 'Infotext' ),
//            'description' => __( 'This is a date control with a red border.' ),
            'setting' => 'derweili_fb_chat_infotext'
        ) );


        $wp_customize->add_control( 'derweili_fb_chat_privacy_link', array(
            'type' => 'dropdown-pages',
            'priority' => 10, // Within the section.
            'section' => 'derweili_fb_chat_settings_section', // Required, core or custom.
            'label' => __( 'Privacy Link' ),
//            'description' => __( 'This is a date control with a red border.' ),
            'setting' => 'derweili_fb_chat_privacy_link'
        ) );


        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'derweili_fb_chat_privacy_policy_link', array(
            'label'        => __('Privacy Policy Linktext'),
            'section'    => 'derweili_fb_chat_settings_section',
            'settings'   => 'derweili_fb_chat_privacy_policy_link',
        ) ) );

    }




}

$chat_plugin = new Derweili_FB_Chat_Plugin();
$chat_plugin->run();


add_shortcode( 'fb-chat-plugin', array( 'Derweili_FB_Chat_Plugin', 'opt_out_cookie' ) );