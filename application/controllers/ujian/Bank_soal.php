<?php
class Bank_soal extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('ujian/Mdl_bank_soal');
    }

    function show_bank_soal(){
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();  
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }            

            if(isset($_GET['thnajaran'])){
                $thnajaran = $this->input->get('thnajaran');            
                $semester = $this->input->get('semester');
                $kelas = $this->input->get('kelas');
                $mapel = $this->input->get('mapel');
                $jenis_penilaian = $this->input->get('jenis_penilaian');
                $jenjang = $this->input->get('jenjang');
            }else{
                $thnajaran = "";            
                $semester = "";
                $kelas = "";
                $mapel = "";
                $jenis_penilaian = "";
                $jenjang ="";
            }
            
            $data['username'] = $username; 
            $data['status_user'] = $status_user;
            $data['thnajaran'] = $thnajaran;
            $data['semester'] = $semester;
            $data['kelas'] = $kelas;
            $data['mapel'] = $mapel;
            $data['jenis_penilaian'] = $jenis_penilaian;
            $data['jenjang'] = $jenjang;
            $this->template->load('template_ujian','ujian/frm_bank_soal', $data); 
            
        }else{
            redirect('auth/login_ujian'); 	
        }
    }

    function get_mapel() {
        $result = $this->Mdl_bank_soal->get_mapel()->result();
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")) ;          
    }

    function get_jenjang_pendidikan() {      
        $kelas = $this->input->get('kelas') ;  
        $data = $this->Mdl_bank_soal->get_jenjang_pendidikan($kelas)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;          
    }

    function get_kelas(){        
        $jenjang=$this->input->get('jenjang'); 
        $data = $this->Mdl_bank_soal->get_kelas($jenjang)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;        
    }

    function get_subkelas() {
        $kelas=$this->input->get('kelas'); 
        $data = $this->Mdl_bank_soal->get_subkelas($kelas)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;   
    }

    function get_thn_ajaran() {
        $data = $this->Mdl_bank_soal->get_thn_ajaran()->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_tbl_guru() {
        $req = $this->input->get();       
        $data = $this->Mdl_bank_soal->get_tbl_guru($req)->result();     
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_data_exists() {
        $data = $this->input->get();      
        $result = $this->Mdl_bank_soal->get_data_exists($data)->result();
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>''));
    }

    function simpan_bank_soal(){
        try {                            
            include 'conn.php';
            $username = $_COOKIE['cms-swi-ujian'];                             
            $data = $this->input->post(); 
            
            if(isset($_POST['list_kd'])){
                $ir_kd = count($data['list_kd']);
                if($ir_kd>0){
                    $query_kd_del = $this->Mdl_bank_soal->hapus_kd_soal($data);
                    mysqli_query($conn, $query_kd_del);
                    
                    for ($r=0; $r < $ir_kd; $r++) { 
                        $no_kd = $data['list_kd'][$r];                    
                        $query_kd = $this->Mdl_bank_soal->simpan_kd_soal($data, $username, $no_kd);
                        mysqli_query($conn, $query_kd);
                    }
                }
            }            

            $ir_guru = count($data['txt_nama']);  
            if($ir_guru>0){
                for ($i=0; $i < $ir_guru ; $i++) { 
                    $subkelas_cls =  $data['txt_subkelas'][$i];
                    $nama_guru = $data['txt_nama'][$i];                    
                    $cek_nama_guru = $this->Mdl_bank_soal->cek_nama_guru($data, $subkelas_cls, $nama_guru)->result();
                    $rows_guru = count($cek_nama_guru);                    
                    $query_guru = $this->Mdl_bank_soal->simpan_guru_kelas($data, $username, $subkelas_cls, $nama_guru, $rows_guru);
                    if($query_guru!=''){
                        mysqli_query($conn, $query_guru);
                    }                    
                }
            }

            $query=$this->Mdl_bank_soal->simpan_bank_soal($data, $username);  
                                      
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
           
        } catch (Exception $e) {
            $err_pesan = $e->getMessage();
            $pesan = strpos($err_pesan, "Duplicate");
            if($pesan!==false){
                echo json_encode(array('status'=>false, 'data'=>"", 'message'=>'Data sudah ada')); 
            }else{
                echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->getMessage()));
            }
            
        }
    }

    function delete_bank_soal() {
        try {                            
            include 'conn.php';                                
            $data = $this->input->post(); 
            $rs_b4_del = $this->Mdl_bank_soal->cek_soal_b4_delete($data)->result();
            $jml_rows = count($rs_b4_del);
            if($jml_rows>0){
                echo json_encode(array('status'=>false,'data'=>'', 'message'=>'Bank Soal tidak bisa dihapus karena sudah dibuatkan soal'));
                die;
            }
            
            $query=$this->Mdl_bank_soal->delete_bank_soal($data, $username);   
            
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
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                                            
            }           
            
            mysqli_close($conn);
           
        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->getMessage()));
        }
    }

    function get_tbl_bank_soal(){
        $thnajaran= $this->input->get('thnajaran');
        $jenjang= $this->input->get('jenjang');
        $semester= $this->input->get('semester');
        $kelas= $this->input->get('kelas');
        $jenis_penilaian= $this->input->get('jenis_penilaian');
        $result = $this->Mdl_bank_soal->get_tbl_bank_soal($thnajaran, $jenjang, $semester, $kelas, $jenis_penilaian)->result();
        echo json_encode(array("status"=>true,"data"=>$result,"message"=>""));
    } 

    function get_data_bank_soal() {
        $bank_soal_id = $this->input->get('bank_soal_id');
        $rs = $this->Mdl_bank_soal->get_data_bank_soal($bank_soal_id)->result();
        echo json_encode(array("status"=>true,"data"=>$rs,"message"=>""));
    }

    function get_data_kd_exists(){
        $data = $this->input->get();
        $rs = $this->Mdl_bank_soal->get_data_kd_exists($data)->result();
        echo json_encode(array("status"=>true,"data"=>$rs,"message"=>""));        
    }

    function get_tbl_search_mapel() {
        $cari_mapel = $this->input->get('cari_mapel'); 
        $rs = $this->Mdl_bank_soal->get_tbl_search_mapel($cari_mapel)->result();
        echo json_encode(array("status"=>true,"data"=>$rs,"message"=>""));   
    }
    
}

?>