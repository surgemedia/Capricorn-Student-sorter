<?php
/*
Plugin Name: Student Sorter
Description: sort student with qr codes and thumbnails
Author: Alex King & Hector Navarro
Version: 0.1
*/
session_start();
wp_register_style( 'ss-bundle', plugins_url('dist/bundle.css', __FILE__) );
wp_enqueue_style('ss-bundle');
/*=================================
=            Libraries            =
=================================*/
include_once( dirname( __FILE__ ) . '/lib/qrreader/QrReader.php');
require_once(ABSPATH .'/wp-admin/includes/file.php');



/*=======================================
=            Vars and Stores            =
=======================================*/
global $wp_filesystem;

// createStore();
global $store;
$store = array();
$store['zips'] = array();
$store['uploads'] = wp_upload_dir();
$store['uploads_dir'] = $store['uploads']['basedir'];
$store['uploads_dir'] = $store['uploads_dir'] . '/student_sorter_uploads';
if(!file_exists($store['uploads_dir'])){
	wp_mkdir_p($store['uploads_dir']);
}


/*=============================
=            Pages            =
=============================*/
add_action( 'admin_menu', 'ss_admin_menu' );

function ss_admin_menu() {
	add_menu_page( 
		'Student Sorter', 			//string $page_title
		'Student Sorter',  			//string $menu_title
		'manage_options',  			//string $capability
		'student_sorter_home', 	//string $menu_slug
		'ss_page1',           	//callable $function = ''
		'dashicons-images-alt2',//string $icon_url = ''
		4);											//int $position = null
		add_submenu_page(
			'student_sorter_home',  //string $parent_slug
			'Select Photos',				//string $page_title
			'Select Photos',				//string $menu_title
			'manage_options',				//string $capability
			'student_sorter_select',//string $menu_slug
			'ss_page2'							// callable $function = ''
		);
		add_submenu_page(
			'student_sorter_home',
			'Send Order',
			'Send Order',
			'manage_options',
			'student_sorter_order',
			'ss_page3'
		); 
	
	}
function ss_page1(){
	include_once( dirname( __FILE__ ) .'/views/ss_home.php');
}
function ss_page2(){
	include_once( dirname( __FILE__ ) .'/views/ss_select.php');
}
function ss_page3(){
	include_once( dirname( __FILE__ ) .'/views/ss_order.php');
}
function my_plugin_function(){
	echo "<h2>plugin page</h2>";
}
?>