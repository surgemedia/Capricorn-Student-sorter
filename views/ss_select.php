    <?php 
        //Uploads and unzips photos
		include_once('actions/upload.php');
        include_once('actions/list.php');

    ?>
    <div class="wrap">
        <h2>Select Photos</h2>
    </div>
    <form method="post" action="forms/upload.php"> 
		<?php submit_button(); ?>
		</form>
		</div>