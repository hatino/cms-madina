<?php

use phpDocumentor\Reflection\Types\This;

class Kegiatan_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('kegiatan/mdl_kegiatan');       
        check_session();
    }
    
    function show_kegiatan_admin() {            
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template_admin','kegiatan/frm_kegiatan_admin',$data);   
    }
       
    function get_data_tbl_kegiatan() {
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->mdl_kegiatan->get_data_tbl_kegiatan($kode_jenjang)->result();
            $kegiatan_arr = array();
           
            foreach ($data as $d)
            {                      
                $kegiatan_id = $d->kegiatan_id;
                $nama_kegiatan = $d->nama_kegiatan;
                $tgl_kegiatan = $d->tgl_kegiatan;
                $deskripsi = $d->deskripsi;
                $img_path = $d->img_path;
                $kegiatan_arr[] = array("kegiatan_id" => $kegiatan_id,
                                        "nama_kegiatan" => $nama_kegiatan,
                                        "tgl_kegiatan" => $tgl_kegiatan,
                                        "deskripsi" => $deskripsi,
                                        "img_path" => $img_path,
                                        );                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$kegiatan_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }

       
    function simpan_kegiatan(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username'); 
            $_status_edit = $this->input->post('_status_edit');
            $_kegiatan_id = $this->input->post('_kegiatan_id');
            $_kode_jenjang = $this->input->post('_kode_jenjang');
            $txt_nama_kegiatan = $this->input->post('txt_nama_kegiatan');
            $dt_tgl_kegiatan = $this->input->post('dt_tgl_kegiatan');
            $txt_deskripsi_kegiatan = $this->input->post('txt_deskripsi_kegiatan');
            $uploaded_img_kegiatan_path = $this->input->post('uploaded_img_kegiatan_path');

            $txt_nama_kegiatan = str_replace("'","''",$txt_nama_kegiatan);
            $txt_deskripsi_kegiatan = str_replace("'","''",$txt_deskripsi_kegiatan);
            
            $query=$this->mdl_kegiatan->simpan_kegiatan($_status_edit,
                                                        $_kegiatan_id,
                                                        $_kode_jenjang,
                                                        $txt_nama_kegiatan,
                                                        $dt_tgl_kegiatan,
                                                        $txt_deskripsi_kegiatan,
                                                        $uploaded_img_kegiatan_path,
                                                        $username);                    
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){     
                    if ($_status_edit=='false'){
                        $kegiatan_id = $conn->insert_id;                            
                        echo json_encode(array('status'=>true,'data'=>$kegiatan_id, 'message'=>'Simpan data sukses'));
                    }else{
                        $kegiatan_id = $_kegiatan_id;
                        echo json_encode(array('status'=>true,'data'=>$kegiatan_id, 'message'=>'Simpan data sukses'));
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
        $kegiatan_id = $this->input->post('kegiatan_id');
        $img_file_path = $this->input->post('img_file_path');
       
        $query = "
        update  kegiatan 
        set     img_path = '$img_file_path'
            ,   update_date = now()
        where   kegiatan_id = '$kegiatan_id'
        ";
        
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$kegiatan_id, 'message'=>'Simpan data sukses'));

    }

    function delete_kegiatan() {
        include 'conn.php';
        $kegiatan_id = $this->input->post('kegiatan_id');
        $img_file_path = $this->input->post('img_file_path');

        $query ="
        delete  from kegiatan       
        where   kegiatan_id = '$kegiatan_id'
        ";
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){        
                $file_temp = explode('/', $img_file_path);
                $file_name = end($file_temp);     
                $file_to_del =  './images/images_kegiatan/'.$file_name;                                            
                unlink($file_to_del);                                         
                echo json_encode(array('status'=>true,'data'=>$kegiatan_id, 'message'=>'Simpan data sukses'));               
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