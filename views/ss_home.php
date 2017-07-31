<div class="plugin-container">
    <!-- <h2>Upload Student Photos</h2> -->

<?php //update_option( 'ss_zips', ''); ?>
<form id="featured_upload" method="post" action="<?php echo site_url('/wp-admin/');?>admin.php?page=student_sorter_select" enctype="multipart/form-data">
	<fieldset>
	<legend>UPLOAD NEW SHOOT</legend>
	<?php 
		$terms = get_terms( array(
								    'taxonomy' => 'school',
								    'hide_empty' => false,
											) );
	 ?>
	<div class="wrapper">
		<div class="block">	
			<div class="field">
				<label class="label">School:</label> 
				  <select name="school" id="search_school" class="">
				    <?php foreach ($terms as $key => $value) { ?>
				      <option value="<?php echo $value->slug;?>" ><?php echo $value->name;?></option>
				    <?php } ?>
				  </select>
			</div>
			 <div class="field">
			 	<label class="label">Year:</label>  
			 	 <select name="year" class="">
			 	         <option value="16" >2016</option>
			 	         <option value="17" >2017</option>
			 	 </select>
			 </div>
			<input type="file" name="fileToUpload" id="fileToUpload"  multiple="false" />
			<?php wp_nonce_field( 'fileToUpload', 'fileToUpload_nonce' ); ?>
			<?php submit_button('upload zip','primary'); ?>
		</div>
	</div>
	<input type="hidden" name="post_id" id="post_id" value="<?php echo rand(9000,1000); ?>" />
	</fieldset>
		<div class="or">Or</div>
	<fieldset>
	<legend>VIEW PREVIOUS UPLOADS</legend>
		<div class="wrapper">
			<div class="block">	
				<div class="field">
				<label class="label">Photo Shoots:</label> 
				  <select name="photo_shoot" id="search_photo_shoot" class="">
				 <?php   // WP_Query arguments
						$args = array(
							'post_type'              => array( 'photo_shoots' ),
						);

						// The Query
						$query = new WP_Query( $args );

						// The Loop
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post(); ?>
								<option value="<?php echo get_the_id();?>" ><?php echo get_the_title();?></option>
					<?php	}
						} else {
							// no posts found
						}

						// Restore original Post Data
						wp_reset_postdata();
						?>
				      
				   
				  </select>
			</div>
				<?php submit_button('preview','primary'); ?>
			</div>
		</div>	
	</fieldset>
</form>
</div>