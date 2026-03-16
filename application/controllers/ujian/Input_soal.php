<?php
class Input_soal extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('ujian/Mdl_input_soal');                
    }

    function show_input_soal(){
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();  
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }                       

            $mapel = $this->input->get('mapel');
            $thnajaran = $this->input->get('thnajaran');
            $kelas = $this->input->get('kelas');
            $semester = $this->input->get('semester');
            $jenis_penilaian = $this->input->get('jenis_penilaian');
            $bank_soal_id = $this->input->get('bank_soal_id');
            $status_soal = $this->input->get('status_soal');

            $data['username'] = $username; 
            $data['status_user'] = $status_user;
            $data['thnajaran'] = $thnajaran;
            $data['mapel'] = $mapel;
            $data['kelas'] = $kelas;
            $data['semester'] = $semester;
            $data['jenis_penilaian'] = $jenis_penilaian;
            $data['bank_soal_id'] = $bank_soal_id;
            $data['status_soal'] = $status_soal;

            $this->template->load('template_ujian','ujian/frm_input_soal', $data); 
        }else{
            redirect('auth/login_ujian'); 	
        }
    }

    function show_input_soal_pg(){
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result();  
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }                       

            $mapel = $this->input->get('mapel');
            $thnajaran = $this->input->get('thnajaran');
            $kelas = $this->input->get('kelas');
            $semester = $this->input->get('semester');
            $jenis_penilaian = $this->input->get('jenis_penilaian');
            $bank_soal_id = $this->input->get('bank_soal_id');
            $soal_pg_id = $this->input->get('soal_pg_id');
            $data['username'] = $username; 
            $data['status_user'] = $status_user;
            $data['thnajaran'] = $thnajaran;
            $data['mapel'] = $mapel;
            $data['kelas'] = $kelas;
            $data['semester'] = $semester;
            $data['jenis_penilaian'] = $jenis_penilaian;
            $data['bank_soal_id'] = $bank_soal_id;
            $data['soal_pg_id'] = $soal_pg_id;            

            $this->template->load('template_ujian','ujian/frm_input_soal_pg', $data); 
        }else{
            redirect('auth/login_ujian'); 	
        }
    }

    function show_input_soal_essai(){       
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $username = $_COOKIE['cms-swi-ujian'];         
            $query = $this->db->get_where('status_user', array('user_id'=>$username, 'sid'=>'cms-swi-ujian'));    
            $rs = $query->result(); 
            $status_user = '';          
            foreach($rs as $d){
                $status_user = $d->status;
            }                       

            $mapel = $this->input->get('mapel');
            $thnajaran = $this->input->get('thnajaran');
            $kelas = $this->input->get('kelas');
            $semester = $this->input->get('semester');
            $jenis_penilaian = $this->input->get('jenis_penilaian');
            $bank_soal_id = $this->input->get('bank_soal_id');
            $soal_essai_id = $this->input->get('soal_essai_id');
           
            $data['username'] = $username; 
            $data['status_user'] = $status_user;
            $data['thnajaran'] = $thnajaran;
            $data['mapel'] = $mapel;
            $data['kelas'] = $kelas;
            $data['semester'] = $semester;
            $data['jenis_penilaian'] = $jenis_penilaian;
            $data['bank_soal_id'] = $bank_soal_id;
            $data['soal_essai_id'] = $soal_essai_id;            

            $this->template->load('template_ujian','ujian/frm_input_soal_essai', $data); 
        }else{
            redirect('auth/login_ujian'); 	
        }
    }

    function get_nama_mapel(){
        $mapel = $this->input->get('mapel');
        $result = $this->Mdl_input_soal->get_nama_mapel($mapel)->result();
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")); 
    }

    function get_deskripsi_thnajaran(){        
        $thnajaran = $this->input->get('thnajaran');           
        $result = $this->Mdl_input_soal->get_deskripsi_thnajaran($thnajaran)->result();
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")); 
    }

    function get_data_kd() {
        $data = $this->input->get();              
        $result = $this->Mdl_input_soal->get_data_kd($data)->result();
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")); 
    }

    function get_data_tbl_soal() {
        $data = $this->input->get();           
        $result = $this->Mdl_input_soal->get_data_tbl_soal($data)->result();       
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")); 
    }

    function get_data_soal_dashboard() {                 
        $result = $this->Mdl_input_soal->get_data_soal_dashboard()->result();       
        echo json_encode(array('status'=>true, 'data'=>$result, 'message'=>"")); 
    }

    function get_data_tbl_penilaian_cms() {
        $req_params = $this->input->get();           
        $data=$this->Mdl_input_soal->get_data_tbl_penilaian_cms($req_params)->result();
        echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>'get data berhasil'));
    }

    function load_data_soal_pg() {
        $req = $this->input->get();           
        $data=$this->Mdl_input_soal->load_data_soal_pg($req)->result();
        echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>'get data berhasil'));
    }
    
    function load_data_soal_essai() {
        $req = $this->input->get();           
        $data=$this->Mdl_input_soal->load_data_soal_essai($req)->result();
        echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>'get data berhasil'));
    }

    function delete_soal_pg() {
        try {                            
            include 'conn.php';                                
            $data = $this->input->post();            
            $query=$this->Mdl_input_soal->delete_soal_pg($data);   
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){ 
                    echo json_encode(array('status'=>true,'data_id'=>'', 'message'=>'Hapus data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data tidak berhasil'));
                }                
            } 
            else{
                $err_code = mysqli_errno($conn);               
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                                            
            }           
            
            mysqli_close($conn);
           
        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->getMessage()));
        }
    }

    function delete_soal_essai() {
        try {                            
            include 'conn.php';                                
            $data = $this->input->post();            
            $query=$this->Mdl_input_soal->delete_soal_essai($data);   
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){ 
                    echo json_encode(array('status'=>true,'data_id'=>'', 'message'=>'Hapus data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data tidak berhasil'));
                }                
            } 
            else{
                $err_code = mysqli_errno($conn);               
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                                            
            }           
            
            mysqli_close($conn);
           
        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->getMessage()));
        }
    }

    function simpan_input_soal_pg(){       
        try {                            
            include 'conn.php';
            $username = $_COOKIE['cms-swi-ujian'];                             
            $data = $this->input->post();           
            $_soal_pg_id = $data['txt_id'];
            $data_path = $this->input->post('img_path');
            //var_dump($_POST);
            //var_dump($_FILES);
            $query=$this->Mdl_input_soal->simpan_input_soal_pg($data, $username);   
           
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){ 
                    if($_soal_pg_id==0){
                        $soal_pg_id = $conn->insert_id;   
                        //echo json_encode(array('status'=>true,'data_id'=>$soal_pg_id, 'message'=>'Simpan data sukses'));
                    }else{
                        $soal_pg_id = $_soal_pg_id;
                        //echo json_encode(array('status'=>true,'data_id'=>$_soal_pg_id, 'message'=>'Simpan data sukses'));
                    }

                    //khusus image jawaban name=img[]
                    foreach ($_FILES['img']['tmp_name'] as $i => $tmp) {
                        if ($_FILES['img']['name'][$i]!=""){
                            $test = explode('.', $_FILES["img"]["name"][$i]);
                            $ext = end($test);
                            //$idx = $i+1;
                            if($i==0){
                                $idx = 'a';
                            }elseif($i==1){
                                $idx = 'b';
                            }elseif($i==2){
                                $idx = 'c';
                            }elseif($i==3){
                                $idx = 'd';
                            }
                            
                            //if($i==0){
                            $nama_file_baru = './images/images_jawab_pg/jawaban_'.$soal_pg_id.'_'.$idx.'.'.$ext; 
                            $img_path = 'images/images_jawab_pg/jawaban_'.$soal_pg_id.'_'.$idx.'.'.$ext;
                            $source_img = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                            $source_img .= "://" . $_SERVER['HTTP_HOST'];
                            $source_img .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
                            $source_img .= 'images/images_jawab_pg/jawaban_'.$soal_pg_id.'_'.$idx.'.'.$ext;
                            //simpan path
                            if($i==0){
                                $ls_query ="
                                update  soal_pg
                                set     img_path_jawaban_a = '$img_path'
                                where   id = '$soal_pg_id'";
                                mysqli_query($conn, $ls_query);
                            }
                            if($i==1){
                                $ls_query ="
                                update  soal_pg
                                set     img_path_jawaban_b = '$img_path'
                                where   id = '$soal_pg_id'";
                                mysqli_query($conn, $ls_query);
                            }       
                            if($i==2){
                                $ls_query ="
                                update  soal_pg
                                set     img_path_jawaban_c = '$img_path'
                                where   id = '$soal_pg_id'";
                                mysqli_query($conn, $ls_query);
                            }       
                            if($i==3){
                                $ls_query ="
                                update  soal_pg
                                set     img_path_jawaban_d = '$img_path'
                                where   id = '$soal_pg_id'";
                                mysqli_query($conn, $ls_query);
                            }       
                            move_uploaded_file($tmp, $nama_file_baru);
                        }                        
                    }         
                        
                    foreach ($data_path as $j => $img_path) {
                        //hapus file temp
                        $cek_from_temp = strpos($data_path[$j],'images_temp');                
                        if($cek_from_temp > 0){       
                            $file_temp = explode('/', $img_path);
                            $file_name = end($file_temp);     
                            $file_to_del =  './images/images_temp/'.$file_name;
                            unlink($file_to_del);   
                        }     
                    }       
                    echo json_encode(array('status'=>true,'data_id'=>$soal_pg_id, 'message'=>'Simpan data sukses'));
                    
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
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

    function simpan_input_soal_essai(){       
        try {                            
            include 'conn.php';
            $username = $_COOKIE['cms-swi-ujian'];                             
            $data = $this->input->post();  
            $_soal_essai_id = $data['txt_id'];
                        
            $query=$this->Mdl_input_soal->simpan_input_soal_essai($data, $username);     
                     
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);
                if($rows>0){ 
                    if($_soal_essai_id==0||$_soal_essai_id==''){
                        $soal_essai_id = $conn->insert_id;   
                        echo json_encode(array('status'=>true,'data_id'=>$soal_essai_id, 'message'=>'Simpan data sukses'));
                    }else{
                        echo json_encode(array('status'=>true,'data_id'=>$_soal_essai_id, 'message'=>'Simpan data sukses'));
                    }
                    
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
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
    
    function simpan_penilaian() {
        try {
            $json_catch = file_get_contents('php://input');
            $data = json_decode($json_catch, true);
            $this->simpan_penilaian_detail($data);

        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        } 
    }

    public function simpan_penilaian_detail($data) {
        try {                            
            include 'conn.php';
                        
            $conn->autocommit(FALSE);   
            $rows=0;

            //data kompetensi dasar          
            if( count($data[0]) > 0 ){
                foreach($data[0] as $key => $value){
                    $stdArray[$key] = (array) $value;
                    $thnajaran_cls = $stdArray[$key]['ThnAjaranCls'];
                    $semester = $stdArray[$key]['Semester'];
                    $kelas_cls = $stdArray[$key]['KelasCls'];
                    $jenis_kd = $stdArray[$key]['JenisKD'];
                    $matapel_cls = $stdArray[$key]['MataPelCls'];
                    $no_kd = $stdArray[$key]['NoKD'];                  
                    $deskripsi_kd = $stdArray[$key]['DeskripsiKD'];
                    $deskripsi_kd =str_replace("'","''",$deskripsi_kd);
                    $seq_no = $stdArray[$key]['SeqNo'];                   
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z',' ',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z',' ',$last_update);

                    $ls_query ="
                    select  no_kd, seq_no, last_update 
                    from    kompetensi_dasar 
                    where   seq_no = '$seq_no'                    
                    ";
                    $rs_pembayaran = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_pembayaran);
                    $rows_num = mysqli_num_rows($rs_pembayaran);
                                        
                    if($rows_num > 0){
                        
                        if (substr($last_update,0,16) > substr($rs['last_update'],0,16) ){                            
                            $sql = "
                            delete  from kompetensi_dasar                       
                            where   seq_no = '$seq_no' ";                        
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into kompetensi_dasar 
                            (   thnajaran_cls,
                                semester,
                                kelas_cls,
                                jenis_kd,
                                matapel_cls,
                                no_kd,
                                deskripsi_kd,
                                seq_no,
                                register_user,
                                register_date,
                                last_user,
                                last_update,
                                transfer_date
                            )
                            values
                            (   '$thnajaran_cls',
                                '$semester',
                                '$kelas_cls',
                                '$jenis_kd',
                                '$matapel_cls',    
                                '$no_kd',
                                '$deskripsi_kd',
                                '$seq_no',          
                                '$register_user',
                                '$register_date',
                                '$last_user',
                                '$last_update',
                                CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                            )";

                            if (mysqli_query($conn, $sql)) {
                                $rows = mysqli_affected_rows($conn); 
                            }else {
                                $conn->rollBack();
                                $err_code = mysqli_errno($conn);                       
                                if($err_code==1062){
                                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                                }else{
                                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
                                }            
                            }    
                        }
                    }else{
                        $sql ="
                        insert into kompetensi_dasar 
                        (   thnajaran_cls,
                            semester,
                            kelas_cls,
                            jenis_kd,
                            matapel_cls,
                            no_kd,
                            deskripsi_kd,
                            seq_no,
                            register_user,
                            register_date,
                            last_user,
                            last_update,
                            transfer_date
                        )
                        values
                        (   '$thnajaran_cls',
                            '$semester',
                            '$kelas_cls',
                            '$jenis_kd',
                            '$matapel_cls',    
                            '$no_kd',
                            '$deskripsi_kd',
                            '$seq_no',          
                            '$register_user',
                            '$register_date',
                            '$last_user',
                            '$last_update',
                            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                        )";

                        if (mysqli_query($conn, $sql)) {
                            $rows = mysqli_affected_rows($conn); 
                        }else {
                            $conn->rollBack();
                            $err_code = mysqli_errno($conn);                       
                            if($err_code==1062){
                                echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                            }else{
                                echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
                            }            
                        }    

                    }                    
                }

            }

            $conn->commit();
			$conn->autocommit(TRUE);

            mysqli_close($conn);
            if($rows>0){        
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
            }else{
                echo json_encode(array('status'=>false,'data'=>'', 'message'=>'Proses Transfer Data Selesai'));
            }        

        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->getMessage())) ;
        } 
    }

    function simpan_img_path_soal_pg() {
        include 'conn.php';
        $soal_pg_id = $this->input->post('soal_pg_id');
        $img_file_path = $this->input->post('img_file_path');
        $status_simpan = $this->input->post('status_simpan');
       
        if($status_simpan=='hapus'){
            $img_file_path='';
        }

        $query = "
        update  soal_pg 
        set     img_path = '$img_file_path'
            ,   last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
        where   id = '$soal_pg_id'
        ";
       
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$soal_pg_id, 'message'=>$status_simpan.' image sukses'));
    }
    
    function simpan_img_path_soal_essai() {
        include 'conn.php';
        $soal_essai_id = $this->input->post('soal_essai_id');
        $img_file_path = $this->input->post('img_file_path');
        $status_simpan = $this->input->post('status_simpan');
       
        if($status_simpan=='hapus'){
            $img_file_path='';
        }

        $query = "
        update  soal_essai 
        set     img_path = '$img_file_path'
            ,   last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
        where   id = '$soal_essai_id'
        ";
       
        mysqli_query($conn, $query);        
        mysqli_close($conn);
        echo json_encode(array('status'=>true,'data'=>$soal_essai_id, 'message'=>$status_simpan.' image sukses'));
    }

    function hapus_img_jawaban(){
        include 'conn.php';
        $soal_pg_id = $this->input->post('soal_pg_id');
        $img_file_path = $this->input->post('img_file_path');
        $idx = $this->input->post('idx');
                     
        $query = "
        update  soal_pg 
        set     img_path_jawaban_".$idx." = ''
            ,   last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
        where   id = '$soal_pg_id' ";

        // if($idx=='a'){
        //     $query = "
        //     update  soal_pg 
        //     set     img_path_jawaban_a = ''
        //         ,   last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
        //     where   id = '$soal_pg_id' ";
        // }
        // if($idx=='b'){
        //     $query = "
        //     update  soal_pg 
        //     set     img_path_jawaban_b = ''
        //         ,   last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
        //     where   id = '$soal_pg_id' ";
        // }
        // if($idx=='c'){
        //     $query = "
        //     update  soal_pg 
        //     set     img_path_jawaban_c = ''
        //         ,   last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
        //     where   id = '$soal_pg_id' ";
        // }
        // if($idx=='d'){
        //     $query = "
        //     update  soal_pg 
        //     set     img_path_jawaban_d = '$img_file_path'
        //         ,   last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
        //     where   id = '$soal_pg_id' ";
        // }
                   
        mysqli_query($conn, $query);        
        mysqli_close($conn);

        if ($img_file_path){                      
            $cek_from_temp = strpos($img_file_path,'images_jawab_pg');                
            if($cek_from_temp > 0){       
                $file_temp = explode('/', $img_file_path);
                $file_name = end($file_temp);     
                $file_to_del =  './images/images_jawab_pg/'.$file_name;
                unlink($file_to_del);   
            }     
        }

        echo json_encode(array('status'=>true,'data'=>$soal_pg_id, 'message'=>'Hapus image berhasil'));
    }

    function get_jml_soal(){
        
    }

}

?>