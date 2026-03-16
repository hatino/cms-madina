<?php

class Running_text extends ci_controller{
    function __construct() {
        parent::__construct();
        $this->load->model('ujian/Mdl_running_text');
    }

    function show_running_text(){
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();  
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }            
                        
            $data['username'] = $username; 
            $data['status_user'] = $status_user;    
            $this->template->load('template_ujian','ujian/frm_running_text', $data); 
            
        }else{
            redirect('auth/login_ujian'); 	
        }
    }

    function get_data_running_text(){                
        $data = $this->Mdl_running_text->get_data_running_text()->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));        
    }

    function hapus_running_text() {
        try {
            include 'conn.php';           
            $query = $this->Mdl_running_text->hapus_running_text();           
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){                    
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data tidak berhasil'));
                }                
            } 
            else 
            {
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }
                else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
                }            
            }
           
            mysqli_close($conn);            

        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }

    function simpan_running_text() {
        try {
            include 'conn.php';
            $username = $this->session->userdata('username');  
            $data = $this->input->post();
            $rs = $this->Mdl_running_text->get_data_running_text()->result();   
            $jml = count($rs);    
            $query = $this->Mdl_running_text->simpan_running_text($data, $jml, $username);           
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){                    
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
                }                
            } 
            else 
            {
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }
                else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
                }            
            }
           
            mysqli_close($conn);            

        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }
}

?>