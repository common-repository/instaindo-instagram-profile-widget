<?php
/*
Plugin Name: Profile Widget For Insta
Description: You can easily embed widget your Insta profile on your website through this plugin. Use existing widgets or custom your widget.
Author: Jamal Pinang
Author URI: http://instaindo.com
Version: 1.0.0
License: GPLv2 or later
*/

function ig_profile_widget_table()
{
        // do NOT forget this global
	global $wpdb;
	
	$tablename = "wp_insta_profile";
	$insta_id_widget = "0";
 
	// this if statement makes sure that the table doe not exist already
	if($wpdb->get_var("show tables like my_table_name") != $tablename) 
	{
		$sql = "CREATE TABLE IF NOT EXISTS wp_insta_profile (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		insta_id_widget varchar(70) NOT NULL,
		UNIQUE KEY id (id)
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
	$newdata = array(
        'insta_id_widget'=>$insta_id_widget,
    );
	
	//inserting a record to the database
    $wpdb->insert(
        $tablename,
        $newdata
    );
}
// this hook will cause our creation function to run when the plugin is activated
register_activation_hook( __FILE__, 'ig_profile_widget_table' );

// Include ig_profile_widget_functions, gunakan require_once untuk menghentikan script jika file instagram-functions.php tidak ditemukan
require_once plugin_dir_path(__FILE__) . 'ig_profile_widget_functions.php';