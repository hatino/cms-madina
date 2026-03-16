<?php
//upload.php

use SebastianBergmann\Environment\Console;

if(isset($_POST['jenis_dokumen'])){
    if ($_POST['jenis_dokumen'] == "sejarah") { 
        $obj_file = "file_sejarah";       
        $nama_file_baru = "sejarah";  
        $img_file_path_ori = $_POST['img_file_path_ori'];   
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori); 
    }
    if ($_POST['jenis_dokumen'] == "visimisi") { 
        $obj_file = "file_visimisi";          
        $nama_file_baru = "visimisi";
        $img_file_path_ori = $_POST['img_file_path_ori'];   
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "visimisi_unit_sekolah") { 
        $obj_file = "file_visimisi_unit_sekolah";
        $kode_jenjang = $_POST['kode_jenjang'];
        $nama_file_baru = "visimisi_unit_sekolah_".$kode_jenjang;
        $img_file_path_ori = $_POST['img_file_path_ori'];        
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "konfirmasi") { 
        $obj_file = "file_konfirmasi";     
        $siswa_id =  $_POST['siswa_id'];
        $nama_file_baru = $siswa_id;
        $img_file_path_ori = $_POST['img_file_path_ori'];        
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "kegiatan") { 
        $obj_file = "file_kegiatan";     
        $kegiatan_id =  $_POST['kegiatan_id'];
        $nama_file_baru = $kegiatan_id;
        $img_file_path_ori = $_POST['img_file_path_ori'];        
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "struktur") { 
        $obj_file = "file_struktur";     
        $struktur_id =  $_POST['struktur_id'];
        $nama_file_baru = $struktur_id;
        $img_file_path_ori = $_POST['img_file_path_ori'];        
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "fasilitas") { 
        $obj_file = "file_fasilitas";     
        $struktur_id =  $_POST['fasilitas_id'];
        $nama_file_baru = $struktur_id;
        $img_file_path_ori = $_POST['img_file_path_ori'];        
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "kurikulum") { 
        $obj_file = "file_kurikulum";          
        $kode_jenjang = $_POST['kode_jenjang'];
        $nama_file_baru = "kurikulum_".$kode_jenjang;
        $img_file_path_ori = $_POST['img_file_path_ori'];        
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "prestasi") { 
        $obj_file = "file_prestasi";          
        $prestasi_id =  $_POST['prestasi_id'];
        $nama_file_baru = $prestasi_id;
        $img_file_path_ori = $_POST['img_file_path_ori'];          
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "ekstrakurikuler") { 
        $obj_file = "file_ekstrakurikuler";          
        $prestasi_id =  $_POST['ekstrakurikuler_id'];
        $nama_file_baru = $prestasi_id;
        $img_file_path_ori = $_POST['img_file_path_ori'];          
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "sejarah_sekolah") { 
        $obj_file = "file_sejarah_sekolah";
        $kode_jenjang = $_POST['kode_jenjang'];
        $nama_file_baru = "_sekolah_".$kode_jenjang;
        $img_file_path_ori = $_POST['img_file_path_ori'];        
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);
    }    
    if ($_POST['jenis_dokumen'] == "brosur") { 
        $obj_file = "file_brosur";
        $brosur_id =  $_POST['brosur_id'];
        $thn_ajaran_cls =  $_POST['thn_ajaran_cls'];
        $kode_jenjang = $_POST['kode_jenjang'];
        $nama_file_baru = "brosur_".$kode_jenjang."_".$thn_ajaran_cls."_".$brosur_id;
        $img_file_path_ori = $_POST['img_file_path_ori'];        
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "berita") { 
        $obj_file = "file_berita";
        $berita_id =  $_POST['berita_id'];           
        $idx = $_POST['idx']; 
        if($idx>1){
            $nama_file_baru = "berita_".$berita_id."_".$idx;
        }else{
            $nama_file_baru = "berita_".$berita_id;
        }
        
        $img_file_path_ori = $_POST['img_file_path_ori'];   
             
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
    if ($_POST['jenis_dokumen'] == "lowongan") { 
        $obj_file = "file_lowongan";
        $berita_id =  $_POST['lowongan_id'];                
        $nama_file_baru = "lowongan_".$berita_id;
        $img_file_path_ori = $_POST['img_file_path_ori'];        
        upload_img($obj_file, $nama_file_baru, $img_file_path_ori);         
    }    
}


function upload_img($obj_file, $nama_file_baru, $img_file_path_ori) {    
        
        $status_simpan = $_POST['status_simpan'];
        if($_FILES[$obj_file]["name"] != '')
        { 
            $test = explode('.', $_FILES[$obj_file]["name"]);
            $ext = end($test);
            $name = rand(100, 999) . '.' . $ext;
            
            $location;
            if($status_simpan=='false'){
                $location = './images/images_temp/'.$name;   
            }else{
                if($obj_file == "file_konfirmasi"){
                    $location = './images/images_konfirmasi/'.$nama_file_baru.'.'.$ext; 
                }else{
                    if($obj_file == "file_kegiatan"){
                        $location = './images/images_kegiatan/'.$nama_file_baru.'.'.$ext; 
                    }else{
                        if($obj_file == "file_struktur"){
                            $location = './images/images_struktur/'.$nama_file_baru.'.'.$ext; 
                        }else{
                            if($obj_file == "file_fasilitas"){
                                $location = './images/images_fasilitas/'.$nama_file_baru.'.'.$ext; 
                            }else{
                                if($obj_file == "file_kurikulum"){
                                    $location = './images/images_kurikulum/'.$nama_file_baru.'.'.$ext; 
                                }else{
                                    if($obj_file == "file_prestasi"){
                                        $location = './images/images_prestasi/'.$nama_file_baru.'.'.$ext; 
                                    }else{
                                        if($obj_file == "file_ekstrakurikuler"){
                                            $location = './images/images_ekstrakurikuler/'.$nama_file_baru.'.'.$ext; 
                                        }else{
                                            if($obj_file == "file_brosur"){
                                                $location = './images/images_brosur/'.$nama_file_baru.'.'.$ext; 
                                            }else{
                                                if($obj_file == "file_berita"){
                                                    $location = './images/images_berita/'.$nama_file_baru.'.'.$ext; 
                                                }else{
                                                    if($obj_file == "file_lowongan"){
                                                        $location = './images/images_lowongan/'.$nama_file_baru.'.'.$ext; 
                                                    }else{
                                                        $location = './images/images_sejarah_visimisi/'.$nama_file_baru.'.'.$ext; 
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
                    }
                    
                }                 
            }
            
            move_uploaded_file($_FILES[$obj_file]["tmp_name"], $location);
            //echo '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
            //echo '<img src="'.base_url($location).'" height="150" width="225" class="img-thumbnail" />';
            //echo $name;
            //echo $_SERVER['HTTP_HOST'];
            $source_img = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
            $source_img .= "://" . $_SERVER['HTTP_HOST'];
            $source_img .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
           
            if($status_simpan=='false'){
                $source_img .= "images/images_temp/".$name;
                $path_img = "images/images_temp/".$name;
            }else{
                if($obj_file == "file_konfirmasi"){
                    $source_img .= "images/images_konfirmasi/".$nama_file_baru.".".$ext;
                    $path_img = "images/images_konfirmasi/".$nama_file_baru.".".$ext;
                }else{
                    if($obj_file == "file_kegiatan"){
                        $source_img .= "images/images_kegiatan/".$nama_file_baru.".".$ext;
                        $path_img = "images/images_kegiatan/".$nama_file_baru.".".$ext;
                    }else{
                        if($obj_file == "file_struktur"){
                            $source_img .= "images/images_struktur/".$nama_file_baru.".".$ext;
                            $path_img = "images/images_struktur/".$nama_file_baru.".".$ext;
                        }else{
                            if($obj_file == "file_fasilitas"){
                                $source_img .= 'images/images_fasilitas/'.$nama_file_baru.'.'.$ext; 
                                $path_img = "images/images_fasilitas/".$nama_file_baru.".".$ext;
                            }else{
                                if($obj_file == "file_kurikulum"){
                                    $source_img .= 'images/images_kurikulum/'.$nama_file_baru.'.'.$ext; 
                                    $path_img = "images/images_kurikulum/".$nama_file_baru.".".$ext;
                                }else{
                                    if($obj_file == "file_prestasi"){
                                        $source_img .= 'images/images_prestasi/'.$nama_file_baru.'.'.$ext; 
                                        $path_img = "images/images_prestasi/".$nama_file_baru.".".$ext;
                                    }else{
                                        if($obj_file == "file_ekstrakurikuler"){
                                            $source_img .= 'images/images_ekstrakurikuler/'.$nama_file_baru.'.'.$ext; 
                                            $path_img = "images/images_ekstrakurikuler/".$nama_file_baru.".".$ext;
                                        }else{
                                            if($obj_file == "file_brosur"){
                                                $source_img .= 'images/images_brosur/'.$nama_file_baru.'.'.$ext; 
                                                $path_img = "images/images_brosur/".$nama_file_baru.".".$ext;
                                            }else{
                                                if($obj_file == "file_berita"){
                                                    $source_img .= 'images/images_berita/'.$nama_file_baru.'.'.$ext; 
                                                    $path_img = "images/images_berita/".$nama_file_baru.".".$ext;
                                                }else{
                                                    if($obj_file == "file_lowongan"){
                                                        $source_img .= 'images/images_lowongan/'.$nama_file_baru.'.'.$ext; 
                                                        $path_img = "images/images_lowongan/".$nama_file_baru.".".$ext;
                                                    }else{
                                                        $source_img .= "images/images_sejarah_visimisi/".$nama_file_baru.".".$ext;
                                                        $path_img = "images/images_sejarah_visimisi/".$nama_file_baru.".".$ext;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }                       
                    }                    
                }
                

                $cek_from_temp = strpos($img_file_path_ori,'images_temp');
                
                if($cek_from_temp > 0){       
                    $file_temp = explode('/', $img_file_path_ori);
                    $file_name = end($file_temp);     
                    $file_to_del =  './images/images_temp/'.$file_name;
                    unlink($file_to_del);   
                }
            }
            
            echo json_encode(array("path_view"=>$source_img, "path_save"=>$path_img));        
        }

}
    



// function upload_img_visimisi(){
//     if ($_POST['jenis_dokumen'] == "visimisi") {

//         $status_simpan = $_POST['status_simpan'];
//         if($_FILES["file_visimisi"]["name"] != '')
//         { 
//             $test = explode('.', $_FILES["file_visimisi"]["name"]);
//             $ext = end($test);
//             $name = rand(100, 999) . '.' . $ext; 
            
//             $location;
//             if($status_simpan=='false'){
//                 $location = './images/images_temp/'.$name;   
//             }else{
//                 $location = './images/images_sejarah_visimisi/visimisi.'.$ext; 
//             }
            
//             move_uploaded_file($_FILES["file_visimisi"]["tmp_name"], $location);
//             //echo '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
//             //echo '<img src="'.base_url($location).'" height="150" width="225" class="img-thumbnail" />';
//             //echo $name;
//             //echo $_SERVER['HTTP_HOST'];
//             $source_img = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
//             $source_img .= "://" . $_SERVER['HTTP_HOST'];
//             $source_img .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

//             if($status_simpan=='false'){
//                 $source_img .= "images/images_temp/".$name;
//                 $path_img = "images/images_temp/".$name;
//             }else{
//                 $source_img .= "images/images_sejarah_visimisi/visimisi.".$ext;
//                 $path_img = "images/images_sejarah_visimisi/visimisi.".$ext;
//             }
            
//             echo json_encode(array("path_view"=>$source_img, "path_save"=>$path_img));    
//         }

//     }    
// }

?>
