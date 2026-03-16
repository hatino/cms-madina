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
        $username = $this->input->get('username');
        $rs_soal = $this->Mdl_jawab_soal->get_data_soal_pg($bank_soal_id, $username)->result();        
        echo json_encode(array('status'=>true, "data"=>$rs_soal, "message"=>"")); 
    }
    
    function get_data_soal_essai() {
        $bank_soal_id = $this->input->get('bank_soal_id');
        $username = $this->input->get('username');
        $rs_soal = $this->Mdl_jawab_soal->get_data_soal_essai($bank_soal_id, $username)->result();       
        echo json_encode(array('status'=>true, 'data'=>$rs_soal, 'message'=>""));
    }

    function get_jumlah_jawab_soal() {
        $bank_soal_id = $this->input->get('bank_soal_id');
        $username = $this->input->get('username');
        $rs_jml = $this->Mdl_jawab_soal->get_jumlah_jawab_soal($bank_soal_id, $username)->result();
        echo json_encode(array('status'=>true, 'data'=>$rs_jml, 'message'=>""));
    }

    function simpan_jawaban_pg() {
        try {                            
            include 'conn.php';
            //$conn = getConnection();

            $data = $this->input->post();  
            $bank_soal_id = $data['bank_soal_id'];
            $soal_id = $data['soal_id'];
            $nis = $data['nis'];
            $jawaban = $data['jawaban'];
            $rs_hitung_nilai=$this->Mdl_jawab_soal->hitung_nilai_pg($bank_soal_id, $soal_id, $nis, $jawaban)->result();
                        
            foreach($rs_hitung_nilai as $r){
                $bobot_nilai = $r->bobot_pg;
                $kunci_jawaban = $r->kunci_jawaban;
                $jml_soal = $r->jml_soal;
                $nilai = $r->nilai;
            }
            
            //simpan dulu jawaban dan nilai per soal nya :
            $sql = "
            call sp_simpan_jawab_soal_pg ('".$bank_soal_id."', '".$soal_id."', '".$nis."', '".$jawaban."', '".$kunci_jawaban."', '".$jml_soal."', '".$bobot_nilai."', '".$nilai."' )
            ";
            mysqli_query($conn, $sql);

            // --- Bersihkan sisa resultset
            while (mysqli_more_results($conn) && mysqli_next_result($conn)) {
                $res = mysqli_store_result($conn);
                if ($res instanceof mysqli_result) {
                    mysqli_free_result($res);
                }
            }

            //kemudian simpan nilai per mapel nya :
            $sql = "call sp_simpan_nilai_ujian ('".$bank_soal_id."', '".$nis."') ";
           
            if(mysqli_query($conn,$sql)){
                $rows = mysqli_affected_rows($conn);

                // Bersihkan lagi
                while (mysqli_more_results($conn) && mysqli_next_result($conn)) {
                    $res = mysqli_store_result($conn);
                    if ($res instanceof mysqli_result) {
                        mysqli_free_result($res);
                    }
                }

                if ($rows>0){
                    echo json_encode(array('status'=>true,'data_id'=>'', 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
                }
            }       

            //Tutup koneksi (supaya koneksi tidak menumpuk di server)
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

    function simpan_jawaban_essai() {
        try {

            include 'conn.php';
            $req = $this->input->post();
            $bank_soal_id = $req['bank_soal_id'];
            $soal_id = $req['soal_id'];
            $nis = $req['nis'];
            $jawaban = $req['jawaban'];
           
            $nilai = 0;

            $rs_bobot_essai=$this->Mdl_jawab_soal->get_bobot_essai($bank_soal_id, $soal_id, $nis, $jawaban)->result();
            foreach($rs_bobot_essai as $r){
                $bobot_nilai = $r->bobot_essai;
                $kata_kunci_1 = $r->kata_kunci_1;
                $kata_kunci_2 = $r->kata_kunci_2;
                $jml_soal = $r->jml_soal;
                //$nilai = $r->nilai;
            }

            //simpan dulu jawabannya :
            // $sql = "call sp_simpan_jawab_soal_essai ('".$bank_soal_id."','".$soal_id."', '".$nis."', '".$jawaban."', '".$kata_kunci_1."', '".$kata_kunci_2."', '".$jml_soal."', '".$bobot_nilai."', '".$nilai."' ) ";
            // mysqli_query($conn, $sql);

            // bersihkan resultset
            // while (mysqli_more_results($conn) && mysqli_next_result($conn)) {
            //     $res = mysqli_store_result($conn);
            //     if ($res instanceof mysqli_result) mysqli_free_result($res);
            // }
            
            //PECAH JAWABAN MENJADI PER KATA
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

            //echo 'percent_1: '.$akurasi_jwb_1.', kata: '.$text_kata.' , percent_2 : '.$akurasi_jwb_2.', kata: '.$text_kata2;

            //tgl 8 oct 2025, dirubah dari cek perkata menjadi langsung jawaban dibandingkan kata kunci
            similar_text($jawaban, $kata_kunci_1, $akurasi_jwb_1);
            similar_text($jawaban, $kata_kunci_2, $akurasi_jwb_2); 
            
            if($akurasi_jwb_1 >= 50){
                $nilai = $bobot_nilai;
            }
                                                
            // $rs_hitung_nilai=$this->Mdl_jawab_soal->hitung_nilai_essai($bank_soal_id, $soal_id, $kata_kunci_1, $kata_kunci_2, $nis, $akurasi_jwb_1, $akurasi_jwb_2)->result();
            // foreach($rs_hitung_nilai as $r){               
            //     $nilai = $r->nilai;
            // }

            //kemudian simpan nilai per soalnya :
            $sql = "call sp_simpan_jawab_soal_essai ('".$bank_soal_id."','".$soal_id."', '".$nis."', '".$jawaban."', '".$kata_kunci_1."', '".$kata_kunci_2."', '".$jml_soal."', '".$bobot_nilai."', '".$nilai."' ) ";
            mysqli_query($conn, $sql);

            // bersihkan resultset
            while (mysqli_more_results($conn) && mysqli_next_result($conn)) {
                $res = mysqli_store_result($conn);
                if ($res instanceof mysqli_result) mysqli_free_result($res);
            }

            //kemudian simpan nilai per mapel nya :
            $sql = "call sp_simpan_nilai_ujian ('".$bank_soal_id."', '".$nis."') ";
                       
            if(mysqli_query($conn, $sql)){
                $rows = mysqli_affected_rows($conn);

                // bersihkan resultset
                while (mysqli_more_results($conn) && mysqli_next_result($conn)) {
                    $res = mysqli_store_result($conn);
                    if ($res instanceof mysqli_result) mysqli_free_result($res);
                }

                if($rows>0){
                    echo json_encode(array('status'=>true, 'data_id'=>'', 'message'=>'Simpan data sukses' ));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Proses simpan selesai'));
                }
            }

            // --- tutup koneksi
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

            $rs_bobot_essai=$this->Mdl_jawab_soal->get_bobot_essai($bank_soal_id, $soal_id, $nis, $jawaban)->result();
            foreach($rs_bobot_essai as $r){
                $bobot_nilai = $r->bobot_essai;
                $kata_kunci_1 = $r->kata_kunci_1;
                $kata_kunci_2 = $r->kata_kunci_2;
                $jml_soal = $r->jml_soal;
                //$nilai = $r->nilai;
            }

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