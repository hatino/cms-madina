<?php
class Visi_misi extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('visimisi/mdl_visi_misi');       
        // check_session();
    }

    function show_visi_misi() {
        $this->template->load('template','visimisi/frm_visi_misi'); 
    }

    function show_visimisi_unit_sekolah() {
        $data['kode_jenjang'] = $this->input->get('kode_jenjang'); 
        $this->template->load('template','visimisi/frm_visi_misi_unit', $data); 
    }
        
    function get_data_visi_misi() {        
        try {           
            $data=$this->mdl_visi_misi->get_data_visi_misi()->result();
            $visi_misi_arr = array();
            
            foreach ($data as $d)
            {                      
                $visi = $d->visi;
                $misi = $d->misi;
                $photo_visi_path = $d->photo_visi_path;                
                $visi_misi_arr[] = array("visi" => $visi,
                                         "misi" => $misi,
                                         "photo_visi_path" => $photo_visi_path  );                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$visi_misi_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
        
    }
    
    function get_data_visimisi_unit_sekolah() {        
        try {           
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->mdl_visi_misi->get_data_visimisi_unit_sekolah($kode_jenjang)->result();
            $visi_misi_arr = array();           
            foreach ($data as $d)
            {                      
                $visi = $d->visi;
                $misi = $d->misi;
                $photo_visi_path = $d->photo_visi_path;        
                $nama = $d->nama;                
                $visi_misi_arr[] = array("visi" => $visi,
                                         "misi" => $misi,
                                         "photo_visi_path" => $photo_visi_path,
                                         "nama" => $nama  
                                        );                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$visi_misi_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
        
    }

}

?>