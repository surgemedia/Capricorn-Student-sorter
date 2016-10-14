<pre><code>
<?php
$filedir = '/var/www/html/CAP/wp-content/uploads/student_sorter_uploads/cap_test_photos';
$files = glob('/var/www/html/CAP/wp-content/uploads/student_sorter_uploads/cap_test_photos'."/*.*");
$react_array = array();
$current_student;
    foreach ($files as $file) {
      $qrcode = new QrReader($file);
      if(strlen($qrcode->text()) > 0){
        $current_student = $qrcode->text();
      } else {
        if($current_student){
          $react_array[$current_student] = array();
          array_push($react_array[$current_student],'/wp-content'.explode('/wp-content',$file)[1]);
        }
      }
    }
    print_r($react_array);
?>
</pre></code>