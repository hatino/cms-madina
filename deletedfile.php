<?php
if(isset($_POST['img_file_path'])){
    $file_path = $_POST['img_file_path'];
    if (file_exists('./'.$file_path)) {
        unlink('./'.$file_path);  
    } 
     echo json_encode(array("pesan"=>'hapus berhasil')); 
}

?>