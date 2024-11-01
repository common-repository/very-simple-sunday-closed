<?php

// If uninstall is not called from WordPress, exit 
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) { 
	exit(); 
} 

// Delete Options 
delete_option( 'vssc-setting-1' ); 
delete_option( 'vssc-setting-3' ); 
delete_option( 'vssc-setting-4' );
delete_option( 'vssc-setting-5' ); 
delete_option( 'vssc-setting-6' ); 
delete_option( 'vssc-setting-7' ); 
delete_option( 'vssc-setting-8' ); 

// For site options in Multisite 
delete_site_option( 'vssc-setting-1' );
delete_site_option( 'vssc-setting-3' );
delete_site_option( 'vssc-setting-4' );
delete_site_option( 'vssc-setting-5' );
delete_site_option( 'vssc-setting-6' );
delete_site_option( 'vssc-setting-7' );
delete_site_option( 'vssc-setting-8' );

// Deprecated options
delete_option( 'vssc-setting-2' ); 
delete_site_option( 'vssc-setting-2' );

?>