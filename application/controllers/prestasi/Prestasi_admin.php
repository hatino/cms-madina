
<?php
class Prestasi_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('prestasi/Mdl_prestasi'); 
        check_session();
    }

    function show_prestasi_admin() {            
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template_admin','prestasi/frm_prestasi_admin', $data);   
    }

    function get_data_tbl_prestasi()  {
        try {            
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data=$this->Mdl_prestasi->get_data_tbl_prestasi($kode_jenjang)->result();
            $prestasi_arr = array();
           
            foreach ($data as $d)
            {                      
                $prestasi_id = $d->prestasi_id;
                $group_cls = $d->group_cls;
                $tgl_prestasi = $d->tgl_prestasi;    
                $nama_siswa = $d->nama_siswa; 
                $jenis_prestasi = $d->jenis_prestasi;    
                $peringkat = $d->peringkat;
                $tingkat_lomba = $d->tingkat_lomba;
                $tempat_kegiatan = $d->tempat_kegiatan;
                $img_path = $d->img_path;
                $prestasi_arr[] = array("prestasi_id" => $prestasi_id,
                                        "group_cls" => $group_cls,
                                        "tgl_prestasi" => $tgl_prestasi,   
                                         "nama_siswa" => $nama_siswa,
                                        "jenis_prestasi" => $jenis_prestasi, 
                                        "jenis_prestasi" => $jenis_prestasi,
                                        "peringkat" => $peringkat,      
                                        "tingkat_lomba" => $tingkat_lomba,
                                        "tempat_kegiatan" => $tempat_kegiatan,
                                        "img_path" => $img_path
                                        );                                    
            }        
            // encoding array to json format
            echo json_encode(array('status'=>true, 'data'=>[$prestasi_arr], 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }  
    }

    function simpan_prestasi(){
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username'); 
            $_status_edit = $this->input->post('_status_edit');
            $_prestasi_id = $this->input->post('_prestasi_id');
            $_kode_jenjang = $this->input->post('_kode_jenjang');
            $dt_tgl_prestasi = $this->input->post('dt_tgl_prestasi');
            $txt_nama_siswa = $this->input->post('txt_nama_siswa');    
            $txt_jenis_prestasi = $this->input->post('txt_jenis_prestasi');            
            $txt_peringkat = $this->input->post('txt_peringkat');
            $txt_tingkat_lomba = $this->input->post('txt_tingkat_lomba');    
            $txt_tempat_kegiatan = $this->input->post('txt_tempat_kegiatan');      
            $uploaded_img_prestasi_path = $this->input->post('uploaded_img_prestasi_path');
            
            $query=$this->Mdl_prestasi->simpan_prestasi($_status_edit,
                                                        $_prestasi_id,
                                                        $_kode_jenjang,                                                       
                                                        $dt_tgl_prestasi,
                                                        $txt_nama_siswa,
                                                        $txt_jenis_prestasi,
                                                        $txt_peringkat,
                                                        $txt_tingkat_lomba,
                                                        $txt_tempat_kegiatan,
                                                        $uploaded_img_prestasi_path,
                                                        $username);                    
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){     
                    if ($_status_edit=='false'){
                        $prestasi_id = $conn->insert_id;                            
                        echo json_encode(array('status'=>true,'data'=>$prestasi_id, 'message'=>'Simpan data sukses'));
                    }else{
                        $prestasi_id = $_prestasi_id;
                        echo json_encode(array('status'=>true,'data'=>$prestasi_id, 'message'=>'Simpan data sukses'));
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
        $prestasi_id = $this->input->post('prestasi_id');
        $img_file_path = $this->input->post('img_file_path');
       
        $query = "
        update  prestasi 
        set     img_path = '$img_file_path'
            ,   update_date = now()
        where   prestasi_id = '$prestasi_id'
        ";
        
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$prestasi_id, 'message'=>'Simpan data sukses'));
    }

    function delete_prestasi() {
        include 'conn.php';
        $prestasi_id = $this->input->post('prestasi_id');
        $img_file_path = $this->input->post('img_file_path');

        $query ="
        delete  from prestasi     
        where   prestasi_id = '$prestasi_id'
        ";
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){        
                $file_temp = explode('/', $img_file_path);
                $file_name = end($file_temp);     
                $file_to_del =  './images/images_prestasi/'.$file_name;                                            
                unlink($file_to_del);                                         
                echo json_encode(array('status'=>true,'data'=>$prestasi_id, 'message'=>'Simpan data sukses'));               
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

    function delete_image_prestasi() {
        try {
            $img_file_path = $this->input->post('file_path');  
            $prestasi_id = $this->input->post('prestasi_id');  
            $file_temp = explode('/', $img_file_path);
            $file_name = end($file_temp);     
            $cek_file_temp = strpos($img_file_path,"images_temp");              
            $cek_file_prestasi = strpos($img_file_path,"images_prestasi");           

            if ($cek_file_temp != ''){
                $file_to_del =  './images/images_temp/'.$file_name;    
                unlink($file_to_del); 
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'file_temp'));
            }
            if ($cek_file_prestasi != ''){
                $file_to_del =  './images/images_prestasi/'.$file_name;    
                unlink($file_to_del); 

                include 'conn.php';              
            
                if ($prestasi_id > 0){
                    $query = "
                    update  prestasi 
                    set     img_path = ''
                        ,   update_date = now()
                    where   prestasi_id = '$prestasi_id'
                    ";                   
                    mysqli_query($conn, $query);
                }               
                
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'file_prestasi'));                   
            }           
            
         } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }
}
?>