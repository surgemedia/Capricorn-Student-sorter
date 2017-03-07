<div class="wrap">
    <h2>Upload Student Photos</h2>
</div>
<?php //update_option( 'ss_zips', ''); ?>
<form id="featured_upload" method="post" action="<?php echo site_url('/wp-admin/');?>admin.php?page=student_sorter_select" enctype="multipart/form-data">
	<input type="file" name="fileToUpload" id="fileToUpload"  multiple="false" />
	<input type="hidden" name="post_id" id="post_id" value="<?php echo rand(9000,1000); ?>" />
	<?php wp_nonce_field( 'fileToUpload', 'fileToUpload_nonce' ); ?>
	<?php submit_button('Sort Photo','primary'); ?>

	<select name="load" id="">
		<option value="load_empty">---Select one file---</option>
		<?php 
			$previous_loads = glob(wp_upload_dir()['basedir'] . "/student_sorter_uploads/*.json");
			
			foreach ($previous_loads as $key => $value) { 
				$file_name= explode("/student_sorter_uploads/",$value)[1];
				$folder_name = explode(".json",$value)[0];
				?>
		<option value="<?php echo $folder_name;?>"><?php echo $file_name; ?></option>
		
		<?php	} ?>
	</select>
	<?php submit_button('Load','primary'); ?>
</form>
</div>