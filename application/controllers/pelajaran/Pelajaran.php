<?php
class Pelajaran extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('pelajaran/mdl_pelajaran');   
    }

    function show_pelajaran() {   
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');
        $this->template->load('template','pelajaran/frm_pelajaran',$data);
    }

    function get_data_tbl_pelajaran() {
        try {
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data = $this->mdl_pelajaran->get_data_pelajaran($kode_jenjang)->result();
            $data2 = $this->mdl_pelajaran->get_data_tbl_pelajaran($kode_jenjang)->result();

            echo json_encode(array('status'=>true, 'data'=>[$data], 'data2'=>[$data2], 'message'=>"")) ; 
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>$e->errorMessage())) ;
        }
    }

    function get_data_pelajaran_home() {
        try {           
            $data = $this->mdl_pelajaran->get_data_pelajaran_home()->result();         
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ; 
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>$e->errorMessage())) ;
        }
    }
        
}
?>