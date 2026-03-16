<?php
class Pendaftaran extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('pendaftaran/mdl_pendaftaran');
        $this->load->model('master/mdl_thn_ajaran');
    }

    
    function show_info_pendaftaran(){        
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');  
        $data['nama_jenjang'] = $this->input->get('nama_jenjang');    
        $this->template->load('template','pendaftaran/frm_info_pendaftaran',$data); 
    }

    function show_input_pendaftaran () {     
        $data['kode_jenjang'] = $this->input->get('kode_jenjang'); 
        $data['thn_ajaran_cls'] = $this->input->get('thn_ajaran_cls');       
        $this->template->load('template','pendaftaran/frm_input_pendaftaran',$data); 
    }   

    function show_konfirmasi_pembayaran () {     
        $data['kode_jenjang'] = $this->input->get('kode_jenjang'); 
        $data['thn_ajaran_cls'] = $this->input->get('thn_ajaran_cls');       
        $this->template->load('template','pendaftaran/frm_konfirmasi_pembayaran',$data); 
    }   
    
    function show_brosur_pendaftaran () {     
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');
        $this->template->load('template','pendaftaran/frm_brosur_pendaftaran',$data); 
    }   

    function show_hasil_observasi () {     
        $data['kode_jenjang'] = $this->input->get('kode_jenjang'); 
        $data['thn_ajaran_cls'] = $this->input->get('thn_ajaran_cls');       
        $this->template->load('template','pendaftaran/frm_hasil_observasi',$data); 
    }   
    
    function show_informasi_data_siswa () {           
        $this->template->load('template','pendaftaran/frm_informasi_data_siswa'); 
    }   

    function show_siswa_detail(){        
        $data['kode_jenjang'] =  $this->input->get('kode_jenjang'); 
        $data['siswa_id'] = $this->input->get('siswa_id');        
        $data['form_id'] =  'user_form';
        $this->template->load('template','pendaftaran/frm_siswa_detail', $data);            
    }

    function cek_thn_ajaran_aktif_ui(){
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->mdl_thn_ajaran->cek_thn_ajaran_aktif($kode_jenjang)->result();
            $thn_ajaran_arr = array();
                   
            foreach ($data as $d)
            {            
                $thn_ajaran_id = $d->thn_ajaran_id;
                $thn_ajaran_cls = $d->thn_ajaran_cls;
                $thn_ajaran_nama = $d->thn_ajaran_nama;
                $tgl_mulai = $d->tgl_mulai;     
                           
                $thn_ajaran_arr[] = array(  "thn_ajaran_id" => $thn_ajaran_id,
                                            "thn_ajaran_cls" => $thn_ajaran_cls,
                                            "thn_ajaran_nama" => $thn_ajaran_nama,
                                            "tgl_mulai" => $tgl_mulai);                                    
            }
            echo json_encode(array('status'=>true, 'data'=>[$thn_ajaran_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }

    function cek_thn_ajaran_aktif_home() {
        try {
            $data=$this->mdl_thn_ajaran->cek_thn_ajaran_aktif_home()->result();
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;   
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    } 

    function get_data_info_pendaftaran_ui() {
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $thn_ajaran_cls = $this->input->get('thn_ajaran_cls');            
            $data=$this->mdl_pendaftaran->get_data_info_pendaftaran($kode_jenjang, $thn_ajaran_cls)->result();
                        
            $info_pendaftaran_arr = array();
                        
            foreach ($data as $d)
            {                      
                $info_pendaftaran = $d->info_pendaftaran;                               
                $info_pendaftaran_arr[] = array("info_pendaftaran" => $info_pendaftaran);                                    
            }        
            // encoding array to json format            
            echo json_encode(array('status'=>true, 'data'=>[$info_pendaftaran_arr], 'message'=>"")) ;  
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }

    function get_thn_ajaran_and_jenjang() {
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $thn_ajaran_cls = $this->input->get('thn_ajaran_cls');            
            $data=$this->mdl_pendaftaran->get_thn_ajaran_and_jenjang($kode_jenjang, $thn_ajaran_cls)->result();
              
            $info_pendaftaran_arr = array();
            
            foreach ($data as $d)
            {                      
                $thn_ajaran_cls = $d->thn_ajaran_cls;   
                $thn_ajaran_nama = $d->thn_ajaran_nama;   
                $group_cls = $d->group_cls;           
                $deskripsi = $d->deskripsi;     
                $info_pendaftaran_arr[] = array("thn_ajaran_cls" => $thn_ajaran_cls,
                                                "thn_ajaran_nama" => $thn_ajaran_nama,
                                                "group_cls" => $group_cls,
                                                "deskripsi" => $deskripsi,                                                
                                                );                                    
            }        
            // encoding array to json format            
            echo json_encode(array('status'=>true, 'data'=>[$info_pendaftaran_arr], 'message'=>"")) ;  
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }
    
    function get_data_brosur() {
        try {     
            include 'conn.php'; 
            $kode_jenjang = $this->input->get('kode_jenjang');
            $sql = $this->mdl_pendaftaran->get_data_brosur($kode_jenjang);           
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
    
    function get_data_brosur_home() {
        try {                
            $data = $this->mdl_pendaftaran->get_data_brosur_home()->result();
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>""));
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }

    function get_data_hasil_observasi() {
        try {     
            include 'conn.php'; 
            $kode_jenjang = $this->input->get('kode_jenjang');
            // $sql = $this->mdl_pendaftaran->get_data_hasil_observasi($kode_jenjang);           
            // $data = mysqli_query($conn, $sql);
            // $rows = array();
            // while($r = mysqli_fetch_assoc($data)) {
            //     $rows[] = $r;
            // }
            $rows = $this->mdl_pendaftaran->get_data_tbl_daftar_siswa_hasil_observasi($kode_jenjang)->result();
            //print_r($data);        
            echo json_encode(array('status'=>true, 'data'=>$rows, 'message'=>""));
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'data2'=>"",'message'=>$e->errorMessage())) ;
        }   
    }

    function get_data_siswa_detail () {
        try {     
            include 'conn.php';       
            $siswa_id = $this->input->get('siswa_id');       
            $sql = $this->mdl_pendaftaran->get_data_siswa_detail($siswa_id);
            
            $sth = mysqli_query($conn, $sql);
            $rows = array();
            while($r = mysqli_fetch_assoc($sth)) {
                $rows[] = $r;
            }
           
            echo json_encode(array('status'=>true, 'data'=>[$rows], 'message'=>""));
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }
    
    function simpan_input_pendaftaran(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');                     
            $data = $this->input->post();  
            //var_dump($data);
            $query=$this->mdl_pendaftaran->simpan_input_pendaftaran($data);  
            // print_r($query) ;                             
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){                    
                    $data_id = $conn->insert_id;
                    echo json_encode(array('status'=>true,'data_id'=>$data_id, 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
                }                
            } 
            else{
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
                }            
            }
           
            mysqli_close($conn);
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    } 

    function simpan_file_path() {
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');                     
            $data = $this->input->post();  
            $query=$this->mdl_pendaftaran->simpan_file_path($data, $username);  
            // print_r($query) ;                             
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){  
                    echo json_encode(array('status'=>true,'data_id'=>'', 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
                }                
            } 
            else{
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
                }            
            }
           
            mysqli_close($conn);
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }

    function cek_data_siswa_exists () {
        try {            
            $siswa_id = $this->input->get('siswa_id');
            $nama_lengkap = $this->input->get('nama_lengkap');            
            $data=$this->mdl_pendaftaran->get_data_siswa_exists($siswa_id, $nama_lengkap)->result();
                        
            $data_siswa_arr = array();
            
            foreach ($data as $d)
            {                      
                $siswa_id = $d->siswa_id;
                $nama = $d->nama;        
                $nama_ayah = $d->nama_ayah; 
                $nama_ibu = $d->nama_ibu;   
                $data_siswa_arr[] = array("siswa_id" => $siswa_id,
                                                "nama" => $nama,
                                                "nama_ayah" => $nama_ayah,
                                                "nama_ibu" => $nama_ibu
                                                );                                    
            }        
            // encoding array to json format            
            echo json_encode(array('status'=>true, 'data'=>[$data_siswa_arr], 'message'=>"")) ;  
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }

    function cek_data_konfirmasi_double(){
        try {            
            $siswa_id = $this->input->get('siswa_id');                       
            $data=$this->mdl_pendaftaran->cek_data_konfirmasi_double($siswa_id)->result();                   
            $data_siswa_arr = array();            
            foreach ($data as $d)
            {                      
                $siswa_id = $d->siswa_id;             
                $data_siswa_arr[] = array("siswa_id" => $siswa_id);                                    
            }        
            // encoding array to json format            
            echo json_encode(array('status'=>true, 'data'=>[$data_siswa_arr], 'message'=>"")) ;  
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }


    function simpan_konfirmasi_pendaftaran(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');                     
            $data = $this->input->post();  
            //echo $data;                     
            $query=$this->mdl_pendaftaran->simpan_konfirmasi_pembayaran($data); 
                    
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){                    
                    $data_id = $conn->insert_id;
                    echo json_encode(array('status'=>true,'data_id'=>$data_id, 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
                }                
            } 
            else{
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
                }            
            }
           
            mysqli_close($conn);
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }
    
    function get_data_siswa_konfirmasi() {
        try {     
            $siswa_id = $this->input->get('siswa_id');
            $tgl_lahir = $this->input->get('tgl_lahir');
            $data = $this->mdl_pendaftaran->get_data_siswa_konfirmasi($siswa_id, $tgl_lahir)->result();           
            
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>""));
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }

    
    function simpan_hasil_cek_dokumen(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');      
            $siswa_id = $this->input->post('siswa_id');
            $cek_dokumen_temp = $this->input->post('cek_dokumen_temp');
                      
            $query="update  master_siswa_baru
                    set     status_cek_dokumen ='$cek_dokumen_temp' 
                    where   siswa_id = '$siswa_id' ";
                               
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){                    
                    echo json_encode(array('status'=>true,'data_id'=>"", 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
                }                
            } 
            else{
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
                }            
            }
           
            mysqli_close($conn);
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }

}