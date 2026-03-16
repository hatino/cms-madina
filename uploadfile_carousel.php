<?php
if(isset($_POST['jenis_dokumen'])){
    if ($_POST['jenis_dokumen'] == "carousel") {
        $obj_file = $_POST['file_name'];
        $nama_file_baru = $obj_file;
        $img_file_path_ori = $_POST['img_file_path_ori'];          
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori); 
        
    }
}

function upload_img($obj_file, $nama_file_baru, $img_file_path_ori) {    
    $status_simpan = $_POST['status_simpan'];     
    if($_FILES[$obj_file]["name"] != ''){ 
        $test = explode('.', $_FILES[$obj_file]["name"]);       
        $ext = end($test);
        $name = rand(100, 999) . '.' . $ext;
       
        $location;
        if($status_simpan=='false'){
            $location = './images/images_temp/'.$name;   
        }else{           

            $extention = ['gif','png','jpg','jpeg'];
            $nama_file_baru_temp = $nama_file_baru;

            for ($i=0; $i < count($extention) ; $i++) { 
                $file_name_to_check = './images/images_ui/'.$nama_file_baru_temp.'.'.$extention[$i];                
                $file_exists = file_exists($file_name_to_check);              
                if($file_exists>0){
                    unlink($file_name_to_check); 
                }                
            }           
            //preparing file to save
            $location = './images/images_ui/'.$nama_file_baru.'.'.$ext;       
                 
        }
    }
   
    move_uploaded_file($_FILES[$obj_file]["tmp_name"], $location);          
    $source_file = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
    $source_file .= "://" . $_SERVER['HTTP_HOST'];
    $source_file .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    
    if($status_simpan=='false'){
        $source_file .= "images/images_temp/".$name;
        $path_file = "images/images_temp/".$name;

    }else{               
        
        $source_file .= "images/images_ui/".$nama_file_baru.".".$ext;
        $path_file = "images/images_ui/".$nama_file_baru.".".$ext;

        $cek_from_temp = strpos($img_file_path_ori,'images_temp');
        
        if($cek_from_temp > 0){       
            $file_temp = explode('/', $img_file_path_ori);
            $file_name = end($file_temp);     
            $file_to_del =  './images/images_temp/'.$file_name;
            unlink($file_to_del);   
        }
    }
    
    echo json_encode(array("path_view"=>$source_file, "path_save"=>$path_file));        
}

?>