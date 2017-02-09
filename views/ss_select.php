<?php 
    //Uploads and unzips photos
    include_once('actions/upload.php');
?>
<div class="wrap">
    <h2>Select Photos</h2>
</div>

<form method="post" action="<?php echo site_url('/wp-admin/');?>admin.php?page=student_sorter_select" enctype="multipart/form-data"> 
  <section class="select-photos"> 
   <?php include_once('actions/list.php');?>
   <?php submit_button(); ?>
  </section>
</form>