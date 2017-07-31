<?php

/*=========================================
=         get featured image url            =
=========================================*/
//Call inside the loop

// function get_featured_image($id = NULL, $size = 'full'){
  
//   $thumb_url_array = wp_get_attachment_image_src($id, $size, true);
//   $thumb_url = $thumb_url_array[0];
//   return $thumb_url_array;
// }
// function is_default($url){
//   if (strpos($url, 'wp-include') !== false) {
//     return true;
//   } else{
//     return false;
//   }
// }



// $folder_dir= $_SESSION["folder_dir"];
// echo "List: ".$folder_dir."</br>";
/*$school = $_POST['school'];
$year = $_POST['year'];*/
      // echo "<pre>";

          // echo $school."<br/>";
          // echo $year."<br/>";
         
         // echo "</pre>";
   
// $filedir = dirname( __FILE__ ).'/wp-content/uploads/student_sorter_uploads/cap_test_photos';
// $files = glob($folder_dir."/*.*");
?>
<div id="student_filter">
  <ul> 
    <li><a id="all_filter">With Family photos</a></li>
    <li class="active"><a id="photo_filter">With Photos</a></li>
    <li><a id="empty_filter">Empty</a></li>
  </ul>
</div>


<?php
/*==================================
=            User Query            =
==================================*/
$args = array(
    'role'           => 'Customer',
    'fields'         => 'all_with_meta',
    'meta_query'     => array(
                          'relation' => 'AND', // Optional, defaults to "AND"
                            array(
                              'key'     => 'school',
                              'value'   => $school_slug,
                            ),
                            array(
                              'key'     => 'current_year',
                              'value'   => $year,
                            )
                        ),
    // 'number'         => 1
);
// The User Query
$user_query = new WP_User_Query( $args );

// The User Loop
$student_count=0;
if ( ! empty( $user_query->results ) ) {
    foreach ( $user_query->results as $user ) {
       
               
          /*echo "<pre>";
         
          print_r(get_user_meta($user->ID));
         
          echo "</pre>";*/
         $user_info=get_user_meta($user->ID);
         $gallery_portrait=get_field("portrait_photos","user_".$user->ID);
         if(!empty($gallery_portrait)){
         ?>
         <ul id="" class="list-inline picture-list">
          <li>
            <div class="user-header">
              <p>Portrait</p>
              <p><?php echo $user->data->user_login; ?></p>
              <p><?php echo $user_info['first_name'][0]; ?></p>
              <p><?php echo $user_info['last_name'][0]; ?></p>
            </div>
          </li>
             
          <?php 

            $student_id=$key;
            foreach ($gallery_portrait as $key => $photo) { 
            $photo_input_id = $user->data->user_login."-".$key;
            
            ?>
            
            <li class="photo-item"> 
                   <?php $path_file= pathinfo( $photo['url'] );
                         $path_file= $path_file['basename'];
                        
                   ?>
                  
                  <img width="100" height="100" src="<?php echo $photo['url'] ?>"> 
                  <input onclick="selectPic('<?php echo $user->ID; ?>', '<?php echo $path_file; ?>','P')" type="radio" id="<?php echo $photo_input_id?>" name="<?php echo $user->ID; ?>" value="<?php echo $key ?>" <?php if(get_field("portrait_selected","user_".$user->ID)===$path_file) { ?>checked <?php }?> > 
                  <label class="check" for="<?php echo $photo_input_id ?>"></label> 

 
                </li> 


        <?php  } ?>
              
           </ul>    
        
   <?php     
         }

         $gallery_family=get_field("family_photos","user_".$user->ID);
         if(!empty($gallery_family)){
         ?>
         <ul id="" class="list-inline picture-list">
          <li>
            <div class="user-header family-header">
              <p>Family</p>
              <p><?php echo $user->data->user_login; ?></p>
              <p><?php echo $user_info['first_name'][0]; ?></p>
              <p><?php echo $user_info['last_name'][0]; ?></p>
            </div>
          </li>
             
          <?php 

            $student_id=$key;
            foreach ($gallery_family as $key => $photo) { 
            $photo_input_id = $user->data->user_login."-".$key."-F";
            
            ?>
            
            <li class="photo-item"> 
                   <?php $path_file= pathinfo( $photo['url'] );
                         $path_file= $path_file['basename'];
                        
                   ?>
                  
                  <img width="100" height="100" src="<?php echo $photo['url'] ?>"> 
                  <input onclick="selectPic('<?php echo $user->ID; ?>', '<?php echo $path_file; ?>','F')" type="radio" id="<?php echo $photo_input_id?>" name="<?php echo $user->ID; ?>-F" value="<?php echo $key ?>" <?php if(get_field("family_selected","user_".$user->ID)===$path_file) { ?>checked <?php }?> > 
                  <label class="check" for="<?php echo $photo_input_id ?>"></label> 

 
                </li> 


        <?php  } ?>
              
           </ul>    
        
   <?php     
         }
    }

} else {
  
}

/*======================================
=            End User Query            =
======================================*/

?>


