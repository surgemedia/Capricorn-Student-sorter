
<?php

$folder_dir= $_SESSION["folder_dir"];
// echo "List: ".$folder_dir."</br>";


// $filedir = dirname( __FILE__ ).'/wp-content/uploads/student_sorter_uploads/cap_test_photos';
// $files = glob($folder_dir."/*.*");


$student_session = array();
$session = array();

$current_student="";
$count=0;

// copy file content into a string var
$json_file = file_get_contents($folder_dir.'.json');
// convert the string to a json object
$schools_shoots = json_decode($json_file,true); ?>

<?php 
    $student_count = 0;  
    foreach ($schools_shoots as $key=>$shoot) { ?>
      
      <ul id="" class="list-inline picture-list">
          <li>
            <div class="user-header">
              <div class='number'><?php echo $student_count; ?></div>
              <h1><?php echo $key; ?></h1>
            </div>
          </li>
             
          <?php 
            $student_id=$key;
            foreach ($shoot as $key => $photo) { 
            $photo_url = wp_upload_dir()['baseurl'].$photo['file'];
            $photo_input_id = $student_id."-".$key;
            
            ?>
            
            <li class="photo-item"> 
                   
                  <img width="100" height="100" src="<?php echo $photo_url ?>"> 
                  <input type="radio" id="<?php echo $photo_input_id?>" name="<?php echo $student_id; ?>" value="<?php echo $key ?>" <?php if($photo['checked']) { ?>checked <?php }?> > 
                  <label class="check" for="<?php echo $photo_input_id ?>"></label> 

 
                </li> 


        <?php  } ?>
              
           </ul>    

            <?php
           

     
     

      $student_count++;
    }

  
?>


