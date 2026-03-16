<?php

if(isset($_POST['jenis_dokumen'])){
    if ($_POST['jenis_dokumen'] == "soal_pg") {
        $obj_file = 'file_img_soal_pg';
        $soal_pg_id =  $_POST['soal_pg_id']; 
        $nama_file_baru = 'soal_pg_'.$soal_pg_id;
        $img_file_path_ori = $_POST['img_file_path_ori'];          
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);                         
    }
    if ($_POST['jenis_dokumen'] == "soal_essai") {
        $obj_file = 'file_img_soal_essai';
        $soal_essai_id =  $_POST['soal_essai_id']; 
        $nama_file_baru = 'soal_essai_'.$soal_essai_id;
        $img_file_path_ori = $_POST['img_file_path_ori'];          
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);                         
    }
    if ($_POST['jenis_dokumen'] == "jawaban_pg"){
        $obj_file = 'file_img_jawaban';
        $soal_pg_id =  $_POST['soal_pg_id'];         
        $img_file_path_ori = $_POST['img_file_path_ori'];      
        $idx = $_POST['idx'];       
        $nama_file_baru = 'jawaban_pg_'.$soal_pg_id.'_'.$idx;
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori); 
    }
}

function upload_img($obj_file, $nama_file_baru, $img_file_path_ori) {
    // var_dump($_POST);
    $status_simpan = $_POST['status_simpan']; 

    if($status_simpan=='false'||$status_simpan=='true'){    
        if($_FILES[$obj_file]["name"] != ''){ 
            $test = explode('.', $_FILES[$obj_file]["name"]);       
            $ext = end($test);
            $name = rand(100, 999) . '.' . $ext;
        
            $location;
            if($status_simpan=='false'){
                $location = './images/images_temp/'.$name;   
            }else{        
                
                if($status_simpan=='true'){
                    $extention = ['gif','png','jpg','jpeg'];
                    $nama_file_baru_temp = $nama_file_baru;

                    for ($i=0; $i < count($extention) ; $i++) { 
                        $file_name_to_check = './images/images_soal/'.$nama_file_baru_temp.'.'.$extention[$i];                
                        $file_exists = file_exists($file_name_to_check);              
                        if($file_exists>0){
                            unlink($file_name_to_check); 
                        }                
                    }           
                    //preparing file to save
                    $location = './images/images_soal/'.$nama_file_baru.'.'.$ext;     
                } 
                            
            }
        }       
    
        move_uploaded_file($_FILES[$obj_file]["tmp_name"], $location);          
        $source_file = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $source_file .= "://" . $_SERVER['HTTP_HOST'];
        $source_file .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    }
    
    if($status_simpan=='false'){
        $source_file .= "images/images_temp/".$name;
        $path_file = "images/images_temp/".$name;
        echo json_encode(array("path_view"=>$source_file, "path_save"=>$path_file, "message"=>""));  
    }              

    if($status_simpan=='true'){
        $source_file .= "images/images_soal/".$nama_file_baru.".".$ext;
        $path_file = "images/images_soal/".$nama_file_baru.".".$ext;

        $cek_from_temp = strpos($img_file_path_ori,'images_temp');
        
        if($cek_from_temp > 0){       
            $file_temp = explode('/', $img_file_path_ori);
            $file_name = end($file_temp);     
            $file_to_del =  './images/images_temp/'.$file_name;
            unlink($file_to_del);   
        }
        echo json_encode(array("path_view"=>$source_file, "path_save"=>$path_file, "message"=>""));  
    }      
        
    if($status_simpan=='hapus'){     
        $file_temp = explode('/', $img_file_path_ori);
        $file_name = end($file_temp);     
        $file_to_del =  './images/images_soal/'.$file_name;
        unlink($file_to_del); 
        echo json_encode(array("path_view"=>"", "path_save"=>"", "message"=>"Hapus image berhasil"));  
    }   

}

?>