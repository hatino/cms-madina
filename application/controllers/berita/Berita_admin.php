<?php

use phpDocumentor\Reflection\Types\This;
use SebastianBergmann\Environment\Console;

class Berita_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('berita/mdl_berita');       
        check_session();
    }
    
    function show_berita_admin() {              
        $this->template->load('template_admin','berita/frm_berita_adm');   
    }

    function get_data_tbl_berita() {
        try {                 
            include 'conn.php';       
            $page = $this->input->get('page');           
            $limit = $this->input->get('limit'); 
            $offset = ((int)$page - 1) * (int)$limit;            
          
            $query="
            select  berita_id, judul_berita, deskripsi_berita
                ,   ifnull(img_path,'') as img_path
                ,   ifnull(img_path_2,'') as img_path_2
                ,   ifnull(img_path_3,'') as img_path_3            
            from    berita       
            order by update_date desc
            limit $limit offset $offset ";
                         
            $sth = mysqli_query($conn, $query);
            $rows = array();
            while($r = mysqli_fetch_assoc($sth)) {
                $rows[] = $r;
            }

            $query2="select count(*) as count from berita ";
            $result = mysqli_query($conn, $query2);
            $tot_rows =0;
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                // print_r($row['count']);
                $tot_rows = $row['count'];
            }
           
            $tot_pages = ceil($tot_rows/$limit);
            //print_r($result) ;
          
            echo json_encode(array(
                'status'=>true,
                'message'=>"",
                'data'=>[$rows],                
                'page'=> $page,
                'limit'=> $limit,
                'total_page'=> $tot_pages
            ));
           
            mysqli_close($conn);
            // $data=$this->mdl_berita->get_data_tbl_berita()->result();   
            // echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }

    function delete_berita() {
        include 'conn.php';
        $berita_id = $this->input->post('berita_id');
        //$img_file_path = $this->input->post('img_file_path');
        $data_path = $this->input->post('data_path');

        $query ="
        delete  from berita       
        where   berita_id = '$berita_id'
        ";
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){        

                if ($data_path){
                    foreach ($data_path as $i => $img_path) {     
                        //var_dump($data_path) ;                    
                        $cek_from_temp = strpos($data_path[$i],'images_berita');                
                        if($cek_from_temp > 0){       
                            $file_temp = explode('/', $img_path);
                            $file_name = end($file_temp);     
                            $file_to_del =  './images/images_berita/'.$file_name;
                            unlink($file_to_del);   
                        }     
                    }
                }
                

                // if ($img_file_path != ''){
                //     $file_temp = explode('/', $img_file_path);
                //     $file_name = end($file_temp);     
                //     $file_to_del =  './images/images_berita/'.$file_name;                                            
                //     unlink($file_to_del);    
                // }                                                     
                echo json_encode(array('status'=>true,'data'=>$berita_id, 'message'=>'Simpan data sukses'));               
            }else{
                echo json_encode(array('status'=>true,'data'=>'0', 'message'=>'Simpan data tidak berhasil'));
            }                
        } 
        else{
            $err_code = mysqli_errno($conn);
            if($err_code==1062){
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
            }else{
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
            }            
        }        
        
        mysqli_close($conn);
    }

    function simpan_berita(){
        try {                            
            include 'conn.php';
            // var_dump($this->input->post());
            //var_dump($_FILES);
            $username = $this->session->userdata('username'); 
            $_status_edit = $this->input->post('_status_edit');
            $_berita_id = $this->input->post('_berita_id');  
            $txt_judul_berita = $this->input->post('txt_judul_berita');     
            $txt_judul_berita = str_replace("'","''",$txt_judul_berita);
            $txt_deskripsi_berita = $this->input->post('txt_deskripsi_berita');
            $txt_deskripsi_berita = str_replace("'","''",$txt_deskripsi_berita);
            $data_path = $this->input->post('img_path');            
            
            $query=$this->mdl_berita->simpan_berita($_status_edit,
                                                    $_berita_id,
                                                    $txt_judul_berita,
                                                    $txt_deskripsi_berita,                                                    
                                                    $username);                    
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){     
                    
                    if ($_status_edit=='false'){      
                        $berita_id = $conn->insert_id;    
                    }else{
                        $berita_id = $_berita_id;
                    }  

                    foreach ($_FILES['img']['tmp_name'] as $i => $tmp) {
                        if ($_FILES['img']['name'][$i]!=""){
                            $test = explode('.', $_FILES["img"]["name"][$i]);
                            $ext = end($test);
                            $idx = $i+1;
                            if($i==0){
                                $nama_file_baru = './images/images_berita/berita_'.$berita_id.'.'.$ext; 
                                $source_img = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                                $source_img .= "://" . $_SERVER['HTTP_HOST'];
                                $source_img .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
                                $source_img .= 'images/images_berita/berita_'.$berita_id.'.'.$ext;
                                //simpan path
                                $ls_query ="
                                update  berita
                                set     img_path = '$source_img'
                                where   berita_id = '$berita_id'";
                                mysqli_query($conn, $ls_query,);
                            
                            }else{
                                $nama_file_baru = './images/images_berita/berita_'.$berita_id.'_'.$idx.'.'.$ext;
                                $source_img = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                                $source_img .= "://" . $_SERVER['HTTP_HOST'];
                                $source_img .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
                                $source_img .= 'images/images_berita/berita_'.$berita_id.'_'.$idx.'.'.$ext;
                                if($i+1==2){
                                    $ls_query ="
                                    update  berita
                                    set     img_path_2 = '$source_img'
                                    where   berita_id = '$berita_id'";
                                    mysqli_query($conn, $ls_query);
                                }
                                if($i+1==3){
                                    $ls_query ="
                                    update  berita
                                    set     img_path_3 = '$source_img'
                                    where   berita_id = '$berita_id'";
                                    mysqli_query($conn, $ls_query);
                                }                                    
                            }          

                            move_uploaded_file($tmp, $nama_file_baru);
                        }                        
                    }         
                        
                    foreach ($data_path as $j => $img_path) {
                        //hapus file temp
                        $cek_from_temp = strpos($data_path[$j],'images_temp');                
                        if($cek_from_temp > 0){       
                            $file_temp = explode('/', $img_path);
                            $file_name = end($file_temp);     
                            $file_to_del =  './images/images_temp/'.$file_name;
                            unlink($file_to_del);   
                        }     
                    }                    
                    
                    echo json_encode(array('status'=>true,'data'=>$berita_id, 'message'=>'Simpan data sukses'));
                                       
                }else{
                    echo json_encode(array('status'=>true,'data'=>'0', 'message'=>'Simpan data tidak berhasil'));
                }                
            } 
            else{
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
                }            
            }
           
            mysqli_close($conn);
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }

    function simpan_path() {
        
    }

    function simpan_img_path() {
        include 'conn.php';        
        $berita_id = $this->input->post('berita_id');
        $img_file_path = $this->input->post('img_file_path');
        $idx = $this->input->post('idx');

        if($idx>1){
            $idx_a = '_'.$idx;
        }else{
            $idx_a = '';
        }
               
        $query = "
        update  berita 
        set     img_path".$idx_a." = '$img_file_path'
            ,   update_date = now()
        where   berita_id = '$berita_id'
        ";
        
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$berita_id, 'message'=>'Simpan data sukses'));
    }


}

?>