<?php
$upload = wp_upload_dir();
    $upload_dir = $upload['basedir'];
    $upload_dir = $upload_dir . '/student_sorter_uploads';
    wp_mkdir_p($upload_dir);
?>