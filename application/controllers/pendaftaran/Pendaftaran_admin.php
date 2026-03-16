<?php

// defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH.'vendor/autoload.php';
        
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pendaftaran_admin extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('pendaftaran/Mdl_pendaftaran');       
        check_session();        
    }
    
    function show_brosur_pendaftaran_admin(){        
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template_admin','pendaftaran/frm_brosur_pendaftaran_adm',$data);            
    }

    function show_info_pendaftaran_admin(){        
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template_admin','pendaftaran/frm_info_pendaftaran_admin',$data);            
    }

    function show_daftar_calon_siswa(){        
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template_admin','pendaftaran/frm_daftar_calon_siswa',$data);            
    }

    function show_siswa_detail(){        
        // $kode_jenjang =  $this->input->get('kode_jenjang'); 
        // $siswa_id = $this->input->get('siswa_id'); 
        // $data = array(
        //     'kode_jenjang' => $kode_jenjang,
        //     'siswa_id' => $siswa_id,           
        //     'form_id' =>  'admin_form'
        // );       
        // $data['user_name'] = $_COOKIE['cms-swi-user'];
        $data['kode_jenjang'] =  $this->input->get('kode_jenjang'); 
        $data['siswa_id'] = $this->input->get('siswa_id');        
        $data['form_id'] =  'admin_form';
        $this->template->load('template_admin','pendaftaran/frm_siswa_detail', $data);            
    }

    function show_upload_siswa_baru(){
        $kode_jenjang =  $this->input->get('kode_jenjang'); 
        $siswa_id = $this->input->get('siswa_id'); 
        $data = array(
            'kode_jenjang' => $kode_jenjang,
            'siswa_id' => $siswa_id           
        );       
        $this->template->load('template_admin','pendaftaran/frm_upload_siswa_baru', $data);            
    }

    function show_hasil_observasi_ppdb(){
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template_admin','pendaftaran/frm_hasil_observasi_adm', $data);            
    }

    function show_pengecekan_data_siswa(){
        // $data['user_name'] = $_COOKIE['cms-swi-user'];
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');  
        $data['siswa_id'] = '0';    
        $data['form_id'] =  'admin_form';        
        $this->template->load('template_admin','pendaftaran/frm_siswa_detail',$data);     
    }

    function proses_upload_file() {
        $upload_file = $_FILES['file_siswa_baru']['name'];
        $extension = pathinfo($upload_file,PATHINFO_EXTENSION);
        if($extension=='xls'){
            $reader= new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }else if($extension=='xlsx'){           
            $reader= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();            
        }
        
        $spreadsheet=$reader->load($_FILES['file_siswa_baru']['tmp_name']);
        $sheetdata=$spreadsheet->getActiveSheet()->toArray();
        // echo '<pre>';
        // print_r($sheetdata);
        echo json_encode(array('status'=>true, 'data'=>[$sheetdata], 'message'=>"")) ;  

    }

    
    function get_data_thn_ajaran_with_status_open(){
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->Mdl_pendaftaran->get_data_thn_ajaran_with_status_open($kode_jenjang)->result();
            $info_pendaftaran_arr = array();
                        
            foreach ($data as $d)
            {                      
                $thn_ajaran_cls = $d->thn_ajaran_cls;
                $thn_ajaran_nama = $d->thn_ajaran_nama;     
                $status_open = $d->status_open;  
                
                $info_pendaftaran_arr[] = array("thn_ajaran_cls" => $thn_ajaran_cls,
                                                  "thn_ajaran_nama" => $thn_ajaran_nama,
                                                  "status_open" => $status_open                                                 
                                                );                                    
            }        
            // encoding array to json format            
            echo json_encode(array('status'=>true, 'data'=>[$info_pendaftaran_arr], 'message'=>"")) ;  
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }


    function get_data_tbl_daftar_siswa_hasil_observasi_adm() {
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $thn_ajaran_cls = $this->input->get('thn_ajaran_cls');
            $data = $this->Mdl_pendaftaran->get_data_tbl_daftar_siswa_hasil_observasi_adm($kode_jenjang, $thn_ajaran_cls)->result();
           
            // encoding array to json format            
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;  
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }


    function get_data_info_pendaftaran() {
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $thn_ajaran_cls = $this->input->get('thn_ajaran_cls');            
            $data=$this->Mdl_pendaftaran->get_data_info_pendaftaran($kode_jenjang, $thn_ajaran_cls)->result();
            
            // echo $data;
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


    function get_data_tbl_daftar_calon_siswa () {
        try {     
            include 'conn.php';       
            $kode_jenjang = $this->input->get('kode_jenjang');
            $thn_ajaran_cls = $this->input->get('thn_ajaran_cls');            
            $sql = $this->Mdl_pendaftaran->get_data_tbl_daftar_calon_siswa($kode_jenjang, $thn_ajaran_cls);
         
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

    function get_data_siswa_detail () {
        try {     
            include 'conn.php';       
            $siswa_id = $this->input->get('siswa_id');       
            $sql = $this->Mdl_pendaftaran->get_data_siswa_detail($siswa_id);
            
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
       
    function get_data_hasil_observasi_adm () {
        try {     
            include 'conn.php';       
            $kode_jenjang = $this->input->get('kode_jenjang');
            $thn_ajaran_cls = $this->input->get('thn_ajaran_cls');           
            $sql = $this->Mdl_pendaftaran->get_data_hasil_observasi_adm($kode_jenjang, $thn_ajaran_cls);
                      
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

    function get_data_tbl_brosur(){
        try {     
            include 'conn.php';       
            $kode_jenjang = $this->input->get('kode_jenjang');
            $thn_ajaran_cls = $this->input->get('thn_ajaran_cls');           
            $sql = $this->Mdl_pendaftaran->get_data_tbl_brosur($kode_jenjang, $thn_ajaran_cls);           
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
    

    function simpan_upload_siswa() {
        try {                            
            include 'conn.php';

            $data = $this->input->post('data');              
            $data_arr[] = json_decode($data);
            $data1 = $data_arr[0];
            //print_r($data1);
            $output = 'insert into master_siswa_baru_upload values ';
            
            foreach($data1 as $key => $value)
            {
                $stdArray[$key] = (array) $value;  
                $thn_ajaran = $stdArray[$key]['thn_ajaran'];             
                $unit_sekolah = $stdArray[$key]['unit_sekolah'];
                $nis = $stdArray[$key]['nis'];
                $nama = $stdArray[$key]['nama'];
                $alamat = $stdArray[$key]['alamat'];
                $output .= "('".$thn_ajaran."', '".$unit_sekolah."', '".$nis."', '".$nama."', '".$alamat."','', now()),";
            }   

            $output2 = rtrim($output,', ');
            //print_r($output2);
            /*** show the results ***/  
            //print_r( $data1[1]['nis']);
            
            // $username = $this->session->userdata('username');  
            // $list_thn_ajaran = $this->input->post('list_thn_ajaran');
            // $txt_kode_jenjang = $this->input->post('txt_kode_jenjang');
            // $txt_info_pendaftaran = $this->input->post('txt_info_pendaftaran');
           
            // $query=$this->Mdl_pendaftaran->simpan_info_pendaftaran($list_thn_ajaran, $txt_kode_jenjang, $txt_info_pendaftaran, $username);
                    
            if (mysqli_query($conn, $output2)) {
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
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }
                else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
                }            
            }
           
            mysqli_close($conn);
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }


    function simpan_info_pendaftaran() {        
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');  
            $list_thn_ajaran = $this->input->post('list_thn_ajaran');
            $txt_kode_jenjang = $this->input->post('txt_kode_jenjang');
            $txt_info_pendaftaran = $this->input->post('txt_info_pendaftaran');
           
            $query=$this->Mdl_pendaftaran->simpan_info_pendaftaran($list_thn_ajaran, $txt_kode_jenjang, $txt_info_pendaftaran, $username);
                    
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
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }
                else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
                }            
            }
           
            mysqli_close($conn);
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }


    function simpan_hasil_observasi() {
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');  
            $data = $this->input->post();
            //print_r($data);  die;
            $query=$this->Mdl_pendaftaran->simpan_hasil_observasi($data, $username);
                    
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
                if($err_code==1062){
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }
                else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
                }            
            }
           
            mysqli_close($conn);
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }

    function simpan_brosur(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username'); 
            $status_edit = $this->input->post('txt_status_edit');
            $brosur_id = $this->input->post('txt_brosur_id');
            $kode_jenjang = $this->input->post('txt_kode_jenjang');
            $thn_ajaran_cls = $this->input->post('list_thn_ajaran');
            $keterangan_brosur = $this->input->post('txt_keterangan_brosur');
            $uploaded_img_brosur_path = $this->input->post('uploaded_image_brosur_path');
 
            $query=$this->Mdl_pendaftaran->simpan_brosur($status_edit,
                                                        $brosur_id,
                                                        $kode_jenjang,
                                                        $thn_ajaran_cls,
                                                        $keterangan_brosur,                                                     
                                                        $uploaded_img_brosur_path,
                                                        $username);   
            // print_r($query);
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){     
                    if ($status_edit=='false'){
                        $brosur_id_temp = $conn->insert_id;                            
                        echo json_encode(array('status'=>true,'data'=>$brosur_id_temp, 'message'=>'Simpan data sukses'));
                    }else{
                        $brosur_id_temp = $brosur_id;
                        echo json_encode(array('status'=>true,'data'=>$brosur_id_temp, 'message'=>'Simpan data sukses'));
                    }
                }else{
                    echo json_encode(array('status'=>true,'data'=>'0', 'message'=>'Simpan data tidak berhasil'));
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


    function simpan_img_path() {
        include 'conn.php';
        $brosur_id = $this->input->post('brosur_id');
        $img_file_path = $this->input->post('img_file_path');
       
        $query = "
        update  brosur 
        set     img_path = '$img_file_path'
            ,   update_date = now()
        where   brosur_id = '$brosur_id'
        ";
        
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$brosur_id, 'message'=>'Simpan data sukses'));
    }

    function delete_brosur() {
        include 'conn.php';
        $brosur_id = $this->input->post('brosur_id');
        $img_file_path = $this->input->post('img_file_path');

        $query ="
        delete  from brosur
        where   brosur_id = '$brosur_id'
        ";
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){      
                if($img_file_path != '' ){
                    $file_temp = explode('/', $img_file_path);
                    $file_name = end($file_temp);     
                    $file_to_del =  './images/images_brosur/'.$file_name;                                            
                    unlink($file_to_del); 
                }                                                        
                echo json_encode(array('status'=>true,'data'=>$brosur_id, 'message'=>'Simpan data sukses'));               
            }else{
                echo json_encode(array('status'=>true,'data'=>'0', 'message'=>'Simpan data tidak berhasil'));
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
    }

    function cek_thn_ajaran_exists() {
        try {            
            $thn_ajaran = $this->input->get('thn_ajaran');
            $data=$this->Mdl_pendaftaran->cek_thn_ajaran_exists($thn_ajaran)->result();            
            // encoding array to json format            
            echo json_encode(array('status'=>true, 'data'=>[$data], 'message'=>"")) ;  
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }
    
    function cek_unit_sekolah_exists() {
        try {            
            $unit_sekolah = $this->input->get('unit_sekolah');
            $data=$this->Mdl_pendaftaran->cek_unit_sekolah_exists($unit_sekolah)->result();            
            // encoding array to json format            
            echo json_encode(array('status'=>true, 'data'=>[$data], 'message'=>"")) ;  
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }

    function cek_nis_double() {
        try {            
            $nis = $this->input->get('nis');
            $thn_ajaran = $this->input->get('thn_ajaran');
            $data=$this->Mdl_pendaftaran->cek_nis_double($nis, $thn_ajaran)->result();            
            // encoding array to json format            
            echo json_encode(array('status'=>true, 'data'=>[$data], 'message'=>"")) ;  
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }

    function generateXls_daftar_calon_siswa(){      

        header('Content-Type:application/vnd.ms-excel');        
        header('Content-Disposition:attachment; filename="daftar_siswa.xlsx" ');
        header('Content-Transfer-Encoding: binary');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'SISWA ID');
        $sheet->setCellValue('C1', 'NO PENDAFTARAN');
        $sheet->setCellValue('D1', 'NAMA');
        $sheet->setCellValue('E1', 'NAMA PANGGILAN');
        $sheet->setCellValue('F1', 'JENIS KELAMIN');
        $sheet->setCellValue('G1', 'TEMPAT LAHIR');
        $sheet->setCellValue('H1', 'TGL LAHIR');
        $sheet->setCellValue('I1', 'ANAK KE');
        $sheet->setCellValue('J1', 'JML SAUDARA');
        $sheet->setCellValue('K1', 'AGAMA');
        $sheet->setCellValue('L1', 'BERAT BADAN');
        $sheet->setCellValue('M1', 'TINGGI BADAN');
        $sheet->setCellValue('N1', 'LINGKAR KEPALA');
        $sheet->setCellValue('O1', 'KEWARGANEGARAAN');
        $sheet->setCellValue('P1', 'NO. KARTU KELUARGA');
        $sheet->setCellValue('Q1', 'NO. AKTA LAHIR');
        $sheet->setCellValue('R1', 'NIK/KITAS');
        $sheet->setCellValue('S1', 'RIWAYAT KESEHATAN');
        $sheet->setCellValue('T1', 'KEBUTUHAN KHUSUS');
        $sheet->setCellValue('U1', 'ALAMAT');
        $sheet->setCellValue('V1', 'KECAMATAN');
        $sheet->setCellValue('W1', 'KELURAHAN');
        $sheet->setCellValue('X1', 'KODEPOS');
        $sheet->setCellValue('Y1', 'JENIS TEMPAT TINGGAL');
        $sheet->setCellValue('Z1', 'MODA TRANSPORTASI');
        $sheet->setCellValue('AA1', 'JARAK KE SEKOLAH');
        $sheet->setCellValue('AB1', 'NAMA AYAH');
        $sheet->setCellValue('AC1', 'HP AYAH');
        $sheet->setCellValue('AD1', 'PENDIDIKAN AYAH');
        $sheet->setCellValue('AE1', 'PEKERJAAN AYAH');
        $sheet->setCellValue('AF1', 'PENGHASILAN AYAH');
        $sheet->setCellValue('AG1', 'NAMA PERUSAHAAN AYAH');
        $sheet->setCellValue('AH1', 'NAMA IBU');
        $sheet->setCellValue('AI1', 'HP IBU');
        $sheet->setCellValue('AJ1', 'PENDIDIKAN IBU');
        $sheet->setCellValue('AK1', 'PEKERJAAN IBU');
        $sheet->setCellValue('AL1', 'PENGHASILAN IBU');
        $sheet->setCellValue('AM1', 'NAMA PERUSAHAAN IBU');
        $sheet->setCellValue('AN1', 'NO TELP RUMAH');
        $sheet->setCellValue('AO1', 'NO HP');
        $sheet->setCellValue('AP1', 'EMAIL');
        $sheet->setCellValue('AQ1', 'SAUDARA/ALUMNI AL-ITTIHAD');
        $sheet->setCellValue('AR1', 'MENGETAHUI SEKOLAH DARI');

        $kode_jenjang = $this->input->get('kode_jenjang');
        $thn_ajaran_cls = $this->input->get('thn_ajaran_cls');            
        $sql = $this->Mdl_pendaftaran->get_data_tbl_daftar_calon_siswa($kode_jenjang, $thn_ajaran_cls);
        
        include 'conn.php';  
        $i = 2;
        $no = 1;
        $sth = mysqli_query($conn, $sql);
        while($d = mysqli_fetch_assoc($sth)) {     
            $tgl = substr($d['tgl_lahir'],0,10);    
            $sheet->setCellValue('A'.$i, $no++);
            $sheet->setCellValue('B'.$i, $d['siswa_id']);
            $sheet->setCellValue('C'.$i, $d['no_pendaftaran']);
            $sheet->setCellValue('D'.$i, $d['nama']);
            $sheet->setCellValue('E'.$i, $d['nama_panggilan']);
            $sheet->setCellValue('F'.$i, $d['jenis_kelamin']);
            $sheet->setCellValue('G'.$i, $d['tempat_lahir']);
            $sheet->setCellValue('H'.$i, $tgl);
            $sheet->setCellValue('I'.$i, $d['anak_ke']);
            $sheet->setCellValue('J'.$i, $d['jml_saudara']);
            $sheet->setCellValue('K'.$i, $d['agama']);
            $sheet->setCellValue('L'.$i, $d['berat_badan']);
            $sheet->setCellValue('M'.$i, $d['tinggi_badan']);
            $sheet->setCellValue('N'.$i, $d['lingkar_kepala']);
            $sheet->setCellValue('O'.$i, $d['kewarganegaraan']);
            $sheet->setCellValue('P'.$i, $d['no_kartu_keluarga']);
            $sheet->setCellValue('Q'.$i, $d['no_registrasi_akta_lahir']);
            $sheet->setCellValue('R'.$i, $d['nik_no_kitas']);
            $sheet->setCellValue('S'.$i, $d['riwayat_kesehatan']);
            $sheet->setCellValue('T'.$i, $d['kebutuhan_khusus']);
            $sheet->setCellValue('U'.$i, $d['alamat']);
            $sheet->setCellValue('V'.$i, $d['kecamatan']);
            $sheet->setCellValue('W'.$i, $d['kelurahan']);
            $sheet->setCellValue('X'.$i, $d['kodepos']);
            $sheet->setCellValue('Y'.$i, $d['jenis_tempat_tinggal']);
            $sheet->setCellValue('Z'.$i, $d['moda_transportasi']);
            $sheet->setCellValue('AA'.$i, $d['jarak_ke_sekolah']);
            $sheet->setCellValue('AB'.$i, $d['nama_ayah']);
            $sheet->setCellValue('AC'.$i, $d['hp_ayah']);
            $sheet->setCellValue('AD'.$i, $d['pendidikan_ayah']);
            $sheet->setCellValue('AE'.$i, $d['pekerjaan_ayah']);
            $sheet->setCellValue('AF'.$i, $d['penghasilan_ayah']);
            $sheet->setCellValue('AG'.$i, $d['nama_perusahaan_ayah']);
            $sheet->setCellValue('AH'.$i, $d['nama_ibu']);
            $sheet->setCellValue('AI'.$i, $d['hp_ibu']);
            $sheet->setCellValue('AJ'.$i, $d['pendidikan_ibu']);
            $sheet->setCellValue('AK'.$i, $d['pekerjaan_ibu']);
            $sheet->setCellValue('AL'.$i, $d['penghasilan_ibu']);
            $sheet->setCellValue('AM'.$i, $d['nama_perusahaan_ibu']);
            $sheet->setCellValue('AN'.$i, $d['no_telp_rumah']);
            $sheet->setCellValue('AO'.$i, $d['no_hp']);
            $sheet->setCellValue('AP'.$i, $d['email']);
            $sheet->setCellValue('AQ'.$i, $d['kakak_adik_alumni']);
            $sheet->setCellValue('AR'.$i, $d['info_sekolah_dari']);            
            $i++;
        }

        
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        foreach (range('A','Z') as $col) {    
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }        
                
        $sheet->getColumnDimension('AA')->setAutoSize(true);
        $sheet->getColumnDimension('AB')->setAutoSize(true);
        $sheet->getColumnDimension('AC')->setAutoSize(true);
       
        $spreadsheet->getActiveSheet()->getStyle('A1:AR1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C0C0C0');

        $writer = new Xlsx($spreadsheet);
        //$writer->save(FCPATH.'uploads/Data karyawan.xlsx');
        $writer->save("php://output");
        exit;
        //echo "<script>window.location = 'Data karyawan.xlsx'</script>";
    }


    function generateXls_unit_sekolah_template(){      

        header('Content-Type:application/vnd.ms-excel');        
        header('Content-Disposition:attachment; filename="template_pelajaran.xlsx" ');
        header('Content-Transfer-Encoding: binary');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'NO.');
        $sheet->setCellValue('B1', 'UNIT SEKOLAH');
        $sheet->setCellValue('C1', 'KELOMPOK MAPEL');
        $sheet->setCellValue('D1', 'NAMA MAPEL');
        
               
        // $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        // foreach (range('A','D') as $col) {    
        //     $sheet->getColumnDimension($col)->setAutoSize(true);
        // }        
       
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal('center');
             
        $spreadsheet->getActiveSheet()->getStyle('A1:D1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C0C0C0');

        $writer = new Xlsx($spreadsheet);
        //$writer->save(FCPATH.'uploads/Data karyawan.xlsx');
        $writer->save("php://output");
        exit;
        //echo "<script>window.location = 'Data karyawan.xlsx'</script>";
    }

    
}