<pre><code>
<?php
$filedir = '/var/www/html/CAP/wp-content/uploads/student_sorter_uploads/cap_test_photos';
 $files = glob('/var/www/html/CAP/wp-content/uploads/student_sorter_uploads/cap_test_photos'."/*.*");
    // usort($files, function($a, $b){
    // 		$exif_a = exif_read_data($a,'ANY_TAG')['FileDateTime'];
    // 		$exif_b = exif_read_data($b,'ANY_TAG')['FileDateTime'];

    //     return $exif_a < $exif_b;
    // });

    foreach ($files as $file) {
    	echo '<br>';
       echo '<img width="100px" src="/wp-content'.explode('/wp-content',$file)[1].'" alt="" class="img-responsive lazyload">';
       // echo $file;
       $qrcode = new QrReader($file);
       echo '<br>'.$text = $qrcode->text();
    }
?>
</pre></code>