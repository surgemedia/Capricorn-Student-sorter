<?php 
  $submit=$_POST['submit'];

  switch ($submit) {
    case "Save for Later":
       // Save state
    $folder_dir= $_SESSION["folder_dir"];
    // copy file content into a string var
    $json_file = file_get_contents($folder_dir.'.json');
    // convert the string to a json object
    $files = json_decode($json_file,true); 
    $updates = $_POST;
    
    $message="Saved";
    unset($updates["submit"]); /*Cleaning Submit*/

    // foreach ($files as $student_id => $photos) {  
    //   if(isset($updates[$student_id])){
    //     foreach ($photos as $key => $photo) {
    //       switch ($key) {
    //         case $updates[$student_id]:
    //           // echo "<pre>".$student_id." ".$updates[$student_id]." ".$key." True</pre>";
    //           $files[$student_id][$key]["checked"]=true;
    //           break;
            
    //         default:
    //           // echo "<pre>".$student_id." ".$updates[$student_id]." ".$key." False</pre>"; 
    //           $files[$student_id][$key]["checked"]=false;
    //           break;
    //       }
    //     }
    //   }else{

    //     foreach ($photos as $key => $photo) {
    //       $files[$student_id][$key]["checked"]=false;
    //     }
    //   }
    // }

    function checkUpdates (&$file, $student_id, $updates){

      if(isset($updates[$student_id])){
        foreach ($file as $key => $photo) {
          switch ($key) {
            case $updates[$student_id]:
              //echo "<pre>".$student_id." ".$updates[$student_id]." ".$key." True</pre>";
              $file[$key]["checked"]=true;
              break;
            
            default:
              //echo "<pre>".$student_id." ".$updates[$student_id]." ".$key." False</pre>"; 
               $file[$key]["checked"]=false;
              break;
          }
        }  
      }else{
        foreach ($file as $key => $photo) {
          //echo "<pre>".$student_id." ".$updates[$student_id]." ".$key." false</pre>";
           $file[$key]["checked"]=false;
        }      
      }
    }
    array_walk($files,'checkUpdates', $updates);


   
    $new_files = json_encode($files);
    file_put_contents($folder_dir.'.json', $new_files);
   
   ?>
   
  <!-- <pre> <?php  print_r($updates); ?></pre>
   <pre> <?php  print_r($files); ?></pre> -->
<?php
    
      break;
    case "Match Orders":
      echo "match redirect";
      break;   
    case "Upload Reshoots":
      echo "Upload Reshoots";
      break; 
    default:
      include_once('actions/upload.php');
      break;
  }
 ?>

<?php 
?>

<div class="wrap">
    <h2>Select Photos</h2>
</div>
<?php if($message){
  echo "<div class='bg-info'>".$message."</div>";
  } ?>
<form method="post" action="<?php echo site_url('/wp-admin/');?>admin.php?page=student_sorter_select" enctype="multipart/form-data"> 
  <section class="select-photos"> 
   <?php include_once('actions/list.php');?>
   <div>
     <?php submit_button("Save for Later",'primary',"submit"); ?>
     <?php submit_button("Match Orders",'primary',"submit"); ?>
   </div>
  </section>

  <input type="file" name="fileToUpload" id="fileToUpload"  multiple="false" />
  <?php submit_button("Upload Reshoots",'primary',"submit"); ?>
</form>