<?php
class Jadwal_ujian extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('ujian/Mdl_jadwal_ujian');            
    }

    function show_jadwal_ujian(){
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();  
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }                       

            $mapel = $this->input->get('mapel');
            $thnajaran = $this->input->get('thnajaran');
            $kelas = $this->input->get('kelas');
            $semester = $this->input->get('semester');
            $jenis_penilaian = $this->input->get('jenis_penilaian');
            $bank_soal_id = $this->input->get('bank_soal_id');

            $data['username'] = $username; 
            $data['status_user'] = $status_user;
            $data['thnajaran'] = $thnajaran;
            $data['mapel'] = $mapel;
            $data['kelas'] = $kelas;
            $data['semester'] = $semester;
            $data['jenis_penilaian'] = $jenis_penilaian;
            $data['bank_soal_id'] = $bank_soal_id;

            $this->template->load('template_ujian','ujian/frm_jadwal_ujian', $data); 
        }else{
            redirect('auth/login_ujian'); 	
        }
    }

    function get_tbl_jadwal_ujian() {        
        $thnajaran= $this->input->get('thnajaran');
        $jenjang= $this->input->get('jenjang');
        $semester= $this->input->get('semester');
        $kelas= $this->input->get('kelas');
        $jenis_penilaian= $this->input->get('jenis_penilaian');
        $result = $this->Mdl_jadwal_ujian->get_tbl_jadwal_ujian($thnajaran, $jenjang, $semester, $kelas, $jenis_penilaian)->result();
        echo json_encode(array("status"=>true,"data"=>$result,"message"=>""));    
    }

    function get_waktu_mengerjakan() {
        $bank_soal_id = $this->input->get('bank_soal_id');       
        $data = $this->Mdl_jadwal_ujian->get_waktu_mengerjakan($bank_soal_id)->result();        
        if(count($data) > 0){
            foreach ($data as $val) {               
                echo $val->waktu_mengerjakan;               
            }
        }else{
            echo 0;
        }
    }

    function get_data_jadwal_dashboard() {
        $user_id = $this->input->get('user_id');
        $data = $this->Mdl_jadwal_ujian->get_data_jadwal_dashboard($user_id)->result();
        echo json_encode(array("status"=>true,"data"=>$data,"message"=>""));
    }

    function simpan_jadwal_ujian(){
        try {                            
            include 'conn.php';
            $username = $_COOKIE['cms-swi-ujian'];                             
            $data = $this->input->post();            
            $query=$this->Mdl_jadwal_ujian->simpan_jadwal_ujian($data, $username);   
                                                  
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
    
    function delete_jadwal_ujian() {
        try {                            
            include 'conn.php';                                
            $data = $this->input->post(); 
            $query=$this->Mdl_jadwal_ujian->delete_jadwal_ujian($data, $username);   
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){ 
                    echo json_encode(array('status'=>true,'data_id'=>'', 'message'=>'Hapus data sukses'));
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

}

?>