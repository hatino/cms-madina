<?php

class Sosmed_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('sosmed/mdl_sosmed');       
        check_session();
    }   

    function show_sosmed_admin() { 
        $this->template->load('template_admin','sosmed/frm_sosmed_adm'); 
    }

    function get_data_sosmed() {
        try {
            $list_sosmed = $this->input->get('list_sosmed');
            $data=$this->mdl_sosmed->get_data_sosmed($list_sosmed)->result();
            $kegiatan_arr = array();
           
            foreach ($data as $d)
            {                      
                $sosmed_id = $d->sosmed_id;
                $deskripsi = $d->deskripsi;
                $link_video = $d->link_video;             
                $kegiatan_arr[] = array("sosmed_id" => $sosmed_id,
                                        "deskripsi" => $deskripsi,
                                        "link_video" => $link_video                                      
                                        );                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$kegiatan_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }  
    }

    function simpan_sosmed() {
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username'); 
            $_status_edit = $this->input->post('_status_edit');
            $_sosmed_id = $this->input->post('_sosmed_id');
            $txt_deskripsi = $this->input->post('txt_deskripsi');
            $txt_link_video = $this->input->post('txt_link_video');
            $list_sosmed = $this->input->post('list_sosmed');

            //ADD CLASS IN <IFRAME> UNTUK DIGUNAKAN DI HALAMAN USER
            $txt_link_video_idx = strpos($txt_link_video, 'youtube', 1);           
            if($txt_link_video_idx > -1){
                $txt_link_video = str_replace('<iframe ', '<iframe class=cls_yt ',$txt_link_video );
            }else{
                $txt_link_video_idx = strpos($txt_link_video, 'instagram', 1);  
                if($txt_link_video_idx > -1){
                    $txt_link_video = str_replace('<iframe ', '<iframe class=cls_ig ',$txt_link_video );
                }else{
                    $txt_link_video_idx = strpos($txt_link_video, 'facebook', 1);  
                    if($txt_link_video_idx > -1){
                        $txt_link_video = str_replace('<iframe ', '<iframe class=cls_fb ',$txt_link_video );
                    }
                }
            }
                       
            $query=$this->mdl_sosmed->simpan_sosmed($_status_edit,
                                                              $_sosmed_id,                                                        
                                                              $txt_deskripsi,
                                                              $txt_link_video,                                                      
                                                              $username, 
                                                              $list_sosmed);                    
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){     
                    if ($_status_edit=='false'){
                        $sosmed_id = $conn->insert_id;                            
                        echo json_encode(array('status'=>true,'data'=>$sosmed_id, 'message'=>'Simpan data sukses'));
                    }else{
                        $sosmed_id = $_sosmed_id;
                        echo json_encode(array('status'=>true,'data'=>$sosmed_id, 'message'=>'Simpan data sukses'));
                    }
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

    function delete_sosmed() {
        include 'conn.php';
        $sosmed_id = $this->input->post('sosmed_id');
       
        $query ="
        delete  from sosmed       
        where   sosmed_id = '$sosmed_id'
        ";
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){                       
                echo json_encode(array('status'=>true,'data'=>$sosmed_id, 'message'=>'Simpan data sukses'));               
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
    }

}

?>