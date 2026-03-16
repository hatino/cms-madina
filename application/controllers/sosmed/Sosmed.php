<?php
class Sosmed extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('sosmed/mdl_sosmed');       
        //check_session();
    }

    function show_sosmed() {          
        $data['kode_sosmed'] = $this->input->get('kode_sosmed');
        $this->template->load('template','sosmed/frm_sosmed', $data);        
    }
    
    function data_link_yt(){        
        try {
            $kode_sosmed = $this->input->get('kode_sosmed');
            $data=$this->mdl_sosmed->get_data_link_yt($kode_sosmed)->result();
            $link_yt_arr = array();
          
            foreach ($data as $d)
            {       
                $sosmed_id = $d->sosmed_id;
                $deskripsi = $d->deskripsi;
                $link_video = $d->link_video;  
                $kode_sosmed = $d->kode_sosmed;            
                $link_yt_arr[] = array("sosmed_id" => $sosmed_id,
                                    "deskripsi" => $deskripsi,
                                    "link_video" => $link_video,
                                    "kode_sosmed" => $kode_sosmed
                                    );
            }
        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$link_yt_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }

    function get_data_sosmed_dtl(){        
        try {
            $kode_sosmed = $this->input->get('kode_sosmed');
            $data=$this->mdl_sosmed->get_data_sosmed_dtl($kode_sosmed)->result();
            $link_yt_arr = array();
          
            foreach ($data as $d)
            {       
                $sosmed_id = $d->sosmed_id;
                $deskripsi = $d->deskripsi;
                $link_video = $d->link_video;  
                $kode_sosmed = $d->kode_sosmed;            
                $link_yt_arr[] = array("sosmed_id" => $sosmed_id,
                                    "deskripsi" => $deskripsi,
                                    "link_video" => $link_video,
                                    "kode_sosmed" => $kode_sosmed
                                    );
            }
        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$link_yt_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }

}

?>