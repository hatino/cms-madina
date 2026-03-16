<?php
class Struktur_admin extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('struktur/mdl_struktur');
        check_session();
    }

    function show_struktur_admin(){        
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');          
        $this->template->load('template_admin','struktur/frm_struktur_admin',$data); 
    }

    function show_struktur_yayasan_admin() {   
        $this->template->load('template_admin','struktur/frm_struktur_yayasan_adm'); 
    }

    function get_data_kelompok_jabatan(){
        try {            
            $data=$this->mdl_struktur->get_data_kelompok_jabatan()->result();
            $kelompok_jabatan_arr = array();
                                
            foreach ($data as $d)
            {                      
                $kelompok_jabatan = $d->kelompok_jabatan;                          
                $kelompok_jabatan_arr[] = array("kelompok_jabatan" => $kelompok_jabatan);                                    
            }                  
            echo json_encode(array('status'=>true, 'data'=>[$kelompok_jabatan_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }       
    }


    function get_data_tbl_struktur() {
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->mdl_struktur->get_data_tbl_struktur($kode_jenjang)->result();
            $struktur_arr = array();
            
            foreach ($data as $d)
            {                      
                $struktur_id = $d->struktur_id;
                $kelompok_jabatan = $d->kelompok_jabatan;
                $nama_jabatan = $d->nama_jabatan;
                $nama = $d->nama;
                $no_urut = $d->no_urut;
                $img_path = $d->img_path;
                $struktur_arr[] = array("struktur_id" => $struktur_id,
                                        "kelompok_jabatan" => $kelompok_jabatan,
                                        "nama_jabatan" => $nama_jabatan,
                                        "nama" => $nama,
                                        "no_urut" => $no_urut,
                                        "img_path" => $img_path,
                                        );                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$struktur_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }   
    }

    function get_data_tbl_struktur_yayasan() {
        try {                
            include 'conn.php';         
            $sql=$this->mdl_struktur->get_data_tbl_struktur_yayasan();
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


    function simpan_struktur() {
        try {                            
            include 'conn.php';           
            $username = $this->session->userdata('username'); 
            $_status_edit = $this->input->post('_status_edit');
            $_struktur_id = $this->input->post('_struktur_id');
            $_kode_jenjang = $this->input->post('_kode_jenjang');
            $list_kelompok_jabatan = $this->input->post('list_kelompok_jabatan');
            $txt_jabatan = $this->input->post('txt_jabatan');
            $txt_nama = $this->input->post('txt_nama');
            $txt_no_urut = $this->input->post('txt_no_urut');
            $uploaded_img_struktur_path = $this->input->post('uploaded_img_struktur_path');
            
            $query=$this->mdl_struktur->simpan_struktur($_status_edit,
                                                        $_struktur_id,
                                                        $_kode_jenjang,
                                                        $list_kelompok_jabatan,
                                                        $txt_jabatan,
                                                        $txt_nama,
                                                        $txt_no_urut,
                                                        $uploaded_img_struktur_path,
                                                        $username);                    
           
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){     
                    if ($_status_edit=='false'){
                        $struktur_id = $conn->insert_id;                            
                        echo json_encode(array('status'=>true,'data'=>$struktur_id, 'message'=>'Simpan data sukses'));
                    }else{
                        $struktur_id = $_struktur_id;
                        echo json_encode(array('status'=>true,'data'=>$struktur_id, 'message'=>'Simpan data sukses'));
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


    function simpan_struktur_yayasan(){
        try {                            
            include 'conn.php';           
            $username = $this->session->userdata('username'); 
            $_status_edit = $this->input->post('_status_edit');
            $_struktur_id = $this->input->post('_struktur_id');               
            $txt_jabatan = $this->input->post('txt_jabatan');
            $txt_nama = $this->input->post('txt_nama');
            $txt_no_urut = $this->input->post('txt_no_urut');
            $uploaded_img_struktur_path = $this->input->post('uploaded_img_struktur_path');
            
            $query=$this->mdl_struktur->simpan_struktur_yayasan($_status_edit,
                                                        $_struktur_id,
                                                        $txt_jabatan,
                                                        $txt_nama,
                                                        $txt_no_urut,
                                                        $uploaded_img_struktur_path,
                                                        $username);                    
           
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){     
                    if ($_status_edit=='false'){
                        $struktur_id = $conn->insert_id;                            
                        echo json_encode(array('status'=>true,'data'=>$struktur_id, 'message'=>'Simpan data sukses'));
                    }else{
                        $struktur_id = $_struktur_id;
                        echo json_encode(array('status'=>true,'data'=>$struktur_id, 'message'=>'Simpan data sukses'));
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


    function delete_struktur() {
        include 'conn.php';
        $struktur_id = $this->input->post('struktur_id');
        $img_file_path = $this->input->post('img_file_path');

        $query ="
        delete  from struktur       
        where   struktur_id = '$struktur_id'
        ";
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){      
                if($img_file_path != '' ){
                    $file_temp = explode('/', $img_file_path);
                    $file_name = end($file_temp);     
                    $file_to_del =  './images/images_struktur/'.$file_name;                                            
                    unlink($file_to_del); 
                }                                                        
                echo json_encode(array('status'=>true,'data'=>$struktur_id, 'message'=>'Simpan data sukses'));               
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

    function delete_struktur_yayasan() {
        include 'conn.php';
        $struktur_id = $this->input->post('struktur_id');
        $img_file_path = $this->input->post('img_file_path');

        $query ="
        delete  from struktur_yayasan
        where   struktur_id = '$struktur_id'
        ";
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){      
                if($img_file_path != '' ){
                    $file_temp = explode('/', $img_file_path);
                    $file_name = end($file_temp);     
                    $file_to_del =  './images/images_struktur/'.$file_name;                                            
                    unlink($file_to_del); 
                }                                                        
                echo json_encode(array('status'=>true,'data'=>$struktur_id, 'message'=>'Simpan data sukses'));               
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

    function simpan_img_path_struktur() {
        include 'conn.php';
        $struktur_id = $this->input->post('struktur_id');
        $img_file_path = $this->input->post('img_file_path');
       
        $query = "
        update  struktur 
        set     img_path = '$img_file_path'
            ,   update_date = now()
        where   struktur_id = '$struktur_id'
        ";
        
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$struktur_id, 'message'=>'Simpan data sukses'));

    }

    function simpan_img_path_struktur_yayasan() {
        include 'conn.php';
        $struktur_id = $this->input->post('struktur_id');
        $img_file_path = $this->input->post('img_file_path');
       
        $query = "
        update  struktur_yayasan 
        set     img_path = '$img_file_path'
            ,   update_date = now()
        where   struktur_id = '$struktur_id'
        ";
        
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$struktur_id, 'message'=>'Simpan data sukses'));

    }
}
?>