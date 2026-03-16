
<?php
class Ekstrakurikuler_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('ekstrakurikuler/Mdl_ekstrakurikuler'); 
        check_session();
    }

    function show_ekstrakurikuler_admin() {            
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template_admin','ekstrakurikuler/frm_ekstrakurikuler_admin', $data);   
    }

    function get_data_tbl_ekstrakurikuler() {
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->Mdl_ekstrakurikuler->get_data_tbl_ekstrakurikuler($kode_jenjang)->result();
            $ekstrakurikuler_arr = array();
           
            foreach ($data as $d)
            {                      
                $ekstrakurikuler_id = $d->ekstrakurikuler_id;
                $nama_ekstrakurikuler = $d->nama_ekstrakurikuler;             
                $img_path = $d->img_path;
                $ekstrakurikuler_arr[] = array("ekstrakurikuler_id" => $ekstrakurikuler_id,
                                        "nama_ekstrakurikuler" => $nama_ekstrakurikuler,                                      
                                        "img_path" => $img_path,
                                        );                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$ekstrakurikuler_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }


    function simpan_ekstrakurikuler(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username'); 
            $_status_edit = $this->input->post('_status_edit');
            $_ekstrakurikuler_id = $this->input->post('_ekstrakurikuler_id');
            $_kode_jenjang = $this->input->post('_kode_jenjang');
            $txt_nama_ekstrakurikuler = $this->input->post('txt_nama_ekstrakurikuler');           
            $uploaded_img_ekstrakurikuler_path = $this->input->post('uploaded_img_ekstrakurikuler_path');

            //print_r($this->input->post());return;
            
            $query=$this->Mdl_ekstrakurikuler->simpan_ekstrakurikuler($_status_edit,
                                                        $_ekstrakurikuler_id,
                                                        $_kode_jenjang,
                                                        $txt_nama_ekstrakurikuler,                                                     
                                                        $uploaded_img_ekstrakurikuler_path,
                                                        $username);                    
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){     
                    if ($_status_edit=='false'){
                        $ekstrakurikuler_id = $conn->insert_id;                            
                        echo json_encode(array('status'=>true,'data'=>$ekstrakurikuler_id, 'message'=>'Simpan data sukses'));
                    }else{
                        $ekstrakurikuler_id = $_ekstrakurikuler_id;
                        echo json_encode(array('status'=>true,'data'=>$ekstrakurikuler_id, 'message'=>'Simpan data sukses'));
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
        $ekstrakurikuler_id = $this->input->post('ekstrakurikuler_id');
        $img_file_path = $this->input->post('img_file_path');
       
        $query = "
        update  ekstrakurikuler 
        set     img_path = '$img_file_path'
            ,   update_date = now()
        where   ekstrakurikuler_id = '$ekstrakurikuler_id'
        ";
        
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$ekstrakurikuler_id, 'message'=>'Simpan data sukses'));
    }

    function delete_ekstrakurikuler() {
        include 'conn.php';
        $ekstrakurikuler_id = $this->input->post('ekstrakurikuler_id');
        $img_file_path = $this->input->post('img_file_path');

        $query ="
        delete  from ekstrakurikuler       
        where   ekstrakurikuler_id = '$ekstrakurikuler_id'
        ";
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){        
                $file_temp = explode('/', $img_file_path);
                $file_name = end($file_temp);     
                $file_to_del =  './images/images_ekstrakurikuler/'.$file_name;                                            
                unlink($file_to_del);                                         
                echo json_encode(array('status'=>true,'data'=>$ekstrakurikuler_id, 'message'=>'Simpan data sukses'));               
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
    }


}
?>