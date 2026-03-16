
<?php
class Running_text extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('master/mdl_running_text'); 
    }

    function show_running_text(){        
        $this->template->load('template_admin','master/frm_running_text');            
    }

    function get_data_running_text() {
        $data = $this->mdl_running_text->get_data_running_text()->result();  
        echo json_encode(array('status'=>true,'data'=>$data, 'message'=>''));
    }

    // function simpan_running_text() {
    //     try {
    //         include 'conn.php';
    //         $username = $this->session->userdata('username');  
    //         $data = $this->input->post();
    //         $cek_data_exists = $this->mdl_running_text->cek_data_exists($data)->result();            
    //         foreach ($cek_data_exists as $d){                      
    //             $jml = $d->jml;   
    //         }           
    //         $query = $this->mdl_running_text->simpan_running_text($data, $jml, $username);
    //         if (mysqli_query($conn, $query)) {
    //             $rows = mysqli_affected_rows($conn);                
    //             if($rows>0){                    
    //                 echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
    //             }else{
    //                 echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
    //             }                
    //         } 
    //         else 
    //         {
    //             $err_code = mysqli_errno($conn);
    //             if($err_code==1062){
    //                 echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
    //             }
    //             else{
    //                 echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
    //             }            
    //         }
           
    //         mysqli_close($conn);            

    //     } catch (customException $e) {
    //         echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
    //     }
    // }

    function simpan_running_text_cms() {
        try {
            include 'conn.php';
            $username = $this->session->userdata('username');  
            $data = $this->input->post();
            $cek_data_exists = $this->mdl_running_text->cek_data_exists($data)->result();            
            foreach ($cek_data_exists as $d){                      
                $jml = $d->jml;   
            }           
            $query = $this->mdl_running_text->simpan_running_text_cms($data, $jml, $username);
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
}
?>