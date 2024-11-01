<?php
/*
 * Plugin Name: Very Simple Sunday Closed
 * Description: This is a very simple plugin to close your website on sundays. For more info please check readme file.
 * Version: 2.0
 * Author: Guido
 * Author URI: https://www.guido.site
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: very-simple-sunday-closed
 * Domain Path: /translation
 */

// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// load plugin text domain
function vssc_init() { 
	load_plugin_textdomain( 'very-simple-sunday-closed', false, dirname( plugin_basename( __FILE__ ) ) . '/translation' );
}
add_action('plugins_loaded', 'vssc_init');


// enqueue colorpicker script
function vssc_enqueue_color_picker() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'vssc_colorpicker_script', plugins_url('/js/vssc-colorpicker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'vssc_enqueue_color_picker' );


// add settings link
function vssc_action_links ( $links ) { 
	$settingslink = array( '<a href="'. admin_url( 'options-general.php?page=vssc' ) .'">'. __('Settings', 'very-simple-sunday-closed') .'</a>', ); 
	return array_merge( $links, $settingslink ); 
} 
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'vssc_action_links' ); 


// enqueue css script
function vssc_frontend_scripts() {	
	if(!is_admin())	{
		wp_enqueue_style('vssc_style', plugins_url('/css/vssc-style.css',__FILE__));
	}
}
add_action('wp_enqueue_scripts', 'vssc_frontend_scripts');
 

// add admin options page
function vssc_menu_page() {
	add_options_page( __( 'Sunday Closed', 'very-simple-sunday-closed' ), __( 'Sunday Closed', 'very-simple-sunday-closed' ), 'manage_options', 'vssc', 'vssc_options_page' );
}
add_action( 'admin_menu', 'vssc_menu_page' );


// add admin settings and such 
function vssc_admin_init() {
	add_settings_section( 'vssc-section', __( 'Settings', 'very-simple-sunday-closed' ), 'vssc_section_callback', 'vssc' );

	add_settings_field( 'vssc-field-6', __( 'Preview mode', 'very-simple-sunday-closed' ), 'vssc_field_callback_6', 'vssc', 'vssc-section' );
	register_setting( 'vssc-options', 'vssc-setting-6', 'sanitize_text_field' );

	add_settings_field( 'vssc-field-1', __( 'Activate', 'very-simple-sunday-closed' ), 'vssc_field_callback_1', 'vssc', 'vssc-section' );
	register_setting( 'vssc-options', 'vssc-setting-1', 'sanitize_text_field' );

	add_settings_field( 'vssc-field-7', __( 'Background', 'very-simple-sunday-closed' ), 'vssc_field_callback_7', 'vssc', 'vssc-section' );
	register_setting( 'vssc-options', 'vssc-setting-7', 'sanitize_text_field' );

	add_settings_field( 'vssc-field-8', __( 'Color', 'very-simple-sunday-closed' ), 'vssc_field_callback_8', 'vssc', 'vssc-section' );
 	register_setting( 'vssc-options', 'vssc-setting-8', 'sanitize_text_field' );

	add_settings_field( 'vssc-field-3', __( 'Logo', 'very-simple-sunday-closed' ), 'vssc_field_callback_3', 'vssc', 'vssc-section' );
	register_setting( 'vssc-options', 'vssc-setting-3', 'esc_url_raw' );

	add_settings_field( 'vssc-field-4', __( 'Title', 'very-simple-sunday-closed' ), 'vssc_field_callback_4', 'vssc', 'vssc-section' );
	register_setting( 'vssc-options', 'vssc-setting-4', 'sanitize_text_field' );

	add_settings_field( 'vssc-field-5', __( 'Content', 'very-simple-sunday-closed' ), 'vssc_field_callback_5', 'vssc', 'vssc-section' );
 	register_setting( 'vssc-options', 'vssc-setting-5', 'wp_kses_post' );
}
add_action( 'admin_init', 'vssc_admin_init' );


function vssc_section_callback() {
	echo __( 'Here you can activate and customize the closed on sundays page.', 'very-simple-sunday-closed' ); 
}

function vssc_field_callback_6() {
	$value = esc_attr( get_option( 'vssc-setting-6' ) );
	?>
	<input type='hidden' name='vssc-setting-6' value='no'>
	<input type='checkbox' name='vssc-setting-6' <?php checked( $value, 'yes' ); ?> value='yes'>
	<?php
}

function vssc_field_callback_1() {
	$value = esc_attr( get_option( 'vssc-setting-1' ) );
	?>
	<input type='hidden' name='vssc-setting-1' value='no'>
	<input type='checkbox' name='vssc-setting-1' <?php checked( $value, 'yes' ); ?> value='yes'>
	<?php
}

function vssc_field_callback_7() {
	$setting = esc_attr( get_option( 'vssc-setting-7' ) );
	echo "<input type='text' maxlength='15' id='vssc-setting-7' name='vssc-setting-7' data-default-color='#ffffff' value='$setting' />";
}

function vssc_field_callback_8() {
	$setting = esc_attr( get_option( 'vssc-setting-8' ) );
	echo "<input type='text' maxlength='15' id='vssc-setting-8' name='vssc-setting-8' data-default-color='#333333' value='$setting' />";
}

function vssc_field_callback_3() {
	$setting = esc_url( get_option( 'vssc-setting-3' ) );
	echo "<input type='text' size='60' maxlength='150' name='vssc-setting-3' value='$setting' />";
	?>
	<p><?php _e( 'Upload your logo in the media library and copy-paste link here.', 'very-simple-sunday-closed' ) ?></p>
	<?php
}

function vssc_field_callback_4() {
	$setting = esc_attr( get_option( 'vssc-setting-4' ) );
	echo "<input type='text' size='60' maxlength='50' name='vssc-setting-4' value='$setting' />";
}

function vssc_field_callback_5() {
	$setting = wp_kses_post( get_option( 'vssc-setting-5' ) );
	echo "<textarea name='vssc-setting-5' rows='10' cols='60' maxlength='500'>$setting</textarea>";
}


// display admin options page
function vssc_options_page() {
?>
<div class="wrap"> 
	<div id="icon-plugins" class="icon32"></div> 
	<h1><?php _e( 'Very Simple Sunday Closed', 'very-simple-sunday-closed' ); ?></h1> 
	<form action="options.php" method="POST">
	<?php settings_fields( 'vssc-options' ); ?>
	<?php do_settings_sections( 'vssc' ); ?>
	<?php submit_button(); ?>
	</form>
	<p><?php _e( 'A default notification will be displayed if title and content are not set.', 'very-simple-sunday-closed' ); ?></p>
	<p><?php _e( 'Default colors are white (background) and dark grey (text).', 'very-simple-sunday-closed' ); ?></p>
</div>
<?php
}


// set closed on sundays page 
$vssc_preview = esc_attr( get_option( 'vssc-setting-6' ) );
$vssc_activate = esc_attr( get_option( 'vssc-setting-1' ) );
$vssc_time = current_time( 'timestamp' );
$vssc_date = date('w', $vssc_time); 

if( !is_admin() ) {
	if ( $vssc_preview == 'yes' || ($vssc_activate == 'yes' && $vssc_date == '0') ) {
		function vssc_frontpage() {
			$vssc_preview = esc_attr( get_option( 'vssc-setting-6' ) );
			$vssc_preview_notice = esc_attr__( 'Preview mode', 'very-simple-sunday-closed' );
			$vssc_logo = esc_url( get_option( 'vssc-setting-3' ) );
			$vssc_title = esc_attr( get_option( 'vssc-setting-4' ) );
			$vssc_content = wpautop( wp_kses_post( get_option( 'vssc-setting-5' ) ) );
			$vssc_background = empty( esc_attr( get_option( 'vswc-setting-7' ) ) ) ? '#fff' : esc_attr( get_option( 'vswc-setting-7' ) );
			$vssc_color = empty( esc_attr( get_option( 'vswc-setting-8' ) ) ) ? '#333' : esc_attr( get_option( 'vswc-setting-8' ) );
			$vssc_default_title = esc_attr__( 'Closed', 'very-simple-sunday-closed' );
			$vssc_default_content = esc_attr__( 'This website is closed on sundays', 'very-simple-sunday-closed' );
			$vssc_alt = get_bloginfo( 'name' );

			echo '<style type="text/css">body {background:'.$vssc_background.' !important; color:'.$vssc_color.' !important; font-size:1em !important; text-align:center !important;}</style>' ."\n"; 
			echo '<div id="vssc">' ."\n";
				if (!empty($vssc_logo)) { 
					echo '<img class="vssc-logo" src="'. $vssc_logo .'"alt="'. $vssc_alt .'">' ."\n";
				}
				if (!empty($vssc_title)) { 
					echo '<h1 class="vssc-title">'. $vssc_title .'</h1>' ."\n";
				}
				if (!empty($vssc_content)) { 
					echo '<div class="vssc-content">'. $vssc_content .'</div>' ."\n";
				}
				if (empty($vssc_title) && empty($vssc_content)) {
					echo '<h1 class="vssc-title">'. $vssc_default_title .'</h1>' ."\n";
					echo '<div class="vssc-content"><p>'. $vssc_default_content .'</p></div>' ."\n";
				}
				if ($vssc_preview == 'yes') {
					echo '<div class="vssc-notice">'. $vssc_preview_notice .'</div>' ."\n";
				}
			echo '</div>' ."\n"; 
			exit;		
		}
		add_action( 'wp_head', 'vssc_frontpage' );
	}
}
?>
