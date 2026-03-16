<?php
class Lowongan extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('lowongan/mdl_lowongan');       
        //check_session();
    }

    function show_lowongan() {
        $this->template->load('template','lowongan/frm_lowongan');   
    }

    function get_data_lowongan() {
        try {           
            $data=$this->mdl_lowongan->get_data_lowongan()->result();
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;  
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }
    
    function get_data_lowongan_home() {
        try {           
            $data=$this->mdl_lowongan->get_data_lowongan_home()->result();
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;  
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }
    
}
?>