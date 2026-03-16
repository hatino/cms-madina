<?php

use SebastianBergmann\Environment\Console;

class Profil extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('master/mdl_profil');       
        //check_session();
    }
    
    function show_input_gbr_home(){        
        $this->template->load('template_admin','master/frm_input_gbr_home');            
    }

    function show_profil(){        
        $this->template->load('template_admin','master/frm_profil');            
    }

    function show_profil_unit_sekolah(){        
        $this->template->load('template_admin','master/frm_profil_unit_sekolah');            
    }

    function show_testimoni(){        
        $this->template->load('template_admin','master/frm_testimoni');            
    }

    function get_carousel_text() {
        $data=$this->mdl_profil->get_carousel_text()->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;   
    }

    function get_data_profil_yayasan(){        
        try {                  
            $data=$this->mdl_profil->get_data_profil_yayasan()->result();
          
            $profil_arr = array();
        
            foreach ($data as $d)
            {       
                $nama = $d->nama;
                $alamat = $d->alamat;
                $telp = $d->telp;
                $no_hotline = $d->no_hotline;
                $sejarah = $d->sejarah;
                $photo_sejarah_path = $d->photo_sejarah_path;
                $visi = $d->visi;
                $misi = $d->misi;
                $photo_visi_path = $d->photo_visi_path;
                $google_map = $d->google_map;

                $profil_arr[] = array("nama" => $nama,
                                    "alamat" => $alamat,
                                    "telp" => $telp,
                                    "no_hotline" => $no_hotline,
                                    "sejarah" => $sejarah,
                                    "photo_sejarah_path" => $photo_sejarah_path,
                                    "visi" => $visi,
                                    "misi" => $misi,
                                    "photo_visi_path" => $photo_visi_path,
                                    "google_map" => $google_map) ;
            }
           
            //echo [$profil_arr];
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$profil_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }

   
    function  get_data_profil_unit_sekolah(){        
        try {                   
            $list_jenjang = $this->input->get('list_jenjang');
            $data=$this->mdl_profil->get_data_profil_unit_sekolah($list_jenjang)->result();
            $profil_arr = array();
          
            foreach ($data as $d)
            {       
                $nama = $d->nama;
                $alamat = $d->alamat;
                $telp = $d->telp;
                $no_hotline = $d->no_hotline;    
                $nama_petugas = $d->nama_petugas;           
                $visi = $d->visi;
                $misi = $d->misi;
                $photo_visi_path = $d->photo_visi_path;
                $google_map = $d->google_map;

                $profil_arr[] = array("nama" => $nama,
                                    "alamat" => $alamat,
                                    "telp" => $telp,
                                    "no_hotline" => $no_hotline,
                                    "nama_petugas" => $nama_petugas,   
                                    "google_map" => $google_map,
                                    "visi" => $visi,
                                    "misi" => $misi,
                                    "photo_visi_path" => $photo_visi_path);
            }
        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$profil_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
    }

    function get_data_tbl_testimoni() {             
        try {
            $data=$this->mdl_profil->get_data_tbl_testimoni()->result();
            $testimoni_arr = array();
            
            foreach ($data as $d)
            {       
                $testimoni_id = $d->testimoni_id;
                $pemberi_testimoni = $d->pemberi_testimoni;
                $testimoni = $d->testimoni;
              
                $testimoni_arr[] = array("testimoni_id" => $testimoni_id,
                                         "pemberi_testimoni" => $pemberi_testimoni,
                                         "testimoni" => $testimoni,
                                        );
            }
        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$testimoni_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }        
        
    }

    
    function make_query() {
        include 'conn.php';
        $query = "select pemberi_testimoni, testimoni from testimoni";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function make_slide_indicators() {
        $output = '';
        $count = 0;    
        $result = $this->make_query();
        while ($row = mysqli_fetch_array($result))
        {
            
        if ($count==0){
            $output .= '
            <button type="button" data-bs-target="#dynamic_slide_show" data-bs-slide-to="'.$count.'" class="active"></button>
            ';
        }else{
            $output .= '
            <button type="button" data-bs-target="#dynamic_slide_show" data-bs-slide-to="'.$count.'" ></button>
            ';
        }
            $count = $count + 1;    
        }
        echo  $output;
    }

    function make_slides() {
        
        $count = 0;    
        $result =  $this->make_query();
        $row_num = mysqli_num_rows($result);

        if($row_num > 0 ){

        
            $output = '
                <div id="demo_2" class="carousel-tes slide" data-bs-ride="carousel" style="background-color: rgb(200,200,200)" >                
            
                <!-- Wrapper for carousel items -->
                <div class="carousel-tes-inner">';

                    while ($row = mysqli_fetch_array($result))
                    {
                    
                        if ($count==0){
                            $output .= '
                                <div class="carousel-item active" >';          
                        }else{
                            $output .= '
                                <div class="carousel-item">';          
                        }

             
                            $output .= '
                                    <div class="carousel-caption" style="color:rgb(0, 0, 0);" ">                               
                                        <div class="ck-content">                               
                                            <p>'.$row["testimoni"].'</p>
                                        </div>
                                        <p style="font-size: 16px; line-height: 10px"><i>'.$row["pemberi_testimoni"].'</i></p>
                                    </div>    
                                    
                                </div>                
                            ';                
                    }
                    
            $output .= '
                    </div>
        
                    <button class="carousel-control-prev" type="button" data-bs-target="#demo_2" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#demo_2" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            ';
        
        
        echo $output;
        }
    }

    function get_image_ext() {
        $file_name = $this->input->get('file_name');       
        $extention = ['gif','png','jpg','jpeg'];
     
        for ($i=0; $i < count($extention) ; $i++) { 
            $file_name_to_check = './images/images_ui/'.$file_name.'.'.$extention[$i];
            $file_exists = file_exists($file_name_to_check);              
            if($file_exists>0){
                $get_file = explode('/',$file_name_to_check);
                $file_name_exists = $get_file[3];
                echo $file_name_exists;
            }                
        }           
    }

    function simpan_carousel_text() {
        try {
            $data = $this->input->post();                      
            $status = $this->mdl_profil->simpan_carousel_text($data);
            echo json_encode(array('status'=>$status, 'data'=>"", 'message'=>"")) ;

        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }

    function simpan_profil_yayasan(){        
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');                     
            $nama_yayasan = $this->input->post('txt_nama_yayasan');
            $alamat = $this->input->post('txt_alamat');
            $telp = $this->input->post('txt_telp');
            $hotline = $this->input->post('txt_hotline');            
            $google_map = $this->input->post('txt_google_map'); 
                                                     
            $sql ="CALL sp_simpan_profile_yayasan(
                    '$nama_yayasan',
                    '$alamat',
                    '$telp',
                    '$hotline',                  
                    '$username',
                    '$google_map')";          
                    
                    
            if (mysqli_query($conn, $sql)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){
                    // if ($get_temp_folder != ''){
                    //     move_uploaded_file($img_path_sejarah,$new_img_path_sejarah);
                    // }
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


    function simpan_profil_unit_sekolah(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');                     
            $list_jenjang = $this->input->post('list_jenjang');
            $nama_sekolah = $this->input->post('txt_nama_sekolah');
            $alamat = $this->input->post('txt_alamat');
            $telp = $this->input->post('txt_telp');
            $hotline = $this->input->post('txt_hotline'); 
            $nama_petugas = $this->input->post('txt_petugas');           
            $visi = $this->input->post('txt_visi'); 
            $misi = $this->input->post('txt_misi');  
            $new_path_visi = $this->input->post('uploaded_img_visimisi_unit_sekolah_path');  
            $google_map = $this->input->post('txt_google_map'); 
                       
            $sql ="call sp_simpan_profile_unit_sekolah(
                    '$list_jenjang',
                    '$nama_sekolah',
                    '$alamat',
                    '$telp',
                    '$hotline',   
                    '$nama_petugas',       
                    '$visi',
                    '$misi',
                    '$new_path_visi',
                    '$username',
                    '$google_map')";        
                    
            if (mysqli_query($conn, $sql)) {
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
                }else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                              	
                }            
            }           
            mysqli_close($conn);           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }

    
    function simpan_testimoni(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');                     
            $_status_edit = $this->input->post('_status_edit');
            $_testimoni_id = $this->input->post('_testimoni_id');            
            $pemberi_testimoni = $this->input->post('txt_pemberi_testimoni');
            $testimoni = $this->input->post('txt_testimoni');

            $query=$this->mdl_profil->simpan_testimoni($_status_edit,
                                                         $_testimoni_id,
                                                         $pemberi_testimoni,
                                                         $testimoni,                                                       
                                                         $username);            
                    
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){                    
                    if ($_status_edit=='false'){
                        $testimoni_id = $conn->insert_id;                            
                        echo json_encode(array('status'=>true,'data'=>$testimoni_id, 'message'=>'Simpan data sukses'));
                    }else{
                        $testimoni_id = $_testimoni_id;
                        echo json_encode(array('status'=>true,'data'=>$testimoni_id, 'message'=>'Simpan data sukses'));
                    }
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
                }                
            } 
            else 
            {
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

    function delete_testimoni() {
        
        include 'conn.php';
        $testimoni_id = $this->input->post('testimoni_id');
        
        $query ="
        delete  from testimoni       
        where   testimoni_id = '$testimoni_id'
        ";
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){                   
                echo json_encode(array('status'=>true,'data'=>$testimoni_id, 'message'=>'Simpan data sukses'));               
            }else{
                echo json_encode(array('status'=>true,'data'=>'0', 'message'=>'tidak ada data yang disimpan'));
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

}
