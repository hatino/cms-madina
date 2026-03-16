<?php
class Lowongan_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('lowongan/Mdl_lowongan'); 
        check_session();
    }

    function show_lowongan_admin() {                   
        $this->template->load('template_admin','lowongan/frm_lowongan_adm');   
    }

    function get_data_tbl_lowongan() {      
        try {           
            $data=$this->Mdl_lowongan->get_data_tbl_lowongan()->result();
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;  
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }

    function simpan_img_path() {
        include 'conn.php';
        $lowongan_id = $this->input->post('lowongan_id');
        $img_file_path = $this->input->post('img_file_path');
       
        $query = "
        update  lowongan 
        set     img_path = '$img_file_path'
            ,   update_date = now()
        where   lowongan_id = '$lowongan_id'
        ";
        
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$lowongan_id, 'message'=>'Simpan data sukses'));
    }


    function simpan_lowongan(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username'); 
            $_status_edit = $this->input->post('_status_edit');
            $_lowongan_id = $this->input->post('_lowongan_id');  
            $list_status_lowongan = $this->input->post('list_status_lowongan');                     
            $txt_deskripsi_lowongan = $this->input->post('txt_deskripsi_lowongan');
            $uploaded_img_lowongan_path = $this->input->post('uploaded_img_lowongan_path');          
            $txt_deskripsi_lowongan = str_replace("'","''",$txt_deskripsi_lowongan);
            
            $query=$this->Mdl_lowongan->simpan_lowongan($_status_edit,
                                                    $_lowongan_id,
                                                    $list_status_lowongan,
                                                    $txt_deskripsi_lowongan,
                                                    $uploaded_img_lowongan_path,
                                                    $username);                    
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){     
                    if ($_status_edit=='false'){
                        $lowongan_id = $conn->insert_id;                            
                        echo json_encode(array('status'=>true,'data'=>$lowongan_id, 'message'=>'Simpan data sukses'));
                    }else{
                        $lowongan_id = $_lowongan_id;
                        echo json_encode(array('status'=>true,'data'=>$lowongan_id, 'message'=>'Simpan data sukses'));
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

    function delete_lowongan() {
        include 'conn.php';
        $lowongan_id = $this->input->post('lowongan_id');
        $img_file_path = $this->input->post('img_file_path');

        $query ="
        delete  from lowongan       
        where   lowongan_id = '$lowongan_id'
        ";
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){        
                if ($img_file_path != ''){
                    $file_temp = explode('/', $img_file_path);
                    $file_name = end($file_temp);     
                    $file_to_del =  './images/images_lowongan/'.$file_name;                                            
                    unlink($file_to_del);    
                }                                                     
                echo json_encode(array('status'=>true,'data'=>$lowongan_id, 'message'=>'Simpan data sukses'));               
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