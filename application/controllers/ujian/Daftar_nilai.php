<?php
class Daftar_nilai extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('ujian/Mdl_daftar_nilai');
        // check_session_ujian();
    }

    function show_daftar_nilai() {
       if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();         
            foreach($rs as $d){
                $status_user = $d->status;
            }            

            if(isset($_GET['thnajaran'])){
                $thnajaran = $this->input->get('thnajaran');            
                $semester = $this->input->get('semester');
                $kelas = $this->input->get('kelas');
                $subkelas = $this->input->get('subkelas');
                $mapel = $this->input->get('mapel');
                $jenis_penilaian = $this->input->get('jenis_penilaian');
            }else{
                $thnajaran = "";            
                $semester = "";
                $kelas = "";
                $subkelas ="";
                $mapel = "";
                $jenis_penilaian = "";
            }
            
            $data['username'] = $username; 
            $data['status_user'] = $status_user;
            $data['thnajaran'] = $thnajaran;
            $data['semester'] = $semester;
            $data['kelas'] = $kelas;
            $data['subkelas'] = $subkelas;
            $data['mapel'] = $mapel;
            $data['jenis_penilaian'] = $jenis_penilaian;
            $this->template->load('template_ujian','ujian/frm_daftar_nilai', $data); 
       }else{
            redirect('auth/login_ujian'); 
       }        
    }

    function show_hasil_ujian() {
       if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();         
            foreach($rs as $d){
                $status_user = $d->status;
            }            

            if(isset($_GET['thnajaran'])){
                $thnajaran = $this->input->get('thnajaran');            
                $semester = $this->input->get('semester');
                $kelas = $this->input->get('kelas');
                $subkelas = $this->input->get('subkelas');
                $mapel = $this->input->get('mapel');
                $jenis_penilaian = $this->input->get('jenis_penilaian');
            }else{
                $thnajaran = "";            
                $semester = "";
                $kelas = "";
                $subkelas ="";
                $mapel = "";
                $jenis_penilaian = "";
            }
            
            $data['username'] = $username; 
            $data['status_user'] = $status_user;
            $data['thnajaran'] = $thnajaran;
            $data['semester'] = $semester;
            $data['kelas'] = $kelas;
            $data['subkelas'] = $subkelas;
            $data['mapel'] = $mapel;
            $data['jenis_penilaian'] = $jenis_penilaian;
            $this->template->load('template_ujian','ujian/frm_tarik_hasil_ujian_json', $data); 
       }else{
            redirect('auth/login_ujian'); 
       }        
    }

    function show_koreksi_jawab_uraian() {
       if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();         
            foreach($rs as $d){
                $status_user = $d->status;
            }            

            if(isset($_GET['nis'])){
                $nis = $this->input->get('nis');            
                $bank_soal_id = $this->input->get('bank_soal_id');                
            }else{
                $nis = "";            
                $bank_soal_id = "";                
            }
            
            $data['username'] = $username; 
            $data['status_user'] = $status_user;
            $data['nis'] = $nis;
            $data['bank_soal_id'] = $bank_soal_id;            
            $this->template->load('template_ujian','ujian/frm_koreksi_jawab_uraian', $data); 
       }else{
            redirect('auth/login_ujian'); 
       }
        
    }

    function show_daftar_nilai_siswa() {
       if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();         
            foreach($rs as $d){
                $status_user = $d->status;
            }            

            if(isset($_GET['thnajaran'])){
                $thnajaran = $this->input->get('thnajaran');            
                $semester = $this->input->get('semester');               
                $jenis_penilaian = $this->input->get('jenis_penilaian');
            }else{
                $thnajaran = "";            
                $semester = "";                
                $jenis_penilaian = "";
            }
            
            $data['username'] = $username; 
            $data['status_user'] = $status_user;
            $data['thnajaran'] = $thnajaran;
            $data['semester'] = $semester;           
            $data['jenis_penilaian'] = $jenis_penilaian;
            $this->template->load('template_ujian','ujian/frm_daftar_nilai_siswa', $data); 
       }else{
            redirect('auth/login_ujian'); 
       }
        
    }

    function show_daftar_nilai_detail() {
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();         
            foreach($rs as $d){
                $status_user = $d->status;
            }            

            if(isset($_GET['nis'])){
                $nis = $this->input->get('nis');            
                $bank_soal_id = $this->input->get('bank_soal_id');                
            }else{
                $nis = "";            
                $bank_soal_id = "";                
            }
            
            $data['username'] = $username; 
            $data['status_user'] = $status_user;
            $data['nis'] = $nis;
            $data['bank_soal_id'] = $bank_soal_id;            
            $this->template->load('template_ujian','ujian/frm_daftar_nilai_detail', $data); 
       }else{
            redirect('auth/login_ujian'); 
       }
    }

    function get_tbl_daftar_nilai() {    
        $data_req = $this->input->get();        
        $rs_nilai = $this->Mdl_daftar_nilai->get_tbl_daftar_nilai($data_req)->result();
        echo json_encode(array('status'=>true, 'data'=>$rs_nilai, 'message'=>"")) ;
    }

    
    function get_tbl_daftar_nilai_json() {         
        $kelas = $this->input->get('kelas');
        $mapel = $this->input->get('mapel');
        $thnajaran= $this->input->get('thnajaran');
        $jenis_penilaian = $this->input->get('jenis_penilaian');
        $semester = $this->input->get('semester');
        $jenjang = $this->input->get('jenjang');
        $subkelas = $this->input->get('subkelas');

        $folder_jawab = APPPATH . "cache/jawab/".$thnajaran."/".$jenis_penilaian."/".$semester."/".$kelas."/";

        //$folderAwal = 'data_jawaban/';
        $mapelDicari = $mapel;       
        $hasil = $this->cariFileMapel($folder_jawab, $mapelDicari);

        // if (empty($hasil)) {
        //     echo "Tidak ditemukan file dengan mapel '$mapelDicari'.";
        // } else {
        //     //echo "Ditemukan file dengan mapel '$mapelDicari':<br>";
        //     echo implode('<br>', $hasil);
        //     var_dump($hasil);
        // }

        $params = [
            'thnajaran'=>$thnajaran,
            'jenjang'=>'',
            'kelas'=>$kelas,
            'subkelas'=>$subkelas,
            'semester'=>$semester,
            'jenis_penilaian'=>$jenis_penilaian,
            'mapel'=>$mapel
        ];       

        $rs_baru = [];
        $rs = $this->Mdl_daftar_nilai->get_tbl_daftar_nilai($params)->result();        
        foreach ($rs as $db) {
            $nis = $db->nis;
            $nama_file = null;           
            foreach ($hasil as $file) {  
                $bagian = explode('_', $file);               
                $nis_file = trim($bagian[1]); // bagian ketiga
                if ($nis_file == $nis ) {                          
                    $nama_file = $file;                       
                    break;
                }                                        
            }

            $db->nama_file = isset($nama_file) ? $nama_file : null; // tambahkan jawaban siswa ke soal
            $rs_baru[] = $db; 
        }

        //var_dump($rs_baru);
        echo json_encode(array('status'=>true, 'data'=>$rs_baru, 'message'=>"")) ;

    }

    function cariFileMapel($dir, $mapelDicari) {       
        $hasil = [];
        $files = scandir($dir);
        
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;

            $path = $dir . DIRECTORY_SEPARATOR . $file;

            if (is_dir($path)) {
                // Rekursif ke subfolder
                $hasil = array_merge($hasil, cariFileMapel($path, $mapelDicari));
            } else {
                // Ambil nama tanpa ekstensi
                $namaFile = pathinfo($file, PATHINFO_FILENAME);

                // Pecah berdasarkan underscore "_"
                $bagian = explode('_', $namaFile);
                              
                // Pastikan formatnya sesuai (minimal 4 bagian)
                // contoh: ['jawab','252607001','IPA','essai']
                if (count($bagian) >= 4) {
                    $mapel = trim($bagian[2]); // bagian ketiga                   
                    //echo $mapel."_";
                    if (strcasecmp($mapel, $mapelDicari) == 0) {                        
                        $hasil[] = $namaFile;
                    }
                }
            }
        }

        return $hasil;
    }


    function get_data_tbl_hasil_ujian() {
        $req = $this->input->get();
        $rs = $this->Mdl_daftar_nilai->get_data_tbl_hasil_ujian($req)->result(); 
        echo json_encode(array('status'=>true, 'data'=>$rs, 'message'=>"")) ;
    }

    function get_data_soal() {
        $data = $this->input->get();           
        $result = $this->Mdl_daftar_nilai->get_data_soal($data)->result();       
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")); 
    }

    function get_data_soal_uraian() {
        $data = $this->input->get();           
        $result = $this->Mdl_daftar_nilai->get_data_soal_uraian($data)->result();       
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")); 
    }

    function get_nilai_siswa() {
        $data = $this->input->get();           
        $result = $this->Mdl_daftar_nilai->get_nilai_siswa($data)->result();       
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")); 
    }

    function get_data_nilai_dashboard() {
        $user_id = $this->input->get('user_id');
        $result = $this->Mdl_daftar_nilai->get_data_nilai_dashboard($user_id)->result();       
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")); 
    }

    function get_tbl_daftar_nilai_siswa() {
        $data = $this->input->get();
        $result = $this->Mdl_daftar_nilai->get_tbl_daftar_nilai_siswa($data)->result(); 
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")); 
    }
    
    function proses_hasil_ujian_json() {
        try {
            $req = $this->input->post();        
            $thnajaran = $req['list_thnajaran'];
            $kelas = $req['list_kelas'];
            $semester = $req['list_semester'];
            $jenis_penilaian = $req['list_jenis_penilaian'];
            $mapel = $req['list_mapel'];
            $status_arr = $req['status'];
            $nis_arr = $req['nis'];
            $bank_soal_id = 0;
        
            if(count($status_arr)>0){
                for ($i=0; $i < count($status_arr) ; $i++) { 
                    if($status_arr[$i]=="1"){
                        $nis = $nis_arr[$i];
                        
                        $folder_jawab = APPPATH . "cache/jawab/".$thnajaran."/".$jenis_penilaian."/".$semester."/".$kelas."/";                    
                        $file_jawab_pg = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_pg.json";   
                        $file_jawab_essai = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_essai.json";
                        
                        //import data jawab_soal_pg dari json ke db
                        if (file_exists($file_jawab_pg)) {
                            $json_str_pg = file_get_contents($file_jawab_pg);
                            $rs_pg = json_decode($json_str_pg, true);   

                            foreach ($rs_pg as $p) {                                             
                                $bank_soal_id = $p['bank_soal_id'];
                                $query = $this->db->query("CALL sp_simpan_jawab_soal_pg(?, ?, ?, ?, ?, ?, ?, ?)", 
                                [$p['bank_soal_id'], $p['soal_id'], $nis, $p['jawaban'], $p['kunci_jawaban'], $p['jml_soal'], $p['bobot_nilai'], $p['nilai']]);
                                
                                // $result = $query->row(); --> jangan pake ini karena hasilnya menjadi 1 record aja yang diambil
                                
                                // Bebaskan hasil query
                                $query->free_result();

                                while (mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)) {
                                    $res = mysqli_store_result($this->db->conn_id);
                                    if ($res instanceof mysqli_result) mysqli_free_result($res);
                                }
                            } 
                        }

                        //import data jawab_soal_essai dari json ke db
                        if (file_exists($file_jawab_essai)) {
                            $json_str_essai = file_get_contents($file_jawab_essai);
                            $rs_essai = json_decode($json_str_essai, true);   

                            foreach ($rs_essai as $e) {                                                    
                                $bank_soal_id = $p['bank_soal_id'];
                                $query = $this->db->query("CALL sp_simpan_jawab_soal_essai(?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                [$e['bank_soal_id'], $e['soal_id'], $nis, $e['jawaban'], $e['kata_kunci_1'], $e['kata_kunci_2'], $e['jml_soal'], $e['bobot_nilai'], $e['nilai']]);
                                
                                // $result = $query->row(); --> jangan pake ini karena hasilnya menjadi 1 record aja yang diambil
                                
                                // Bebaskan hasil query
                                $query->free_result();

                                while (mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)) {
                                    $res = mysqli_store_result($this->db->conn_id);
                                    if ($res instanceof mysqli_result) mysqli_free_result($res);
                                }
                            } 
                        }

                        //echo "nis:".$nis.", bank_soal_id:".$bank_soal_id.";";   
                        //proses hitung nilai siswa
                        $query = $this->db->query("CALL sp_simpan_nilai_ujian(?, ?)",
                        [$bank_soal_id, $nis]);
                                
                        // Bebaskan hasil query
                        $query->free_result();

                        while (mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)) {
                            $res = mysqli_store_result($this->db->conn_id);
                            if ($res instanceof mysqli_result) mysqli_free_result($res);
                        }

                    }
                }
            }

            echo json_encode(array('status'=>true, 'data'=>"", 'message'=>'Proses Selesai'));

        } catch (Exception $e) {
            $err_pesan = $e->getMessage();
            $pesan = strpos($err_pesan,"Duplicate");
            if($pesan!=false){
                echo json_encode(array('status'=>false, 'data'=>"", 'message'=>'Data sudah ada'));
            }else{
                echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->getMessage()));
            }
        }
    }

    function proses_hasil_ujian_json_per_nis() {
        try {
            $json_data = file_get_contents('php://input');
            $req = json_decode($json_data, true);        
                      
            $thnajaran = $req['thnajaran'];
            $kelas = $req['kelas'];
            $semester = $req['semester'];
            $jenis_penilaian = $req['jenis_penilaian'];
            $mapel = $req['mapel'];         
            $nis = $req['nis'];
            $bank_soal_id = 0;
                        
            $folder_jawab = APPPATH . "cache/jawab/".$thnajaran."/".$jenis_penilaian."/".$semester."/".$kelas."/";                    
            $file_jawab_pg = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_pg.json";   
            $file_jawab_essai = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_essai.json";
                        
            //import data jawab_soal_pg dari json ke db
            if (file_exists($file_jawab_pg)) {
                $json_str_pg = file_get_contents($file_jawab_pg);
                $rs_pg = json_decode($json_str_pg, true);   

                foreach ($rs_pg as $p) {                                             
                    $bank_soal_id = $p['bank_soal_id'];
                    $query = $this->db->query("CALL sp_simpan_jawab_soal_pg(?, ?, ?, ?, ?, ?, ?, ?)", 
                    [$p['bank_soal_id'], $p['soal_id'], $nis, $p['jawaban'], $p['kunci_jawaban'], $p['jml_soal'], $p['bobot_nilai'], $p['nilai']]);
                    
                    // $result = $query->row(); --> jangan pake ini karena hasilnya menjadi 1 record aja yang diambil
                    
                    // Bebaskan hasil query
                    $query->free_result();

                    while (mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)) {
                        $res = mysqli_store_result($this->db->conn_id);
                        if ($res instanceof mysqli_result) mysqli_free_result($res);
                    }
                } 
            }

            //import data jawab_soal_essai dari json ke db
            if (file_exists($file_jawab_essai)) {
                $json_str_essai = file_get_contents($file_jawab_essai);
                $rs_essai = json_decode($json_str_essai, true);   

                foreach ($rs_essai as $e) {                                                    
                    $bank_soal_id = $p['bank_soal_id'];
                    $query = $this->db->query("CALL sp_simpan_jawab_soal_essai(?, ?, ?, ?, ?, ?, ?, ?, ?)",
                    [$e['bank_soal_id'], $e['soal_id'], $nis, $e['jawaban'], $e['kata_kunci_1'], $e['kata_kunci_2'], $e['jml_soal'], $e['bobot_nilai'], $e['nilai']]);
                    
                    // $result = $query->row(); --> jangan pake ini karena hasilnya menjadi 1 record aja yang diambil
                    
                    // Bebaskan hasil query
                    $query->free_result();

                    while (mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)) {
                        $res = mysqli_store_result($this->db->conn_id);
                        if ($res instanceof mysqli_result) mysqli_free_result($res);
                    }
                } 
            }

            //echo "nis:".$nis.", bank_soal_id:".$bank_soal_id.";";   
            //proses hitung nilai siswa
            $query = $this->db->query("CALL sp_simpan_nilai_ujian(?, ?)",
            [$bank_soal_id, $nis]);
                    
            // Bebaskan hasil query
            $query->free_result();

            while (mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)) {
                $res = mysqli_store_result($this->db->conn_id);
                if ($res instanceof mysqli_result) mysqli_free_result($res);
            }
                    
            echo json_encode(array('status'=>true, 'data'=>"", 'message'=>'Proses Selesai'));

        } catch (Exception $e) {
            $err_pesan = $e->getMessage();
            $pesan = strpos($err_pesan,"Duplicate");
            if($pesan!=false){
                echo json_encode(array('status'=>false, 'data'=>"", 'message'=>'Data sudah ada'));
            }else{
                echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->getMessage()));
            }
        }
    }
    
}

?>