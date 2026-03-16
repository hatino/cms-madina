<?php

class Master extends ci_controller{
    function __construct() {
        parent::__construct();
        $this->load->model('ujian/Mdl_master');
    }

    function show_waktu_mengerjakan(){
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();  
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }            
                        
            $data['username'] = $username; 
            $data['status_user'] = $status_user;    
            $this->template->load('template_ujian','ujian/frm_waktu_mengerjakan', $data); 
            
        }else{
            redirect('auth/login_ujian'); 	
        }
    }

    function show_mapel_waktu_mengerjakan(){
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();  
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }            
                        
            $data['username'] = $username; 
            $data['status_user'] = $status_user;    
            $this->template->load('template_ujian','ujian/frm_waktu_mengerjakan_permapel', $data); 
            
        }else{
            redirect('auth/login_ujian'); 	
        }
    }

    function show_bobot_nilai(){
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();  
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }            
                        
            $data['username'] = $username; 
            $data['status_user'] = $status_user;    
            $this->template->load('template_ujian','ujian/frm_bobot_nilai', $data); 
            
        }else{
            redirect('auth/login_ujian'); 	
        }        
    }

    function show_bobot_nilai_ekskul(){
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();  
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }            
                        
            $data['username'] = $username; 
            $data['status_user'] = $status_user;    
            $this->template->load('template_ujian','ujian/frm_bobot_nilai_ekskul', $data); 
            
        }else{
            redirect('auth/login_ujian'); 	
        }
        
    }

    function show_mapel_pg(){
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();  
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }            
                        
            $data['username'] = $username; 
            $data['status_user'] = $status_user;    
            $this->template->load('template_ujian','ujian/frm_mapel_pg', $data); 
            
        }else{
            redirect('auth/login_ujian'); 	
        }
        
    }
    
    function get_bobot_nilai() {       
        $req = $this->input->get();    
        $rs_mapel_pg = $this->Mdl_master->get_mapel_pg($req)->result();
        $rows_mapel_pg = count($rs_mapel_pg);       
        if($rows_mapel_pg>0){
            $data = $this->Mdl_master->get_mapel_pg($req)->result();
        }else{
            if($req['status_ekskul']=='1'){
                $data = $this->Mdl_master->get_tbl_bobot_nilai_ekskul($req)->result();
            }else{
                $data = $this->Mdl_master->get_tbl_bobot_nilai($req)->result();
            }
            
        }
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_status_mapel_pg(){
        $req = $this->input->get();                
        $rs_mapel_pg = $this->Mdl_master->get_mapel_pg($req)->result();
        $rows = count($rs_mapel_pg);
        echo json_encode(array('status'=>true, 'data'=>$rows, 'message'=>''));
    }

    function get_tbl_bobot_nilai() {
        $req = $this->input->get();       
        $data = $this->Mdl_master->get_tbl_bobot_nilai($req)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_tbl_bobot_nilai_ekskul() {
        $req = $this->input->get();       
        $data = $this->Mdl_master->get_tbl_bobot_nilai_ekskul($req)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_tbl_mapel_pg() {      
        $data = $this->Mdl_master->get_tbl_mapel_pg()->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    } 

    function get_data_waktu_pengerjaan() {        
        $data = $this->Mdl_master->cek_data_exists()->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    } 
    
    function get_data_waktu_pengerjaan_with_mapel() {
        $params = $this->input->get();     
        $data = $this->Mdl_master->get_data_waktu_pengerjaan_with_mapel($params)->result();        
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_tbl_waktu_permapel() {      
        $data = $this->Mdl_master->get_tbl_waktu_permapel()->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    } 

    function simpan_waktu_mengerjakan() {
        try {       
            $username = $_COOKIE['cms-swi-ujian']; 
            $data = $this->input->post();
            $cek_data_exists = $this->Mdl_master->cek_data_exists($data)->result();           
            $query = $this->Mdl_master->simpan_waktu_mengerjakan($data, count($cek_data_exists), $username);
           
            include 'conn.php';
            if(mysqli_query($conn, $query)){
                $rows = mysqli_affected_rows($conn);
                if($rows > 0){
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
                }
            }else{
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
                }         
            }            

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

    function simpan_waktu_permapel() {
        try {       
            $username = $_COOKIE['cms-swi-ujian']; 
            $data = $this->input->post();                     
            $query = $this->Mdl_master->simpan_waktu_permapel($data, $username);
           
            include 'conn.php';
            if(mysqli_query($conn, $query)){
                $rows = mysqli_affected_rows($conn);
                if($rows > 0){
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
                }
            }else{
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
                }         
            }            

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

    function simpan_bobot_nilai() {
        try {
            $username = $_COOKIE['cms-swi-ujian']; 
            $data = $this->input->post();           
            $cek_data_exists = $this->Mdl_master->get_tbl_bobot_nilai($data)->result();           
            $query = $this->Mdl_master->simpan_bobot_nilai($data, count($cek_data_exists), $username);

            include 'conn.php';
            if(mysqli_query($conn, $query)){
                $rows = mysqli_affected_rows($conn);
                if($rows > 0){
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
                }
            }else{
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
                }         
            }            
            
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

    function simpan_bobot_nilai_ekskul() {
        try {
            $username = $_COOKIE['cms-swi-ujian']; 
            $data = $this->input->post();           
            $cek_data_exists = $this->Mdl_master->get_tbl_bobot_nilai_ekskul($data)->result();           
            $query = $this->Mdl_master->simpan_bobot_nilai_ekskul($data, count($cek_data_exists), $username);

            include 'conn.php';
            if(mysqli_query($conn, $query)){
                $rows = mysqli_affected_rows($conn);
                if($rows > 0){
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
                }
            }else{
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
                }         
            }            
            
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

    function simpan_mapel_pg(){
        try {
            $username = $_COOKIE['cms-swi-ujian']; 
            $data = $this->input->post();    
            $query = $this->Mdl_master->simpan_mapel_pg($data, $username);

            include 'conn.php';
            if(mysqli_query($conn, $query)){
                $rows = mysqli_affected_rows($conn);
                if($rows > 0){
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
                }
            }else{
                $err_code = mysqli_errno($conn);
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
                }         
            }            
            
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

    function delete_mapel_pg() {
        $data = $this->input->post();
    
        $query = "delete from mapel_pg where seq_no = '".$data['seqno']."' ";
        include 'conn.php';
        if(mysqli_query($conn, $query)){
            $rows = mysqli_affected_rows($conn);
            if($rows > 0){
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data sukses'));
            }else{
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
            }
        }else{
            $err_code = mysqli_errno($conn);
            if($err_code==1062){
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
            }else{
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
            }         
        }                    
    }
    
    function delete_waktu_permapel() {
        $data = $this->input->post();
    
        $query = "delete from waktu_pengerjaan_permapel where seq_no = '".$data['seqno']."' ";
        include 'conn.php';
        if(mysqli_query($conn, $query)){
            $rows = mysqli_affected_rows($conn);
            if($rows > 0){
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data sukses'));
            }else{
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
            }
        }else{
            $err_code = mysqli_errno($conn);
            if($err_code==1062){
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
            }else{
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
            }         
        }                    
    }

    function cek_mapel_pg_exists_insert() {
        $req = $this->input->get();
        $data = $this->Mdl_master->cek_mapel_pg_exists_insert($req)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));        
    }
    
    function get_thnajaran() {
        $thnajaran = $this->input->get('thnajaran');
        $rs = $this->Mdl_master->get_thnajaran($thnajaran)->result();
        echo json_encode(array('status'=>true, 'data'=>$rs, 'message'=>""));
    }

    function get_nama_siswa() {
        $nis = $this->input->get('nis');
        $rs = $this->Mdl_master->get_nama_siswa($nis)->result();
        echo json_encode(array('status'=>true, 'data'=>$rs, 'message'=>""));
    }
    
}

?>