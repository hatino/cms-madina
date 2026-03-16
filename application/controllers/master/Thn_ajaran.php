<?php
class Thn_ajaran extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('master/mdl_thn_ajaran');       
        //check_session();
    }

    function show_thn_ajaran(){        
        $this->template->load('template_admin','master/frm_thn_ajaran');            
    }

    function get_data_list_jenjang(){        
        try {            
            $data=$this->mdl_thn_ajaran->get_data_list_jenjang()->result();
            $jenjang_arr = array();
                    
            foreach ($data as $d)
            {                      
                $group_cls = $d->group_cls;
                $deskripsi = $d->deskripsi;                
                $jenjang_arr[] = array("group_cls" => $group_cls,
                                       "deskripsi" => $deskripsi);                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$jenjang_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }

    function get_data_tbl_thn_ajaran(){
        try {            
            $data=$this->mdl_thn_ajaran->get_data_thn_ajaran()->result();
            $thn_ajaran_arr = array();
                    
            foreach ($data as $d)
            {                      
                $thn_ajaran_cls = $d->thn_ajaran_cls;
                $thn_ajaran_nama = $d->thn_ajaran_nama;                
                $thn_ajaran_arr[] = array("thn_ajaran_cls" => $thn_ajaran_cls,
                                       "thn_ajaran_nama" => $thn_ajaran_nama);                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$thn_ajaran_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }

    function cek_thn_ajaran_aktif(){
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->mdl_thn_ajaran->cek_thn_ajaran_aktif($kode_jenjang)->result();
            $thn_ajaran_arr = array();
            echo $data;          
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

    function get_thn_ajaran_exists(){
        try {            
            $thn_ajaran_cls = $this->input->get('thn_ajaran_cls');
            $data=$this->mdl_thn_ajaran->get_thn_ajaran_exists($thn_ajaran_cls)->result();
            $thn_ajaran_arr = array();
                    
            foreach ($data as $d)
            {                      
                $thn_ajaran_cls = $d->thn_ajaran_cls;
                $thn_ajaran_nama = $d->thn_ajaran_nama;                
                $thn_ajaran_arr[] = array("thn_ajaran_cls" => $thn_ajaran_cls,
                                       "thn_ajaran_nama" => $thn_ajaran_nama);                                    
            }        
            // encoding array to json format
            echo json_encode($thn_ajaran_arr) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }    

    function get_data_tbl_setting_thn_ajaran(){
        try {            
            $kode_jenjang = $this->input->get('jenjang');
            $data=$this->mdl_thn_ajaran->get_data_tbl_setting_thn_ajaran($kode_jenjang)->result();
            $thn_ajaran_setting_arr = array();
                        
            foreach ($data as $d)
            {                      
                $thn_ajaran_cls = $d->thn_ajaran_cls;
                $thn_ajaran_nama = $d->thn_ajaran_nama;     
                $status_open = $d->status_open;  
                $tgl_mulai_pendaftaran = $d->tgl_mulai_pendaftaran;  
                $tgl_selesai_pendaftaran = $d->tgl_selesai_pendaftaran;  
                $status_close = $d->status_close;  
                $tgl_close_pendaftaran = $d->tgl_close_pendaftaran;  
                $thn_ajaran_setting_arr[] = array("thn_ajaran_cls" => $thn_ajaran_cls,
                                                  "thn_ajaran_nama" => $thn_ajaran_nama,
                                                  "status_open" => $status_open,
                                                  "tgl_mulai_pendaftaran" => $tgl_mulai_pendaftaran,
                                                  "tgl_selesai_pendaftaran" => $tgl_selesai_pendaftaran,
                                                  "status_close" => $status_close,
                                                  "tgl_close_pendaftaran" => $tgl_close_pendaftaran,
                                                );                                    
            }        
            // encoding array to json format            
            echo json_encode(array('status'=>true, 'data'=>[$thn_ajaran_setting_arr], 'message'=>"")) ;  
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }

    function simpan_mst_thn_ajran(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');                     
            $status_edit = $this->input->post('status_edit');
            $thn_ajaran_cls = $this->input->post('thn_ajaran_cls');
            $thn_ajaran_nama = $this->input->post('thn_ajaran_nama');
           
            $query=$this->mdl_thn_ajaran->simpan_mst_thn_ajran($status_edit, $thn_ajaran_cls, $thn_ajaran_nama, $username);
                    
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){                    
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
                }                
            } 
            else 
            {
                $err_code = mysqli_errno($conn);
                if($err_code==1062)
                {
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }
                else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));
                    //echo("Error description: " . mysqli_error($conn));            	
                }            
            }
           
            mysqli_close($conn);
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }


    function delete_mst_thn_ajran(){
        try {                            
            include 'conn.php';           
            $thn_ajaran_cls = $this->input->post('thn_ajaran_cls');                       
            $query = $this->mdl_thn_ajaran->delete_mst_thn_ajran($thn_ajaran_cls);
                                          
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){                  
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data tidak berhasil'));
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


    function simpan_setting_thn_ajaran(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');                     
            $jenjang = $this->input->post('list_jenjang');

            // echo(count($_POST["txt_thn_ajaran_cls"]));
           
            $status_affected = 'false';           
            for($count = 0; $count < count($_POST["txt_thn_ajaran_cls"]); $count++){
                $thn_ajaran = $_POST["txt_thn_ajaran_cls"][$count];
                $chk_open = $_POST["chk_open_temp"][$count];
                $dt_mulai = $_POST["dt_mulai"][$count];
                $dt_selesai = $_POST["dt_selesai"][$count];
                $chk_close = $_POST["chk_close_temp"][$count];
                $dt_close = $_POST["dt_close"][$count];
               
                $query=$this->mdl_thn_ajaran->simpan_setting_thn_ajran(
                                                                  $jenjang
                                                                , $thn_ajaran
                                                                , $chk_open
                                                                , $dt_mulai
                                                                , $dt_selesai
                                                                , $chk_close
                                                                , $dt_close
                                                                , $username);
                    
                if (mysqli_query($conn, $query)) {
                    $rows = mysqli_affected_rows($conn);                
                    if($rows>0){                    
                        $status_affected = 'true';                        
                    }      
                } 
                else 
                {
                    $err_code = mysqli_errno($conn);
                    if($err_code==1062)
                    {
                        echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                    }
                    else{
                        echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));
                        //echo("Error description: " . mysqli_error($conn));            	
                    }            
                }

               
            }          
            
            mysqli_close($conn);
            if ($status_affected='true'){
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
            }            
            
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }


}

?>