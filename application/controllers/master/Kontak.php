
<?php
class Kontak extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('master/mdl_profil'); 
    }

    function show_kontak(){        
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');
        $this->template->load('template','master/frm_kontak', $data);
    }

    function get_data_alamat(){        
        try {                  
            $data=$this->mdl_profil->get_data_profil_yayasan()->result();
          
            $profil_arr = array();
        
            foreach ($data as $d)
            {       
                $nama = $d->nama;
                $alamat = $d->alamat;
                $telp = $d->telp;
                $no_hotline = $d->no_hotline;
                $sejarah = $d->sejarah;
                $photo_sejarah_path = $d->photo_sejarah_path;
                $visi = $d->visi;
                $misi = $d->misi;
                $photo_visi_path = $d->photo_visi_path;
                $google_map = $d->google_map;

                $profil_arr[] = array("nama" => $nama,
                                    "alamat" => $alamat,
                                    "telp" => $telp,
                                    "no_hotline" => $no_hotline,
                                    "sejarah" => $sejarah,
                                    "photo_sejarah_path" => $photo_sejarah_path,
                                    "visi" => $visi,
                                    "misi" => $misi,
                                    "photo_visi_path" => $photo_visi_path,
                                    "google_map" => $google_map);
            }           
           
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$profil_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }

    function get_data_alamat_unit_sekolah(){        
        try {                  
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->mdl_profil->get_data_profil_unit_sekolah($kode_jenjang)->result();
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;               
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }


    function get_data_kontak_unit(){        
        try {                  
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->mdl_profil->get_data_kontak_unit($kode_jenjang)->result();          
            $hotline_arr = array();
            
            foreach ($data as $d)
            {       
                $group_cls = $d->group_cls;
                $nama = $d->nama;
                $no_hotline = $d->no_hotline;
                $nama_petugas = $d->nama_petugas;
               
                $hotline_arr[] = array("group_cls" => $group_cls,
                                        "nama" => $nama,
                                        "no_hotline" => $no_hotline,
                                        "nama_petugas" => $nama_petugas,
                                       );
            }           
           
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$hotline_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }

    function get_data_visitors(){
        try {
            $rs_today = $this->mdl_profil->get_data_visitors_today()->result();
            $rs_yesterday = $this->mdl_profil->get_data_visitors_yesterday()->result();
            $rs_lastweek = $this->mdl_profil->get_data_visitors_lastweek()->result();
            $rs_online = $this->mdl_profil->get_data_visitors_online()->result();
            $rs_total = $this->mdl_profil->get_data_visitors_total()->result();
            $rs = array_merge($rs_today,$rs_yesterday, $rs_lastweek, $rs_online, $rs_total);
            echo json_encode(array('status'=>true, 'data'=>$rs, 'message'=>"")) ; 
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>"Error while get data")) ;
        }
    }
    
}
?>