<?php
class Normalisasi extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('ujian/Mdl_daftar_nilai');
        // check_session_ujian();
    }

    function show_normalisasi_salah_nilai() {
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
            $this->template->load('template_ujian','ujian/frm_normalisasi_kesalahan_nilai', $data);                             
       }else{
            redirect('auth/login_ujian'); 
       }        
    }

         

    function proses_normalisasi_salah_nilai() {

        try {
            $req = $this->input->post();        
            $thnajaran = $req['list_thnajaran'];
            $kelas = $req['list_kelas'];
            $semester = $req['list_semester'];
            $jenis_penilaian = $req['list_jenis_penilaian'];
            $mapel = $req['list_mapel'];
            $status_arr = $req['status'];
            $nis_arr = $req['nis'];

            if(count($status_arr)>0){
                //ambil data : bobot_nilai, nilai
                //-------------------------------
                $folder_bobot_nilai = APPPATH . "cache/bobot_nilai/".$thnajaran."/".$jenis_penilaian."/".$semester."/";
                $file_bobot_nilai = $folder_bobot_nilai ."bobot_nilai.json";                              
                if (file_exists($file_bobot_nilai)){
                    $json_str_bobot_nilai = file_get_contents($file_bobot_nilai);
                    $rs_bobot_nlai = json_decode($json_str_bobot_nilai, true);
                    foreach ($rs_bobot_nlai as $bn) {
                        if ($bn['kelas_cls'] == $kelas && $bn['semester'] == $semester ) {
                            //set bobot_nilai
                            $bobot_nilai_pg = $bn['bobot_pg'];
                            $bobot_nilai_essai = $bn['bobot_uraian'];
                            break;
                        }
                    }       
                }              
                

                for ($i=0; $i < count($status_arr) ; $i++) { 
                    if($status_arr[$i]=="1"){
                        $nis = $nis_arr[$i];
                        
                        $folder_jawab = APPPATH . "cache/jawab/".$thnajaran."/".$jenis_penilaian."/".$semester."/".$kelas."/";                    
                        $file_jawab_pg = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_pg.json";   
                        $file_jawab_essai = $folder_jawab."jawab_" . $nis . "_" . $mapel . "_essai.json";                              
                        
                        //JAWABAN PG
                        if (file_exists($file_jawab_pg)) {
                            $json_str_pg = file_get_contents($file_jawab_pg);
                            $rs_pg = json_decode($json_str_pg, true);        
                            
                            //INFO PENTING : cek kunci jawaban di file soal dan di file jawaban berbeda, sehingga nilainya masalah
                            //ambil data : kunci_jawaban
                            $folder_soal = APPPATH . "cache/soal/".$thnajaran."/".$jenis_penilaian."/".$semester."/";
                            $file_soal = $folder_soal ."soal_". $kelas . "_" . $mapel . "_pg.json";  
                            //echo  $file_soal;

                            //Loop cek apakah id sudah ada
                            foreach ($rs_pg as &$item) {
                                $bank_soal_id = $item['bank_soal_id'];
                                $soal_id = $item['soal_id'];
                                
                                if (file_exists($file_soal)){
                                    $json_str = file_get_contents($file_soal);
                                    $rs_soal = json_decode($json_str, true);    
                                    //var_dump($rs_soal);        
                                    //set jumlah soal
                                    $jml_soal = count($rs_soal);
                                    foreach ($rs_soal as $item_soal) {
                                        if ($item_soal['bank_soal_id'] == $bank_soal_id && $item_soal['id'] == $soal_id ) {
                                            //set kunci jawaban
                                            $kunci_jawaban_soal = $item_soal['kunci_jawaban'];
                                            break;
                                        }
                                    }            
                                }else{
                                    echo 'file not exists';
                                }

                                if ($item['jawaban']==$item['kunci_jawaban'] && $item['nis']==$nis){
                                    $item['nilai'] = $bobot_nilai_pg;    
                                    $item['bobot_nilai'] = $bobot_nilai_pg;                                  
                                    //break;
                                }else{
                                    if ($kunci_jawaban_soal!=$item['kunci_jawaban'] 
                                        && $item['nis']==$nis 
                                        && $item['jawaban'] == $kunci_jawaban_soal ){
                                        
                                        $item['nilai'] = $bobot_nilai_pg; 
                                        $item['kunci_jawaban'] = $kunci_jawaban_soal;
                                        $item['bobot_nilai'] = $bobot_nilai_pg;
                                    }
                                }

                                if ($item['jawaban']!=$item['kunci_jawaban'] 
                                    && $item['nis']==$nis 
                                    && $item['bobot_nilai']!=$bobot_nilai_pg ){

                                    $item['bobot_nilai'] = $bobot_nilai_pg;
                                }
                            }

                            // Simpan lagi ke file JSON
                            file_put_contents($file_jawab_pg, json_encode($rs_pg, JSON_PRETTY_PRINT));                           
                            
                        }
                        
                        //JAWABAN ESSAI
                        if (file_exists($file_jawab_essai)) {
                            $json_str_essai = file_get_contents($file_jawab_essai);
                            $rs_essai = json_decode($json_str_essai, true);   

                            
                            foreach ($rs_essai as &$e) {     
                                $jawaban_essai = $e['jawaban'];
                                $kata_kunci_1 = $e['kata_kunci_1'];
                                $kata_kunci_2 = $e['kata_kunci_2'];     
                                $soal_id = $e['soal_id'];                          
                            
                                //PECAH JAWABAN MENJADI PER KATA
                                $jawaban_siswa = preg_split('/\s+/', $jawaban_essai);
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
                                
                                //echo 'nis:'.$nis.', soal_id:'.$soal_id.', akurasi_jwb_1 :'.$akurasi_jwb_1.", akurasi_jwb_1:".$akurasi_jwb_2."; ";

                                if($akurasi_jwb_1 >= 50 || $akurasi_jwb_2 >= 50 && $e['nis'] == $nis ){                                   
                                    $e['nilai'] = $bobot_nilai_essai;
                                    $e['bobot_nilai'] = $bobot_nilai_essai;
                                }else{
                                    if( $e['nis'] == $nis && $e['bobot_nilai'] != $bobot_nilai_essai){
                                        $e['bobot_nilai'] = $bobot_nilai_essai;
                                    }
                                }   
                            }

                            // echo '#LAST => akurasi_jwb_1 :'.$akurasi_jwb_1.", akurasi_jwb_1:".$akurasi_jwb_2.";";
                            // if($akurasi_jwb_1 >= 50 || $akurasi_jwb_2 >= 50 && $e['nis'] == $nis ){                                   
                            //     $e['nilai'] = $bobot_nilai_essai;
                            //     $e['bobot_nilai'] = $bobot_nilai_essai;
                            // }
                        } 

                        // Simpan lagi ke file JSON
                        file_put_contents($file_jawab_essai, json_encode($rs_essai, JSON_PRETTY_PRINT));
                        //echo json_encode(array('status'=>true, "data"=>"", "message"=>""));
                        
                        //proses hitung nilai siswa
                        // $query = $this->db->query("CALL sp_simpan_nilai_ujian(?, ?)",
                        // [$e['bank_soal_id'], $nis]);
                                
                        // // Bebaskan hasil query
                        // $query->free_result();

                        // while (mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)) {
                        //     $res = mysqli_store_result($this->db->conn_id);
                        //     if ($res instanceof mysqli_result) mysqli_free_result($res);
                        // }


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

}
?>