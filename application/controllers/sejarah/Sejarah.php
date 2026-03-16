<?php
class Sejarah extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('sejarah/mdl_sejarah');       
        //check_session();
    }

    function show_sejarah() {   
        $this->template->load('template','sejarah/frm_sejarah_yayasan'); 
    }

    function show_sejarah_sekolah() {   
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');
        $this->template->load('template','sejarah/frm_sejarah_sekolah', $data); 
    }

    function get_data_sejarah() {
        try {            
            $data=$this->mdl_sejarah->get_data_sejarah()->result();
            $sejarah_arr = array();
           
            foreach ($data as $d)
            {                      
                $sejarah = $d->sejarah;
                $photo_sejarah_path = $d->photo_sejarah_path;                
                $sejarah_arr[] = array("sejarah" => $sejarah,
                                       "photo_sejarah_path" => $photo_sejarah_path);                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$sejarah_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }

    function get_data_sejarah_yayasan_home() {
        try {            
            $data=$this->mdl_sejarah->get_data_sejarah_yayasan_home()->result();           
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }
    
    function get_data_sejarah_sekolah() {
        try {     
            include 'conn.php'; 
            $kode_jenjang = $this->input->get('kode_jenjang');
            $sql = $this->mdl_sejarah->get_data_sejarah_sekolah($kode_jenjang);           
            $data = mysqli_query($conn, $sql);
            $rows = array();
            while($r = mysqli_fetch_assoc($data)) {
                $rows[] = $r;
            }
            echo json_encode(array('status'=>true, 'data'=>$rows, 'message'=>""));
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }

    function get_data_sejarah_unit_sekolah_home() {
        try {                
            $data = $this->mdl_sejarah->get_data_sejarah_unit_sekolah_home()->result();
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>""));
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }    
    
}

?>


