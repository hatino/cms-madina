<?php
class Visi_misi_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('visimisi/mdl_visi_misi');       
        check_session();
    }

    function show_visi_misi_yayasan_admin() {   
        $this->template->load('template_admin','visimisi/frm_visi_misi_yayasan_adm'); 
    }
   
    function get_data_visimisi_yayasan () {
        try {     
            include 'conn.php'; 
            $sql = $this->mdl_visi_misi->get_data_visimisi_yayasan();           
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

    function simpan_visimisi_yayasan(){
        try {                            
                include 'conn.php';
                $username = $this->session->userdata('username'); 
                $visi = $this->input->post('txt_visi');
                $misi = $this->input->post('txt_misi'); 
                $new_img_path_visimisi = $this->input->post('uploaded_image_visimisi_path');  
                     
                $sql ="CALL sp_simpan_visimisi_yayasan(                    
                    '$visi',
                    '$misi',
                    '$new_img_path_visimisi',                    
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