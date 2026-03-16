
<?php
class Kurikulum extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('kurikulum/Mdl_kurikulum');        
    }

    function show_kurikulum() {            
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template','kurikulum/frm_kurikulum', $data);   
    }

    function get_data_kurikulum() {            
        try {                
            
            $kode_jenjang = $this->input->get('kode_jenjang');   
            $data=$this->Mdl_kurikulum->get_data_kurikulum($kode_jenjang)->result();
          
            $kurikulum_arr = array();
        
            foreach ($data as $d)
            {       
                $penjelasan = $d->penjelasan;
                $sistem_pembelajaran_nilai = $d->sistem_pembelajaran_nilai;
                $img_path = $d->img_path;
               
                $kurikulum_arr[] = array("penjelasan" => $penjelasan,
                                    "sistem_pembelajaran_nilai" => $sistem_pembelajaran_nilai,
                                    "img_path" => $img_path);
            }                      
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$kurikulum_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }     
    }
    
    function get_data_kurikulum_home() {            
        try {
            $data=$this->Mdl_kurikulum->get_data_kurikulum_home()->result();            
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }     
    }

}
?>