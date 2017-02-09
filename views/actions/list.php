
<?php

$folder_dir= $_SESSION["folder_dir"];
// echo "List: ".$folder_dir."</br>";


// $filedir = dirname( __FILE__ ).'/wp-content/uploads/student_sorter_uploads/cap_test_photos';
$files = glob($folder_dir."/*.*");

$react_array = array();

$current_student="";
$count=1;
    foreach ($files as $key=>$file) {?>
        <?php 
            $qrcode = new QrReader($file);
            if (!empty($qrcode->text())) {
              // echo "qrcode: ".$qrcode->text()."</br>";
              if($key!=0): ?>
                </ul>
              <?php
              endif;
              $current_student = $qrcode->text();
              $react_array[$current_student] = array();?>
              <div class="user-header">
                <div class='number'><?php echo $count ?></div>
                <h1><?php echo $current_student ?></h1>
              </div>
              <ul id="<?php echo $current_student ?>" class="list-inline picture-list">
            <?php
              $count++;
            } else {
              
              // echo "text empty - current_student: ".$current_student."</br>";
              if(!empty($current_student)){
                $path_file = site_url().'/wp-content'.explode('/wp-content',$file)[1];
                array_push($react_array[$current_student],$path_file); ?>
              
                <li class="photo-item">
                  
                  <img width="100" height="100" src="<?php echo $path_file ?>" alt="">
                  <input type="checkbox" id="checkbox<?php echo $key?>" name="<?php echo $path_file ?>" value="<?php echo $path_file ?>">
                  <label class="check" for="checkbox<?php echo $key?>"></label>

                </li>

            <?php
              }
            }

         ?>
           

  <?php
  
    }

  
?>
</ul>

