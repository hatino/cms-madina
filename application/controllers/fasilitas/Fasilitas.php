
<?php
class Fasilitas extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('fasilitas/Mdl_fasilitas');         
    }

    function show_fasilitas() {            
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template','fasilitas/frm_fasilitas', $data);   
    }

    function get_data_fasilitas() {
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

    function get_data_fasilitas_home() {
        try {              
            $query = $this->Mdl_fasilitas->get_data_fasilitas_home();  
            $data= $query->result_array();           
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }  
    } 
}

?>
