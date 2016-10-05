<?php
/*
Plugin Name: Student Sorter
Description: sort student with qr codes and thumbnails
Author: Alex King & Hector Nuvaro
Version: 0.1
*/

/*=================================
=            Libraries            =
=================================*/

include_once( dirname( __FILE__ ) . '/lib/qrreader/QrReader.php');
include_once( dirname( __FILE__ ) . '/lib/create_uploads.php');
include_once( dirname( __FILE__ ) . '/lib/admin-page-framework/library/apf/admin-page-framework.php' );

/*=============================
=            Pages            =
=============================*/
add_action( 'admin_menu', 'ss_admin_menu' );

function ss_admin_menu() {
	add_menu_page( 
		'Student Sorter',
		 'Student Sorter',
		  'manage_options',
		   'myplugin/myplugin-admin-page.php',
		    'ss_page1',
		     'dashicons-images-alt2',
		      6  );
}
function ss_page1(){
	?>
	<div class="wrap">
		<h2>WStudent Sorter</h2>
	</div>
	<?php
}
// include_once( dirname( __FILE__ ) .'/views/ss_home.php');
// include_once( dirname( __FILE__ ) .'/views/ss_sort.php'); 

?>