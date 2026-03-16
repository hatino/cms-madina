<?php
if(isset($_POST['jenis_dokumen'])){
    if ($_POST['jenis_dokumen'] == "dokumen_persyaratan") { 
        $obj_file = 'file_name';         
        $siswa_id =  $_POST['siswa_id'];       
        $element_id = $_POST['element_id'];  
        $nama_file_baru = $siswa_id."_".$element_id;
        $img_file_path_ori = $_POST['file_path_ori'];   
        //var_dump($_POST);   
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori, $element_id); 
        // extract($_POST);        
    }
}


function upload_img($obj_file, $nama_file_baru, $img_file_path_ori, $element_id) {    
    $status_simpan = $_POST['status_simpan'];
    if($_FILES[$obj_file]["name"] != '')
    { 
        $test = explode('.', $_FILES[$obj_file]["name"]);
        $ext = end($test);
        $name = rand(100, 999) . '.' . $ext;
        
        $location;
        if($status_simpan=='false'){
            $location = './uploads/dokumen_temp/'.$name;   
        }else{           
            $location = './uploads/dokumen/'.$nama_file_baru.'.'.$ext;            
        }
    }

    move_uploaded_file($_FILES[$obj_file]["tmp_name"], $location);          
            $source_file = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
            $source_file .= "://" . $_SERVER['HTTP_HOST'];
            $source_file .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
           
            if($status_simpan=='false'){
                $source_file .= "uploads/dokumen_temp/".$name;
                $path_file = "uploads/dokumen_temp/".$name;
            }else{
               
                $source_file .= "uploads/dokumen_temp/".$nama_file_baru.".".$ext;
                $path_file = "uploads/dokumen/".$nama_file_baru.".".$ext;

                $cek_from_temp = strpos($img_file_path_ori,'dokumen_temp');
                
                if($cek_from_temp > 0){       
                    $file_temp = explode('/', $img_file_path_ori);
                    $file_name = end($file_temp);     
                    $file_to_del =  './uploads/dokumen_temp/'.$file_name;
                    unlink($file_to_del);   
                }
            }
            
            echo json_encode(array("path_view"=>$source_file, "path_save"=>$path_file, "element_id"=>$element_id));        
        }

?>