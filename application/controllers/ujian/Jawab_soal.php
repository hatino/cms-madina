<?php
class Jawab_soal extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('ujian/Mdl_jawab_soal'); 
        check_session_ujian();
    }

    function show_jawab_soal() {
        $username = $_COOKIE['cms-swi-ujian']; 
        $id = $this->input->get('id');        
        $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
        $rs = $query->result();          
        $status_user = '';          
        foreach($rs as $d){
            $status_user = $d->status;
        }          

        $data['username'] = $username; 
        $data['status_user'] = $status_user;
        $data['bank_soal_id'] = $id;
        
        $this->template->load('template_ujian','ujian/frm_jawab_soal', $data); 
    }

    function get_data_adm() {
        $username = $this->input->get('username');
        $status_user = $this->input->get('status_user');
        $bank_soal_id = $this->input->get('bank_soal_id');
        $rs_bank_soal = $this->Mdl_jawab_soal->get_data_adm($bank_soal_id, $username)->result();
        $rs_siswa = $this->Mdl_jawab_soal->get_data_siswa($username)->result();
        foreach($rs_siswa as $d){
            $nama_siswa = $d->nama;
        }

        echo json_encode(array('status'=>true, "data"=>$rs_bank_soal,"nama"=>$nama_siswa, "message"=>""));        
    }
    
    function get_data_soal_pg() {        
        $bank_soal_id = $this->input->get('bank_soal_id');
        $nis = $this->input->get('username');       
        $kelas = $this->input->get('kelas');
        $mapel = $this->input->get('mapel_cls');
        $thnajaran= $this->input->get('thnajaran');
        $jenis_penilaian = $this->input->get('jenis_penilaian');
        $semester = $this->input->get('semester');

        $folder_soal = APPPATH . "cache/soal/".$thnajaran."/".$jenis_penilaian."/".$semester."/";
        // kalau folder belum ada, buat
        if (!is_dir($folder_soal)) {
            mkdir($folder_soal, 0777, true);
        }

        $folder_jawab = APPPATH . "cache/jawab/".$thnajaran."/".$jenis_penilaian."/".$semester."/".$kelas."/";      
        // kalau folder belum ada, buat
        if (!is_dir($folder_jawab)) {
            mkdir($folder_jawab, 0777, true);
        }

        $file_soal = $folder_soal ."soal_". $kelas . "_" . $mapel . "_pg.json";
        $file_jawab = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_pg.json";   
        
        if (file_exists($file_soal) && filesize($file_soal) > 0) {
            // baca file
            $json_str_soal = file_get_contents($file_soal);
            // decode ke array
            $soal = json_decode($json_str_soal, true);           

            //cek apakah sudah ada file jawab (json)
            if(file_exists($file_jawab) && filesize($file_jawab) > 0){
                $json_str_jawab = file_get_contents($file_jawab);
                $jawab = json_decode($json_str_jawab, true);
                //var_dump($soal);
            }else{
                $rs_jawab = $this->Mdl_jawab_soal->get_data_jawab_pg_db($bank_soal_id, $nis)->result();  
                file_put_contents($file_jawab, json_encode($rs_jawab, JSON_PRETTY_PRINT));                
            }            

        }else{
            $rs_soal = $this->Mdl_jawab_soal->get_data_soal_pg_db($bank_soal_id)->result();              
            file_put_contents($file_soal, json_encode($rs_soal, JSON_PRETTY_PRINT));   
           
            if (file_exists($file_soal) && filesize($file_soal) > 0) {
                 $json_str_soal = file_get_contents($file_soal);
                // decode ke array
                $soal = json_decode($json_str_soal, true);           

                //cek apakah sudah ada file jawab (json)
                if(file_exists($file_jawab) && filesize($file_jawab) > 0){
                    $json_str_jawab = file_get_contents($file_jawab);
                    $jawab = json_decode($json_str_jawab, true);
                    //var_dump($soal);
                }else{
                    $rs_jawab = $this->Mdl_jawab_soal->get_data_jawab_pg_db($bank_soal_id, $nis)->result();  
                    file_put_contents($file_jawab, json_encode($rs_jawab, JSON_PRETTY_PRINT));                
                }                            
            }
        }

        //gabungkan berdasarkan soal_id
        $hasil = [];
        //var_dump($soal[0]);
        foreach ($soal as $s) {                
            $bank_soal_id = $s['bank_soal_id'];
            $soal_id = $s['id'];
            $jawaban_siswa = null;
            
            if (file_exists($file_jawab) && filesize($file_jawab) > 0) {
                $json_str_jawab = file_get_contents($file_jawab);
                $jawab = json_decode($json_str_jawab, true);    
                
                foreach ($jawab as $j) {                        
                    if ($j['bank_soal_id'] == $bank_soal_id && $j['soal_id'] == $soal_id ) {                          
                        $jawaban_siswa = $j['jawaban'];
                        break;
                    }
                }
            }              

            $s['jawaban'] = isset($jawaban_siswa) ? $jawaban_siswa : null; // tambahkan jawaban siswa ke soal
            $hasil[] = $s;                
        }    
        echo json_encode(array('status'=>true, "data"=>$hasil, "message"=>"")); 
        
        // $rs_soal = $this->Mdl_jawab_soal->get_data_soal_pg($bank_soal_id, $username)->result();        
        // echo json_encode(array('status'=>true, "data"=>$rs_soal, "message"=>"")); 
    }
       
    function get_data_soal_essai() {
        $bank_soal_id = $this->input->get('bank_soal_id');
        $nis = $this->input->get('username');       
        $kelas = $this->input->get('kelas');
        $mapel = $this->input->get('mapel_cls');
        $thnajaran= $this->input->get('thnajaran');
        $jenis_penilaian = $this->input->get('jenis_penilaian');
        $semester = $this->input->get('semester');

        $folder_soal = APPPATH . "cache/soal/".$thnajaran."/".$jenis_penilaian."/".$semester."/";        
        // kalau folder belum ada, buat
        if (!is_dir($folder_soal)) {
            mkdir($folder_soal, 0777, true);
        }      
        
        $folder_jawab = APPPATH . "cache/jawab/".$thnajaran."/".$jenis_penilaian."/".$semester."/".$kelas."/";        
        // kalau folder belum ada, buat
        if (!is_dir($folder_jawab)) {
            mkdir($folder_jawab, 0777, true);
        }        

        $file_soal = $folder_soal ."soal_". $kelas . "_" . $mapel . "_essai.json";       
        $file_jawab = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_essai.json";

        if (file_exists($file_soal) && filesize($file_soal) > 0) {
            // baca file
            $json_str_soal = file_get_contents($file_soal);
            // decode ke array
            $soal = json_decode($json_str_soal, true);           

            //cek apakah sudah ada file jawab (json)
            if(file_exists($file_jawab) && filesize($file_jawab) > 0){
                $json_str_jawab = file_get_contents($file_jawab);
                $jawab = json_decode($json_str_jawab, true);
                //var_dump($soal);
            }else{
                $rs_jawab = $this->Mdl_jawab_soal->get_data_jawab_essai_db($bank_soal_id, $nis)->result();  
                file_put_contents($file_jawab, json_encode($rs_jawab, JSON_PRETTY_PRINT));                
            }            

        }else{
            $rs_soal = $this->Mdl_jawab_soal->get_data_soal_essai_db($bank_soal_id)->result();              
            file_put_contents($file_soal, json_encode($rs_soal, JSON_PRETTY_PRINT));   
           
            if (file_exists($file_soal) && filesize($file_soal) > 0) {
                 $json_str_soal = file_get_contents($file_soal);
                // decode ke array
                $soal = json_decode($json_str_soal, true);           

                //cek apakah sudah ada file jawab (json)
                if(file_exists($file_jawab) && filesize($file_jawab) > 0){
                    $json_str_jawab = file_get_contents($file_jawab);
                    $jawab = json_decode($json_str_jawab, true);
                    //var_dump($soal);
                }else{
                    $rs_jawab = $this->Mdl_jawab_soal->get_data_jawab_essai_db($bank_soal_id, $nis)->result();  
                    file_put_contents($file_jawab, json_encode($rs_jawab, JSON_PRETTY_PRINT));                
                }                            
            }
        }

        //gabungkan berdasarkan soal_id
        $hasil = [];
        //var_dump($soal[0]);
        foreach ($soal as $s) {                
            $bank_soal_id = $s['bank_soal_id'];
            $soal_id = $s['id'];
            $jawaban_siswa = null;
            
            if (file_exists($file_jawab) && filesize($file_jawab) > 0) {
                $json_str_jawab = file_get_contents($file_jawab);
                $jawab = json_decode($json_str_jawab, true);    
                
                foreach ($jawab as $j) {                        
                    if ($j['bank_soal_id'] == $bank_soal_id && $j['soal_id'] == $soal_id ) {                          
                        $jawaban_siswa = $j['jawaban'];
                        break;
                    }
                }
            }              

            $s['jawaban'] = isset($jawaban_siswa) ? $jawaban_siswa : null; // tambahkan jawaban siswa ke soal
            $hasil[] = $s;                
        }    
        echo json_encode(array('status'=>true, "data"=>$hasil, "message"=>"")); 

    }
     
    function get_jumlah_jawab_soal_json(){        
        $bank_soal_id = $this->input->get('bank_soal_id');
        $nis = $this->input->get('username');
        $kelas = $this->input->get('kelas');
        $mapel = $this->input->get('mapel_cls');
        $thnajaran = $this->input->get('thnajaran');
        $jenis_penilaian = $this->input->get('jenis_penilaian');
        $semester = $this->input->get('semester');
     
        $folder_soal = APPPATH . "cache/soal/".$thnajaran."/".$jenis_penilaian."/".$semester."/";        
        $folder_jawab = APPPATH . "cache/jawab/".$thnajaran."/".$jenis_penilaian."/".$semester."/".$kelas."/";               
        $file_soal_pg = $folder_soal ."soal_". $kelas . "_" . $mapel . "_pg.json";  
        $file_soal_essai = $folder_soal ."soal_". $kelas . "_" . $mapel . "_essai.json"; 
        $file_jawab_pg = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_pg.json";      
        $file_jawab_essai = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_essai.json";

        $hasil = [];
        $jml_soal_pg = 0;
        $jml_soal_essai = 0;
        $jml_jawab_pg = 0;
        $jml_jawab_essai = 0;
        if (file_exists($file_soal_pg) && filesize($file_soal_pg) > 0) {           
            $json_str_soal_pg = file_get_contents($file_soal_pg);            
            $rs_soal_pg = json_decode($json_str_soal_pg, true);
            $jml_soal_pg = count($rs_soal_pg);            
        }   
        if (file_exists($file_soal_essai) && filesize($file_soal_essai) > 0) {           
            $json_str_soal_essai = file_get_contents($file_soal_essai);            
            $rs_soal_essai = json_decode($json_str_soal_essai, true);
            $jml_soal_essai = count($rs_soal_essai);            
        }   
        if(file_exists($file_jawab_pg) && filesize($file_jawab_pg) > 0){
            $json_str_jawab_pg = file_get_contents($file_jawab_pg);
            $rs_jawab_pg = json_decode($json_str_jawab_pg, true);      
            $jml_jawab_pg = count($rs_jawab_pg);           
        }
        if(file_exists($file_jawab_essai) && filesize($file_jawab_essai) > 0){
            $json_str_jawab_essai = file_get_contents($file_jawab_essai);
            $rs_jawab_essai = json_decode($json_str_jawab_essai, true);      
            $jml_jawab_essai = count($rs_jawab_essai);           
        }

        $hasil[] = ['jml_soal'=>$jml_soal_pg+$jml_soal_essai, 'jml_jawaban'=>$jml_jawab_pg+$jml_jawab_essai];
        echo json_encode(array('status'=>true, 'data'=>$hasil, 'message'=>""));
    }
      
    function simpan_jawaban_pg_kejson() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);        
        $bank_soal_id = $data['bank_soal_id'];
        $nis = $data['nis'];
        $kelas = $data['kelas'];
        $mapel = $data['mapel'];
        $thnajaran = $data['thnajaran'];
        $jenis_penilaian = $data['jenis_penilaian'];
        $semester = $data['semester'];
        $soal_id = $data['soal_id'];       
        $jawaban = $data['jawaban'];        
        $status_ekskul = $data['status_ekskul'];

        // Path folder soal (di CI)
        $folder_jawab = APPPATH . "cache/jawab/".$thnajaran."/".$jenis_penilaian."/".$semester."/".$kelas."/";
        // nama file  
        $file_jawab = $folder_jawab."jawab_" . trim($nis) . "_" . $mapel . "_pg.json";   
        // kalau folder belum ada, buat
        if (!is_dir($folder_jawab)) {
            mkdir($folder_jawab, 0777, true);
        }
         
        if (file_exists($file_jawab)) {
            $json_str = file_get_contents($file_jawab);
            $rs = json_decode($json_str, true);
        } else {
            $rs = [];
        }

        $nilai = 0;
        $jml_soal =0;
        $kunci_jawaban = "";
        $bobot_nilai_pg = 0;

        //ambil data : jml_soal, kunci_jawaban
        $folder_soal = APPPATH . "cache/soal/".$thnajaran."/".$jenis_penilaian."/".$semester."/";
        $file_soal = $folder_soal ."soal_". $kelas . "_" . $mapel . "_pg.json";   
        if (file_exists($file_soal)){
            $json_str = file_get_contents($file_soal);
            $rs_soal = json_decode($json_str, true);            
            //set jumlah soal
            $jml_soal = count($rs_soal);
            foreach ($rs_soal as $item_soal) {
                if ($item_soal['bank_soal_id'] == $bank_soal_id && $item_soal['id'] == $soal_id ) {
                    //set kunci jawaban
                    $kunci_jawaban = $item_soal['kunci_jawaban'];
                    break;
                }
            }            
        }  
       
        //$rs_hitung_nilai=$this->Mdl_jawab_soal->hitung_nilai_pg($bank_soal_id, $soal_id, $nis, $jawaban)->result();                        
        // foreach($rs_hitung_nilai as $r){
        //     $bobot_nilai = $r->bobot_pg;
        //     $nilai = $r->nilai;
        //     $kunci_jawaban = $r->kunci_jawaban;
        //     $jml_soal = $r->jml_soal;           
        // }           
        
        //ambil data : bobot_nilai, nilai
        //-------------------------------
        $folder_bobot_nilai = APPPATH . "cache/bobot_nilai/".$thnajaran."/".$jenis_penilaian."/".$semester."/";
        if($status_ekskul=='1'){
            $file_bobot_nilai = $folder_bobot_nilai ."bobot_nilai_ekskul.json"; 
        }else{
            $file_bobot_nilai = $folder_bobot_nilai ."bobot_nilai.json"; 
        }
          
        if (!is_dir($folder_bobot_nilai)) {
            mkdir($folder_bobot_nilai, 0777, true);
        }

        if (file_exists($file_bobot_nilai)){
            $json_str_bobot_nilai = file_get_contents($file_bobot_nilai);
            $rs_bobot_nlai = json_decode($json_str_bobot_nilai, true);
            foreach ($rs_bobot_nlai as $bn) {
                if ($bn['kelas_cls'] == $kelas && $bn['semester'] == $semester ) {
                    //set bobot_nilai
                    $bobot_nilai_pg = $bn['bobot_pg'];
                    break;
                }
            }            
            
        }else{
            $rs_bobot_nlai=$this->Mdl_jawab_soal->get_bobot_nilai_all($status_ekskul)->result();            
            file_put_contents($file_bobot_nilai, json_encode($rs_bobot_nlai, JSON_PRETTY_PRINT)); 
            foreach ($rs_bobot_nlai as $bn) {
                if ($bn->kelas_cls == $kelas && $bn->semester == $semester ) {
                    $bobot_nilai_pg = $bn->bobot_pg;
                }
            }
        }

        if($jawaban==$kunci_jawaban){
            $nilai = $bobot_nilai_pg;
        }
        //-------------------------------

        $found = false;
       
        //Loop cek apakah id sudah ada
        foreach ($rs as &$item) {            
            if ($item['bank_soal_id'] == $bank_soal_id && $item['soal_id'] == $soal_id ) {               
                // Timpa data lama dengan data baru
                $item['jawaban'] = $jawaban;
                $item['nilai'] = $nilai;
                $found = true;
                break;
            }
        }

        // Kalau belum ada, tambah record baru        
        if (!$found) {

            $dt = new DateTime("now", new DateTimeZone('Asia/Jakarta'));           
            $new_record = [
                "bank_soal_id" => $bank_soal_id,
                "soal_id" => $soal_id,
                "nis" => $nis,      
                "jawaban"=> $jawaban,
                "kunci_jawaban" => $kunci_jawaban,
                "nilai" => $nilai,
                "register_user" => $nis,
                "register_date" => $dt->format("Y-m-d H:i:s"),
                "update_user" => $nis,
                "update_date" => $dt->format("Y-m-d H:i:s"),
                "jml_soal" => $jml_soal,
                "bobot_nilai" => $bobot_nilai_pg                
            ];

            //echo $found.'_nilai_found';
            $rs[] = $new_record;
        }

        // Simpan lagi ke file JSON
        file_put_contents($file_jawab, json_encode($rs, JSON_PRETTY_PRINT));
        echo json_encode(array('status'=>true, "data"=>$rs, "message"=>""));
    }
     
    function simpan_jawaban_essai_kejson() {   
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        $bank_soal_id = $data['bank_soal_id'];
        $nis = $data['nis'];
        $kelas = $data['kelas'];
        $mapel = $data['mapel'];
        $thnajaran = $data['thnajaran'];
        $jenis_penilaian = $data['jenis_penilaian'];
        $semester = $data['semester'];
        $soal_id = $data['soal_id'];        
        $jawaban = $data['jawaban'];
        $status_ekskul = $data['status_ekskul'];        
        
        // Path folder soal (di CI)
        $folder_jawab = APPPATH . "cache/jawab/".$thnajaran."/".$jenis_penilaian."/".$semester."/".$kelas."/";
        // nama file
        $file_jawab = $folder_jawab."jawab_" . trim($nis) . "_" . $mapel . "_essai.json";
        // kalau folder belum ada, buat
        if (!is_dir($folder_jawab)) {
            mkdir($folder_jawab, 0777, true);
        }        
        
        $nilai = 0;
        $jml_soal = 0;        
        $kata_kunci_1 = "";
        $kata_kunci_2 = "";
        $bobot_nilai_essai = 0;

        //ambil data : jml_soal, kunci_jawaban
        $folder_soal = APPPATH . "cache/soal/".$thnajaran."/".$jenis_penilaian."/".$semester."/";
        $file_soal = $folder_soal ."soal_". $kelas . "_" . $mapel . "_essai.json";   
        if (file_exists($file_soal)){
            $json_str = file_get_contents($file_soal);
            $rs_soal = json_decode($json_str, true);            
            //set jumlah soal
            $jml_soal = count($rs_soal);
            foreach ($rs_soal as $item_soal) {
                if ($item_soal['bank_soal_id'] == $bank_soal_id && $item_soal['id'] == $soal_id ) {
                    //set kata kunci
                    $kata_kunci_1 = $item_soal['kata_kunci_1'];
                    $kata_kunci_2 = $item_soal['kata_kunci_2'];
                    break;
                }
            }            
        }  

        // $rs_bobot_essai=$this->Mdl_jawab_soal->get_bobot_essai($bank_soal_id, $soal_id, $nis, $jawaban)->result();        
        // foreach($rs_bobot_essai as $r){
        //     $bobot_nilai = $r->bobot_essai;
        //     $kata_kunci_1 = $r->kata_kunci_1;
        //     $kata_kunci_2 = $r->kata_kunci_2;
        //     $jml_soal = $r->jml_soal;
        //     //$nilai = $r->nilai;
        // }

        //ambil data : bobot_nilai, nilai
        //-------------------------------
        $folder_bobot_nilai = APPPATH . "cache/bobot_nilai/".$thnajaran."/".$jenis_penilaian."/".$semester."/";
        if($status_ekskul=='1'){
            $file_bobot_nilai = $folder_bobot_nilai ."bobot_nilai_ekskul.json";
        }else{
            $file_bobot_nilai = $folder_bobot_nilai ."bobot_nilai.json";
        }
         
        if (!is_dir($folder_bobot_nilai)) {
            mkdir($folder_bobot_nilai, 0777, true);
        }

        if (file_exists($file_bobot_nilai)){
            $json_str_bobot_nilai = file_get_contents($file_bobot_nilai);
            $rs_bobot_nlai = json_decode($json_str_bobot_nilai, true);
            foreach ($rs_bobot_nlai as $bn) {
                if ($bn['kelas_cls'] == $kelas && $bn['semester'] == $semester ) {
                    //set bobot_nilai_essai
                    $bobot_nilai_essai = $bn['bobot_uraian'];
                    break;
                }
            }            
            
        }else{
            $rs_bobot_nlai=$this->Mdl_jawab_soal->get_bobot_nilai($kelas, $semester)->result();
            file_put_contents($file_bobot_nilai, json_encode($rs_bobot_nlai, JSON_PRETTY_PRINT)); 
            foreach ($rs_bobot_nlai as $bn) {
                if ($bn->kelas_cls == $kelas && $bn->semester == $semester ) {
                    $bobot_nilai_essai = $bn->bobot_uraian;
                }
            }
        }
        //-------------------------------
       
        //PECAH JAWABAN MENJADI PER KATA
        $jawaban_siswa = preg_split('/\s+/', $jawaban);
        foreach ($jawaban_siswa as $jawab_kata) {
            // Pecah kunci jadi kata-kata
            $kata_kunci_bag_1 = preg_split('/\s+/', $kata_kunci_1);
            // Cek kemiripan dengan tiap kata
            $min_percent_1 = 50;

            if($jawab_kata!=''){
                $akurasi_jwb_1 = 0;
                foreach ($kata_kunci_bag_1 as $kata_1) {
                    similar_text(strtolower($jawab_kata), strtolower($kata_1), $percent_1);
                    if ($percent_1 >= $min_percent_1) {
                        $akurasi_jwb_1 = $percent_1;
                        $text_kata = $kata_1;
                    }
                }
            }

            // Pecah kunci jadi kata-kata
            $kata_kunci_bag_2 = preg_split('/\s+/', $kata_kunci_2);
            // Cek kemiripan dengan tiap kata
            $min_percent_2 = 50;

            if($jawab_kata!=''){
                $akurasi_jwb_2 = 0;
                foreach ($kata_kunci_bag_2 as $kata_2) {
                    similar_text(strtolower($jawab_kata), strtolower($kata_2), $percent_2);
                    if ($percent_2 >= $min_percent_2) {
                        $akurasi_jwb_2 = $percent_2;
                        $text_kata2 = $kata_2;
                    }
                }
            }
        }

        //echo 'percent_1: '.$akurasi_jwb_1.', kata: '.$text_kata.' , percent_2 : '.$akurasi_jwb_2.', kata: '.$text_kata2;

        //tgl 8 oct 2025, dirubah dari cek perkata menjadi langsung jawaban dibandingkan kata kunci
        // similar_text($jawaban, $kata_kunci_1, $akurasi_jwb_1);
        // similar_text($jawaban, $kata_kunci_2, $akurasi_jwb_2); 
      
        if($akurasi_jwb_1 >= 50 && $akurasi_jwb_2 >= 50){
            $nilai = $bobot_nilai_essai;
        }
         
        if (file_exists($file_jawab)) {
            $json_str = file_get_contents($file_jawab);
            $rs = json_decode($json_str, true);
        } else {
            $rs = [];
        }

        $found = false;

        //Loop cek apakah id sudah ada
        foreach ($rs as &$item) {
            if ($item['bank_soal_id'] == $bank_soal_id && $item['soal_id'] == $soal_id ) {
                // Timpa data lama dengan data baru
                $item['jawaban'] = $jawaban;
                $item['nilai'] = $nilai;
                $found = true;
                break;
            }
        }

        // Kalau belum ada, tambah record baru        
        if (!$found) {

            $dt = new DateTime("now", new DateTimeZone('Asia/Jakarta'));           
            $new_record = [
                "bank_soal_id" => $bank_soal_id,
                "soal_id" => $soal_id,
                "nis" => $nis,      
                "jawaban"=> $jawaban,
                "kata_kunci_1" => $kata_kunci_1,
                "kata_kunci_2" => $kata_kunci_2,
                "nilai" => $nilai,
                "register_user" => $nis,
                "register_date" => $dt->format("Y-m-d H:i:s"),
                "update_user" => $nis,
                "update_date" => $dt->format("Y-m-d H:i:s"),
                "bobot_nilai" => $bobot_nilai_essai,
                "jml_soal" => $jml_soal
            ];

            //echo $found.'_nilai_found';
            $rs[] = $new_record;
        }

        // Simpan lagi ke file JSON
        file_put_contents($file_jawab, json_encode($rs, JSON_PRETTY_PRINT));
        echo json_encode(array('status'=>true, "data"=>$rs, "message"=>""));
    }
    
    function hapus_jawaban_pg_json() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);        
        $bank_soal_id = $data['bank_soal_id'];
        $nis = $data['nis'];
        $kelas = $data['kelas'];
        $mapel = $data['mapel'];
        $thnajaran = $data['thnajaran'];
        $jenis_penilaian = $data['jenis_penilaian'];
        $semester = $data['semester'];
        $soal_id = $data['soal_id'];        
        $jawaban = $data['jawaban'];        
        
        // Path folder soal (di CI)
        $folder_jawab = APPPATH . "cache/jawab/".$thnajaran."/".$jenis_penilaian."/".$semester."/".$kelas."/";
        // nama file  
        $file_jawab = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_pg.json";   
        // kalau folder belum ada, buat
        if (!is_dir($folder_jawab)) {
            mkdir($folder_jawab, 0777, true);
        }
        
        if (file_exists($file_jawab)) {
            $json_str = file_get_contents($file_jawab);
            $rs = json_decode($json_str, true);
            //var_dump($rs['jawab']);

            // filter array: simpan hanya yang id ≠ $id
            $dataBaru = array_filter($rs, function($item) use ($bank_soal_id, $soal_id) {
                // hapus baris kalau ID dan bank_soal_id sama dengan parameter
                return !($item['bank_soal_id'] == $bank_soal_id && $item['soal_id'] == $soal_id);                
            });

            // reindex supaya array rapih (index 0,1,2,...)
            $dataBaru = array_values($dataBaru);

            file_put_contents($file_jawab, json_encode($dataBaru, JSON_PRETTY_PRINT));
            echo json_encode(array('status'=>true, "data"=>$dataBaru, "message"=>"")); 
        }
    }

    function simpan_koreksi_jawaban_essai() {
        try {

            include 'conn.php';
            $req = $this->input->post();
           
            $bank_soal_id = $req['bank_soal_id'];
            $soal_id = $req['soal_id'];
            $nis = $req['nis'];
            $jawaban = $req['jawaban'];
            $status_koreksi = $req['status_koreksi'];
           
            $nilai = 0;

            $jawaban = str_replace("'","''",$jawaban);
            $jawaban = str_replace("\\","\\\\",$jawaban);

            $rs_bobot_essai=$this->Mdl_jawab_soal->get_bobot_essai($bank_soal_id, $soal_id, $nis, $jawaban)->result();
            foreach($rs_bobot_essai as $r){
                $bobot_nilai = $r->bobot_essai;
                $kata_kunci_1 = $r->kata_kunci_1;
                $kata_kunci_2 = $r->kata_kunci_2;
                $jml_soal = $r->jml_soal;
                //$nilai = $r->nilai;
            }

            $kata_kunci_1 = str_replace("'","''",$kata_kunci_1);
            $kata_kunci_1 = str_replace("\\","\\\\",$kata_kunci_1);
            $kata_kunci_2 = str_replace("'","''",$kata_kunci_2);
            $kata_kunci_2 = str_replace("\\","\\\\",$kata_kunci_2);

            //simpan dulu jawabannya :
            // $sql = "call sp_simpan_jawab_soal_essai ('".$bank_soal_id."','".$soal_id."', '".$nis."', '".$jawaban."', '".$kata_kunci_1."', '".$kata_kunci_2."', '".$jml_soal."', '".$bobot_nilai."', '".$nilai."' ) ";
            // mysqli_query($conn, $sql);

            //CARA 1
            // $jawaban_siswa = preg_split('/\s+/', $jawaban);
            // foreach ($jawaban_siswa as $jawab_kata) {
            //     // Pecah kunci jadi kata-kata
            //     $kata_kunci_bag_1 = preg_split('/\s+/', $kata_kunci_1);
            //     // Cek kemiripan dengan tiap kata
            //     $min_percent_1 = 50;
            //     $akurasi_jwb_1 = 0;
            //     foreach ($kata_kunci_bag_1 as $kata_1) {
            //         similar_text(strtolower($jawab_kata), strtolower($kata_1), $percent_1);
            //         if ($percent_1 >= $min_percent_1) {
            //             $akurasi_jwb_1 = $percent_1;
            //             $text_kata = $kata_1;
            //         }
            //     }

            //     // Pecah kunci jadi kata-kata
            //     $kata_kunci_bag_2 = preg_split('/\s+/', $kata_kunci_2);
            //     // Cek kemiripan dengan tiap kata
            //     $min_percent_2 = 50;
            //     $akurasi_jwb_2 = 0;
            //     foreach ($kata_kunci_bag_2 as $kata_2) {
            //         similar_text(strtolower($jawab_kata), strtolower($kata_2), $percent_2);
            //         if ($percent_2 >= $min_percent_2) {
            //             $akurasi_jwb_2 = $percent_2;
            //             $text_kata2 = $kata_2;
            //         }
            //     }
            // }

            //CARA 2
            // similar_text($jawaban, $kata_kunci_1, $akurasi_jwb_1);
            // similar_text($jawaban, $kata_kunci_2, $akurasi_jwb_2);

            //echo 'percent_1: '.$akurasi_jwb_1.', kata: '.$text_kata.' , percent_2 : '.$akurasi_jwb_2.', kata: '.$text_kata2;
                                                
            // $rs_hitung_nilai=$this->Mdl_jawab_soal->hitung_nilai_essai($bank_soal_id, $soal_id, $kata_kunci_1, $kata_kunci_2, $nis, $akurasi_jwb_1, $akurasi_jwb_2)->result();
            // foreach($rs_hitung_nilai as $r){               
            //     $nilai = $r->nilai;
            // }

            //kemudian simpan nilai per soalnya :
            if($status_koreksi=='benar'){
                $nilai = $bobot_nilai;
            }
           
            $sql = "call sp_simpan_jawab_soal_essai ('".$bank_soal_id."','".$soal_id."', '".$nis."', '".$jawaban."', '".$kata_kunci_1."', '".$kata_kunci_2."', '".$jml_soal."', '".$bobot_nilai."', '".$nilai."' ) ";           
            mysqli_query($conn, $sql);

            // --- 2. Bersihkan sisa resultset supaya koneksi tidak nyangkut
            while (mysqli_more_results($conn) && mysqli_next_result($conn)) {
                $res = mysqli_store_result($conn);
                if ($res instanceof mysqli_result) {
                    mysqli_free_result($res);
                }
            }
          
            //kemudian simpan nilai per mapel nya :
            $sql = "call sp_simpan_nilai_ujian ('".$bank_soal_id."', '".$nis."') ";
                       
            if(mysqli_query($conn, $sql)){
                $rows = mysqli_affected_rows($conn);

                 // --- 4. Bersihkan lagi resultset
                while (mysqli_more_results($conn) && mysqli_next_result($conn)) {
                    $res = mysqli_store_result($conn);
                    if ($res instanceof mysqli_result) {
                        mysqli_free_result($res);
                    }
                }

                if($rows>0){
                    echo json_encode(array('status'=>true, 'data_id'=>'', 'message'=>'Simpan data sukses' ));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Proses simpan selesai'));
                }
            }

            //Tutup koneksi (supaya koneksi tidak menumpuk di server)
            mysqli_close($conn);

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