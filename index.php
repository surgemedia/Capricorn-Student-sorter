<?php
/*
Plugin Name: Student Sorter
Description: sort student with qr codes and thumbnails
Author: Alex King & Hector Navarro
Version: 0.1
*/
session_start();
wp_register_style( 'ss-bundle', plugins_url('dist/bundle.css', __FILE__) );
wp_register_script( 'js-bundle',  plugins_url('dist/bundle.js', __FILE__) );
wp_enqueue_script( 'js-bundle' );
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


/*========================================
=            Custom Post Type            =
========================================*/
// Register Custom Post Type
function custom_photo_shoots() {

  $labels = array(
    'name'                  => _x( 'Photo Shoots', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Photo Shoot', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Photo Shoots', 'text_domain' ),
    'name_admin_bar'        => __( 'Photo Shoot', 'text_domain' ),
    'archives'              => __( 'Photo Shoot Archives', 'text_domain' ),
    'attributes'            => __( 'Photo Shoot Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Photo Shoot:', 'text_domain' ),
    'all_items'             => __( 'All Photo Shoots', 'text_domain' ),
    'add_new_item'          => __( 'Add New Photo Shoot', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Photo Shoot', 'text_domain' ),
    'edit_item'             => __( 'Edit Photo Shoot', 'text_domain' ),
    'update_item'           => __( 'Update Photo Shoot', 'text_domain' ),
    'view_item'             => __( 'View Photo Shoot', 'text_domain' ),
    'view_items'            => __( 'View Photo Shoots', 'text_domain' ),
    'search_items'          => __( 'Search Photo Shoot', 'text_domain' ),
    'not_found'             => __( 'Photo Shoot Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Photo Shoot Not found in Trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
    'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert into Photo Shoot', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this Photo Shoot', 'text_domain' ),
    'items_list'            => __( 'Photo Shoot list', 'text_domain' ),
    'items_list_navigation' => __( 'Photo Shoots list navigation', 'text_domain' ),
    'filter_items_list'     => __( 'Filter Photo Shoots list', 'text_domain' ),
  );
  $args = array(
    'label'                 => __( 'Photo Shoot', 'text_domain' ),
    'description'           => __( 'Post Type photo_shoots', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', ),
    'taxonomies'            => array( 'category', 'post_tag' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 4,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,    
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'photo_shoots', $args );

}
add_action( 'init', 'custom_photo_shoots', 0 );


 



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
			'Batch Process',
			'Batch Process',
			'manage_options',
			'student_sorter_order',
			'ss_page3'
		);
	add_menu_page( 
		'QR Generater', 			//string $page_title
		'QR Generater',  			//string $menu_title
		'manage_options',  			//string $capability
		'generate_code_page', 	//string $menu_slug
		'gc_page',           	//callable $function = ''
		'dashicons-layout',//string $icon_url = ''
		4);		 
	
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
function gc_page(){
	include_once( dirname( __FILE__ ) .'/views/gc_home.php');
}
/*function my_plugin_function(){
	echo "<h2>plugin page</h2>";
}*/

/* echo "<pre>";
 echo plugins_url( '/assets/js/test.js', __FILE__ );
 echo "</pre>";*/
 

function my_enqueue($hook) {
 //    if( 'index.php' != $hook ) {
	// // Only applies to dashboard panel
	// return;
 //    }
 	wp_enqueue_script( 'jquery-form' );
  wp_enqueue_script( 'json2' );      
	wp_enqueue_script( 'ajax-script', plugins_url( '/assets/js/wp_ajax_actions.js', __FILE__ ), array('jquery','json2') ,false, true);
// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
	 wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ),'nonce' => wp_create_nonce( "unique_id_nonce" )) );
}

function my_action() {
	global $wpdb;
	
	$userID = $_POST['userID'];
	$filename = $_POST['filename'];
	$gallery = $_POST['gallery'];
	if ($gallery==="P"){
		update_field('portrait_selected',$filename,'user_'.$userID);
	}else{
		update_field('family_selected',$filename,'user_'.$userID);
	}
  
	wp_die();
}

function load_students() {
  global $wpdb;
   
  $school = $_POST['school'];
  $year = $_POST['year'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
   $args = array(
        'role'           => 'Customer',
        'fields'         => 'all_with_meta',
        'meta_query'     => array(
                              array(
                                'relation' => 'AND', // Optional, defaults to "AND"
                                array(
                                  'key'     => 'school',
                                  'value'   => $school,
                                ),
                                array(
                                  'key'     => 'current_year',
                                  'value'   => $year,
                                )
                              ),
                              array(
                                "the_class"=>array(
                                  'key'=> 'class'
                                  )
                                ),
                              array(
                                'relation' => 'AND',
                                array(
                                  'key'     => 'first_name',
                                  'value'   => $firstName,
                                  'compare' => 'LIKE'
                                ),
                                "surname"=>array(

                                  'key'     => 'last_name',
                                  'value'   => $lastName,
                                  'compare' => 'LIKE'
                                )
                              ),

                            ),
         'orderby' => 'the_class surname'
         // 'number'         => 1
    );
    // The User Query
    $user_query = new WP_User_Query( $args );
    
    $users=[];

    // The User Loop
    if ( ! empty( $user_query->results ) ) {
        foreach ( $user_query->results as $user ) {
        
            $user_meta = get_user_meta($user->ID);
             $user_striped=[
                "ID" => $user->data->ID,
                "user_login" => $user->data->user_login,
                "user_class" => $user_meta['class'][0],
                "display_name" => $user->data->display_name,
                "first_name" => $user_meta['first_name'][0],
                "last_name" => $user_meta['last_name'][0],
             ];
             /*echo "<pre>";
             // print_r($user->data);
           
             print_r(get_user_meta($user->ID));
             echo "</pre>";*/
            // echo '<span>' . esc_html( $user->user_email ) . '</span><br/>';
            array_push($users, $user_striped);
        }

    } else {
      
    }
     // header( "Content-Type: application/json" );
      
      echo json_encode($users);
  wp_die();
}

add_action( 'admin_enqueue_scripts', 'my_enqueue' );
add_action( 'wp_ajax_my_action', 'my_action' );
add_action( 'wp_ajax_load_students', 'load_students' );
 

?>