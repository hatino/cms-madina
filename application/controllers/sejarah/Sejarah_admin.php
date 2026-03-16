<?php
class Sejarah_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('sejarah/mdl_sejarah');       
        check_session();
    }

    function show_sejarah_yayasan_adm() {   
        $this->template->load('template_admin','sejarah/frm_sejarah_yayasan_adm'); 
    }

    function show_sejarah_sekolah_adm() {
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');      
        $this->template->load('template_admin','sejarah/frm_sejarah_sekolah_adm',$data); 
    }
    
    function get_data_sejarah_yayasan () {
        try {     
            include 'conn.php'; 
            $sql = $this->mdl_sejarah->get_data_sejarah_yayasan();           
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
    
    function get_data_sejarah_sekolah () {
        try {     
            include 'conn.php'; 
            $kode_jenjang = $this->input->get('kode_jenjang'); 
            $sql = $this->mdl_sejarah->get_data_sejarah_sekolah($kode_jenjang);           
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

    function simpan_sejarah_yayasan(){
        try {                            
                include 'conn.php';
                $username = $this->session->userdata('username'); 
                $sejarah = $this->input->post('txt_sejarah'); 
                $new_img_path_sejarah = $this->input->post('uploaded_image_sejarah_path');  
                     
                $sql ="CALL sp_simpan_sejarah_yayasan(                    
                    '$sejarah',
                    '$new_img_path_sejarah',                    
                    '$username')";                   
                    
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

    function simpan_sejarah_sekolah(){
        try {                            
                include 'conn.php';
                $username = $this->session->userdata('username'); 
                $kode_jenjang = $this->input->post('txt_kode_jenjang'); 
                $sejarah_sekolah = $this->input->post('txt_sejarah_sekolah'); 
                $meluluskan_angkatan_ke = $this->input->post('txt_meluluskan_angkatan_ke');
                $new_img_path_sejarah_sekolah = $this->input->post('uploaded_image_sejarah_sekolah_path');  
                     
                $sql ="CALL sp_simpan_sejarah_sekolah(     
                    '$kode_jenjang',               
                    '$sejarah_sekolah',
                    '$meluluskan_angkatan_ke',
                    '$new_img_path_sejarah_sekolah',                    
                    '$username')";                   
                    
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

}

?>