
<?php
class Ekstrakurikuler extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('ekstrakurikuler/Mdl_ekstrakurikuler');        
    }

    function show_ekstrakurikuler() {            
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template','ekstrakurikuler/frm_ekstrakurikuler', $data);   
    }

    function get_data_ekstrakurikuler() {
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->Mdl_ekstrakurikuler->get_data_tbl_ekstrakurikuler($kode_jenjang)->result();
            $ekstrakurikuler_arr = array();
           
            foreach ($data as $d)
            {                      
                $ekstrakurikuler_id = $d->ekstrakurikuler_id;
                $nama_ekstrakurikuler = $d->nama_ekstrakurikuler;             
                $img_path = $d->img_path;
                $ekstrakurikuler_arr[] = array("ekstrakurikuler_id" => $ekstrakurikuler_id,
                                        "nama_ekstrakurikuler" => $nama_ekstrakurikuler,                                      
                                        "img_path" => $img_path,
                                        );                                                  
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$ekstrakurikuler_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }  
    }

}
?>