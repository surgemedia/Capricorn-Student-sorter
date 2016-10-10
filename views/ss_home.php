    <div class="wrap">
        <h2>Upload Student Photos</h2>
    </div>
    <?php //update_option( 'ss_zips', ''); ?>
    <form id="featured_upload" method="post" action="/wp-admin/admin.php?page=student_sorter_select" enctype="multipart/form-data">
	<input type="file" name="fileToUpload" id="fileToUpload"  multiple="false" />
	<input type="hidden" name="post_id" id="post_id" value="<?php echo rand(9000,1000); ?>" />
	<?php wp_nonce_field( 'fileToUpload', 'fileToUpload_nonce' ); ?>
	<?php submit_button('Sort Photo','primary'); ?>
	</form>
		</div>