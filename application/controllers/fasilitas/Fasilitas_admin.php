
<?php

use SebastianBergmann\Environment\Console;

class Fasilitas_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('fasilitas/Mdl_fasilitas'); 
        //check_session();
        if($this->session->has_userdata('user_name')){
            //echo 'session ada';
        }else{
            redirect('auth/login');
        }
    }

    function show_fasilitas_admin() {            
        $kode_jenjang = $this->input->get('kode_jenjang');          
        $data['kode_jenjang'] = $kode_jenjang;
        $this->template->load('template_admin','fasilitas/frm_fasilitas_admin', $data);   
    }

    function get_data_tbl_fasilitas() {
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->Mdl_fasilitas->get_data_tbl_fasilitas($kode_jenjang)->result();
            $fasilitas_arr = array();
           
            foreach ($data as $d)
            {                      
                $fasilitas_id = $d->fasilitas_id;
                $group_cls = $d->group_cls;
                $keterangan = $d->keterangan;               
                $img_path = $d->img_path;
                $fasilitas_arr[] = array("fasilitas_id" => $fasilitas_id,
                                        "group_cls" => $group_cls,
                                        "keterangan" => $keterangan,                                      
                                        "img_path" => $img_path
                                        );                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$fasilitas_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }  
    }


    function simpan_fasilitas(){
        try {                            
            //include 'conn.php';
            $username = $this->session->userdata('user_name'); 
            $_status_edit = $this->input->post('_status_edit');
            $_fasilitas_id = $this->input->post('_fasilitas_id');
            $_kode_jenjang = $this->input->post('_kode_jenjang');
            $keterangan_fasilitas = $this->input->post('txt_keterangan_fasilitas');          
            $uploaded_img_fasilitas_path = $this->input->post('uploaded_img_fasilitas_path');
            
            $rs=$this->Mdl_fasilitas->simpan_fasilitas($_status_edit,
                                                        $_fasilitas_id,
                                                        $_kode_jenjang,
                                                        $keterangan_fasilitas,                                                    
                                                        $uploaded_img_fasilitas_path,
                                                        $username);                    
            
            if($rs['affected_rows']>0){
                if ($_status_edit=='false'){
                    echo json_encode(array('status'=>true,'data'=>$rs['fasilitas_id'], 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>$_fasilitas_id, 'message'=>'Simpan data sukses'));
                }
            }else{
                echo json_encode(array('status'=>true,'data'=>'0', 'message'=>'Simpan data tidak berhasil'));
            }
                       
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }

    
    function simpan_img_path() {
        include 'conn.php';
        $fasilitas_id = $this->input->post('fasilitas_id');
        $img_file_path = $this->input->post('img_file_path');
       
        $query = "
        update  fasilitas 
        set     img_path = '$img_file_path'
            ,   update_date = now()
        where   fasilitas_id = '$fasilitas_id'
        ";
        
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$fasilitas_id, 'message'=>'Simpan data sukses'));

    }

    function delete_fasilitas() {
        
        $fasilitas_id = $this->input->post('fasilitas_id');
        $img_file_path = $this->input->post('img_file_path');

        $ls_query ="
        delete from fasilitas        
        where   fasilitas_id = ?
        ";

        $result = $this->db->query($ls_query,[          
            $fasilitas_id
        ]);

        $affected = $this->db->affected_rows();
        if ($affected>0){
            echo json_encode(array('status'=>true,'data'=>$fasilitas_id, 'message'=>'Hapus data sukses'));               
        }else{
            echo json_encode(array('status'=>true,'data'=>'0', 'message'=>'Hapus data tidak berhasil'));
        }
        

        // $query ="
        // delete  from fasilitas       
        // where   fasilitas_id = '$fasilitas_id'
        // ";
        
        // if (mysqli_query($conn, $query)) {
        //     $rows = mysqli_affected_rows($conn);
        //     if($rows>0){        
        //         $file_temp = explode('/', $img_file_path);
        //         $file_name = end($file_temp);     
        //         $file_to_del =  './images/images_fasilitas/'.$file_name;                                            
        //         unlink($file_to_del);                                         
        //         echo json_encode(array('status'=>true,'data'=>$fasilitas_id, 'message'=>'Hapus data sukses'));               
        //     }else{
        //         echo json_encode(array('status'=>true,'data'=>'0', 'message'=>'Hapus data tidak berhasil'));
        //     }                
        // } 
        // else{
        //     $err_code = mysqli_errno($conn);
        //     if($err_code==1062){
        //         echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
        //     }else{
        //         echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
        //     }            
        // }           
        // mysqli_close($conn);
    }

}

?>