<?php 

	$submit = $_POST['submit'];
	$school_id = $_POST['school'];
	$year = $_POST['year'];

function is_family($id_student){
	$components_of_id = explode("-", $id_student);
	if(!empty($components_of_id[1])){
		return true;
	}
	return false;
}

function my_update_attachment($filename,$t='',$c='') {
    $file_type = wp_check_filetype(wp_upload_dir()['basedir'].$filename, array(
      'jpg|jpeg' => 'image/jpeg',
      'gif' => 'image/gif',
      'png' => 'image/png',
    ));
      
    if ($file_type['type']) {
      $name_parts = pathinfo( $filename ); 
      $name = $name_parts['filename'];
      $type = $file_type['type'];
      $title = $t ? $t : $name;
      $content = $c;
 
      $attachment = array(
        'post_title' => $title,
        'post_type' => 'attachment',
        'post_content' => $content,
        'post_parent' => '',
        'post_mime_type' => $type,
        'guid' => wp_upload_dir()['baseurl'].$filename,
      );
      	 
      // foreach( get_intermediate_image_sizes() as $s ) {
      //   $sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => true );
      //   $sizes[$s]['width'] = get_option( "{$s}_size_w" ); // For default sizes set in options
      //   $sizes[$s]['height'] = get_option( "{$s}_size_h" ); // For default sizes set in options
      //   $sizes[$s]['crop'] = get_option( "{$s}_crop" ); // For default sizes set in options
      // }

      // $sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );

      // foreach( $sizes as $size => $size_data ) {
      //   $resized = image_make_intermediate_size( $file['file'], $size_data['width'], $size_data['height'], $size_data['crop'] );
      //   if ( $resized )
      //     $metadata['sizes'][$size] = $resized;
      // }
    		// array_push( $attachment, $metadata);
  	   $attach_id = wp_insert_attachment( $attachment, wp_upload_dir()['basedir'].$filename /*, $pid - for post_thumbnails*/);
  		
      if ( !is_wp_error( $attach_id )) {
      	require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attach_meta = wp_generate_attachment_metadata( $attach_id, wp_upload_dir()['basedir'].$filename );
        wp_update_attachment_metadata( $attach_id, $attach_meta );
      }
   
   return $attach_id;
   
    }
  
}



switch ($submit) {
	case 'Sort Photo':
		if ( ! function_exists( 'wp_handle_upload' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
	$uploadedfile = $_FILES['fileToUpload'];
	
	
	$uploadedFilePath = wp_upload_dir()['basedir'] . '/student_sorter_uploads'.'/'.$uploadedfile['name'];

	$upload_overrides = array( 'test_form' => false );
	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
	if ( $movefile && ! isset( $movefile['error'] ) ) {
			/*If Zip doesn't exists*/
			if(!file_exists($uploadedFilePath)){
			//Get unzip function from wordpress
			 require_once(ABSPATH .'wp-admin/includes/file.php');
		
			WP_Filesystem(); 
			echo "File doesnt exist </br>";
			//store long vars
			$old_dir = $movefile['file'];
			//echo "Old dir: ".$old_dir."</br>";
			$new_dir = wp_upload_dir()['basedir'] . '/student_sorter_uploads'.'/'.$uploadedfile['name'];
			echo "New dir: ".$new_dir."</br>";
			$clean_name = explode('.zip',$uploadedfile['name'])[0];
			$folder_dir = wp_upload_dir()['basedir'] . '/student_sorter_uploads'.'/'.$clean_name;
			$_SESSION["folder_dir"] = $folder_dir;
			echo "base dir: ".wp_upload_dir()['basedir']."</br>";
			/*=================================
			=            Move File            =
			=================================*/
			rename($old_dir, $new_dir);
			/*==================================
			=            Unzip file            =
			==================================*/
			//Unzip to folder called clean name - store the result 1 or 0 for error checking.
			if (!file_exists($folder_dir)) {
	    	// echo "Folder doesnt exist: ".$folder_dir."</br>";
	    	wp_mkdir_p($folder_dir, 0777, true);
	    	// wp_mkdir_p($folder_dir."_thumb", 0777, true);
	    	 // echo "creo: ".$x."</br>" ;
			}
			$zip = new ZipArchive;
			$res = $zip->open($new_dir);
			if ($res === TRUE) {
			  $zip->extractTo($folder_dir);
			  $zip->close();
			   // echo "WOOT! $new_dir extracted to $folder_dir";
			} else {
			   // echo "Doh! I couldn't open $new_dir";
			}	
		
			/*========================================
			=            Adding Post Type            =
			========================================*/
			// insert the post and set the category
			
			// $post_id = wp_insert_post(array (
			//     'post_type' => 'photo_shoots',
			//     'post_title' => $your_title,
			//     'post_content' => $your_content,
			//     'post_status' => 'publish',
			//     'comment_status' => 'closed',   // if you prefer
			//     'ping_status' => 'closed',      // if you prefer
			// ));

			// if ($post_id) {
			//     // insert post meta
			//     add_post_meta($post_id, '_your_custom_1', $custom1);
			//     add_post_meta($post_id, '_your_custom_2', $custom2);
			//     add_post_meta($post_id, '_your_custom_3', $custom3);
			// }
			
			
			/*========================================
			=            Store File Names            =
			========================================*/
			$store['zips'][$clean_name] = $folder_dir;

			print_r($store['zips']);

			$files = glob($folder_dir."/*.*");

			
			// $schools_shots = array();
			// $student_session = array();
			// $session = array();
			$student_photos=array();
			// $current_student="";
			$count=0;

			

			$last=sizeof($files)-1;

			foreach ($files as $key=>$file) {
			  $qrcode = new QrReader($file);
			  if (!empty($qrcode->text())) {

			    
			    if ($count===0){
			      
			      $user_login = $qrcode->text();
			      
			      $family=is_family($user_login);
					
						if($family){
							$user_login = explode("-", $user_login)[0];
						}
			      $count++;  
			    }else {
			      
			    	$user=get_user_by("login",$user_login);
										
						if($family){
							update_field('family_photos' ,$student_photos,"user_".$user->ID);
						}else{
							update_field('portrait_photos' ,$student_photos,"user_".$user->ID);
						}
			      
			      // $student_session[$user_login] = $session;
			      $student_photos=array();
			      // $session = array();
			      $user_login = $qrcode->text();
			      $family = is_family($user_login);
						
						if($family){
							$user_login = explode("-", $user_login)[0];
						}
			      $count++;
			    }
			    
			  }else{
			  	$photo_path= explode(wp_upload_dir()['basedir'], $file)[1];
			  	
			    if($photo_count === 0){
			    	
			    }
			    array_push($student_photos, my_update_attachment($photo_path));
			    // $session[] = array('checked' => false, 'file' => $photo_path); update check picture
			  }
			  if ($key===$last){
			    $user=get_user_by("login",$user_login);
			   	if($family){
						update_field('family_photos',$student_photos,"user_".$user->ID);
			   	}else{
						update_field('portrait_photos',$student_photos,"user_".$user->ID);
			   	}

			    // $student_session[$user_login] = $session;
			  }
			}

			// $schools_shots = $student_session;
			

			// $fp = fopen($folder_dir.'.json', 'w');
			// fwrite($fp, json_encode());
			// fclose($fp);

	} else {
		//print_r($uploadedfile);
		echo 'Already a file there '.$uploadedfile['name'];
		$clean_name = explode('.zip',$uploadedfile['name'])[0];
		$folder_dir = wp_upload_dir()['basedir'] . '/student_sorter_uploads'.'/'.$clean_name;
		// $_SESSION["folder_dir"] = $folder_dir;
		
		 //update_field('portrait_photos',array(2492,2493),'user_4251');
		// echo "<pre>";
		// 	print_r(get_field('portrait_photos','user_4302'));
		// echo "</pre>";
		// echo "<pre>";
		// 	print_r(wp_get_attachment_metadata( 2480));
		// echo "</pre>";
		// echo "<pre>";
		// 	print_r(get_user_meta(4302));
		// echo "</pre>";
		// echo "<pre>";
		// 	print_r(get_userdata(4302));
		// echo "</pre>";
	}
			
	} else {
	    /**
	     * Error generated by _wp_handle_upload()
	     * @see _wp_handle_upload() in wp-admin/includes/file.php
	     */
	    // echo $movefile['error'];
	}

	// The security check failed, maybe show the user an error.
		break;
	
	case "Load": 
		$folder_dir = $_POST['load'];
		$_SESSION["folder_dir"] = $folder_dir;

		break;

	default:
		# code...
		break;
}

	




?>

