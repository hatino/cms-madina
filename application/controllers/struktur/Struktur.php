<?php
class Struktur extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('struktur/mdl_struktur');        
    }

    function show_struktur(){        
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');          
        $this->template->load('template','struktur/frm_struktur',$data); 
    }

    function get_data_struktur() {         
        try {             
            $kode_jenjang = $this->input->get('kode_jenjang');

            //FOR PIMPINAN
            $data=$this->mdl_struktur->get_data_struktur($kode_jenjang,'Pimpinan')->result();
            $struktur_pim_arr = array();            
            foreach ($data as $d)
            {                      
                $struktur_id = $d->struktur_id;
                $kelompok_jabatan = $d->kelompok_jabatan;
                $nama_jabatan = $d->nama_jabatan;
                $nama = $d->nama;
                $no_urut = $d->no_urut;
                $img_path = $d->img_path;
                $struktur_pim_arr[] = array("struktur_id" => $struktur_id,
                                        "kelompok_jabatan" => $kelompok_jabatan,
                                        "nama_jabatan" => $nama_jabatan,
                                        "nama" => $nama,
                                        "no_urut" => $no_urut,
                                        "img_path" => $img_path,
                                        );                                    
            }        

             //FOR WALI KELAS
            $data=$this->mdl_struktur->get_data_struktur($kode_jenjang,'Wali Kelas')->result();
            $struktur_wal_arr = array();
            
            foreach ($data as $d)
            {                      
                $struktur_id = $d->struktur_id;
                $kelompok_jabatan = $d->kelompok_jabatan;
                $nama_jabatan = $d->nama_jabatan;
                $nama = $d->nama;
                $no_urut = $d->no_urut;
                $img_path = $d->img_path;
                $struktur_wal_arr[] = array("struktur_id" => $struktur_id,
                                        "kelompok_jabatan" => $kelompok_jabatan,
                                        "nama_jabatan" => $nama_jabatan,
                                        "nama" => $nama,
                                        "no_urut" => $no_urut,
                                        "img_path" => $img_path,
                                        );                                    
            }     
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data_pim'=>[$struktur_pim_arr],'data_wal'=>[$struktur_wal_arr] , 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }

    function get_data_struktur_yayasan() {         
        try {             
            include 'conn.php'; 
            $sql=$this->mdl_struktur->get_data_tbl_struktur_yayasan();
            $data = mysqli_query($conn, $sql);
            $rows = array();            
            while ($r = mysqli_fetch_assoc($data))
            {                      
               $rows[] = $r; 
            }      
            
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>$rows , 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }

}
?>