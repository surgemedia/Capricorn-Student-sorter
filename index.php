<?php
/*
Plugin Name: Student Sorter
Description: sort student with qr codes and thumbnails
Author: Alex King & Hector Navarro
Version: 0.1
*/

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
if(!file_exists($upload_dir)){
	wp_mkdir_p($upload_dir);
}


/*=============================
=            Pages            =
=============================*/
add_action( 'admin_menu', 'ss_admin_menu' );

function ss_admin_menu() {
	add_menu_page( 
		'Student Sorter',
		'Student Sorter',
		'manage_options',
		'student_sorter_home',
		'ss_page1',
		'dashicons-images-alt2',
		4);
		add_submenu_page(
			'student_sorter_home',
			'Select Photos',
			'Select Photos',
			'manage_options',
			'student_sorter_select',
			'ss_page2'
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
?>