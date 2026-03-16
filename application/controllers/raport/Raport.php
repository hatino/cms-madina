<?php
class Raport extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('raport/Mdl_raport');  
        $this->load->model('mdl_user');
        // check_session();       
    }

    function show_biodata_siswa(){
        $this->template->load('template_siswa','raport/frm_biodata_siswa'); 
    }

    function show_raport(){
        if(isset($_COOKIE['cms-swi-user'])) {
            $username = $_COOKIE['cms-swi-user'];         
            $data['username'] = $username;
            $hasil = $this->mdl_user->cek_user($username);
            $data['status_admin'] = $hasil;
            $this->template->load('template_siswa','raport/frm_raport', $data); 
        }else{
            redirect('auth/login'); 	
        }
    }

    function get_thn_ajaran() {
        $data = $this->Mdl_raport->get_thn_ajaran()->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_jenjang_pendidikan() {
        $thnajaran = $this->input->get('thnajaran'); 
        $data = $this->Mdl_raport->get_jenjang_pendidikan($thnajaran)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_kelas() {
        $thnajaran = $this->input->get('thnajaran');
        $jenjang = $this->input->get('jenjang'); 
        $data = $this->Mdl_raport->get_kelas($thnajaran, $jenjang)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }
    
    function get_kelas_by_user() {
        $nis = $this->input->get('nis'); 
        $data = $this->Mdl_raport->get_kelas_by_user($nis)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_subkelas() {
        $thnajaran = $this->input->get('thnajaran');
        $jenjang = $this->input->get('jenjang'); 
        $kelas = $this->input->get('kelas'); 
        $data = $this->Mdl_raport->get_subkelas($thnajaran, $jenjang, $kelas)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_nama_siswa() {
        $req_data = $this->input->get(); 
        $data = $this->Mdl_raport->get_nama_siswa($req_data)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }
    
    function get_nama_siswa_by_user() {
        $req_data = $this->input->get(); 
        $data = $this->Mdl_raport->get_nama_siswa_by_user($req_data)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_data_tbl_raport() {
        $req_data = $this->input->get(); 
        $data = $this->Mdl_raport->get_data_tbl_raport($req_data)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_data_tbl_raport_cms() {
        $req_params = $this->input->get();
        //$thnajaran_cls = $req_params["thnajaran"];        
        $data=$this->Mdl_raport->get_data_raport($req_params)->result();
        echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>'get data berhasil'));
    }

    function delete_raport() {

        include 'conn.php';
        // $data = $this->input->post();
        // var_dump($data);

        $json_catch = file_get_contents('php://input');
        $data = json_decode($json_catch, true);
        
        $thnajaran_cls = $data['thnajaran'];
        $jenjang = $data['jenjang'];
        $kelas = $data['kelas'];
        $subkelas = $data['subkelas'];
        $semester = $data['semester'];
        $jenis_penilaian = $data['jenis_penilaian'];
        
        $query="
            delete  from ";
        if($jenis_penilaian=='PTS'){
            $query .="raport_siswa_detail"; 
        }else{
            $query .="raport_pas";
        }
        $query .="
            where   thnajaran_cls= '$thnajaran_cls' 
            and     semester = '$semester'
            and     kelas_cls = '$kelas' ";
        if($subkelas!=''){
            $query .="        
            and     subkelas_cls = '$subkelas' ";
        }

        //execute
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn); 
        }else {           
            $err_code = mysqli_errno($conn);          
            if($err_code==1062){
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
            }
            else{
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
            }            
        }           
        
        mysqli_close($conn);
        if($rows>0){        
            echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data sukses'));
        }else{
            echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data tidak berhasil'));
        }                   
    }

    function simpan_raport(){
        try {
            $json_catch = file_get_contents('php://input');
            $data = json_decode($json_catch, true);           
            // var_dump($data);
            $this->simpan_raport_detail($data);

        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        } 
    }

    public function simpan_raport_detail($data) {
        try {                            
            include 'conn.php';
                        
            $conn->autocommit(FALSE);   

            //data raport          
            if( count($data[0]) > 0 ){
                foreach($data[0] as $key => $value)
                {
                    $stdArray[$key] = (array) $value;  
                    $nis = $stdArray[$key]['NIS'];  
                    $nama = $stdArray[$key]['nama'];
                    $nama = str_replace("'","''",$nama);
                    $thnajaran_cls = $stdArray[$key]['ThnAjaranCls'];
                    $kelas_cls = $stdArray[$key]['KelasCls'];
                    $subkelas_cls = $stdArray[$key]['SubKelasCls'];
                    $semester = $stdArray[$key]['Semester'];
                    $aspek_jenis_kd = $stdArray[$key]['Aspek_JenisKD'];
                    $matapel_cls = $stdArray[$key]['MataPelCls'];
                    $kkm = $stdArray[$key]['KKM'];
                    $nilai = $stdArray[$key]['Nilai'];
                    $predikat = $stdArray[$key]['Predikat'];
                    $deskripsi = $stdArray[$key]['Deskripsi'];
                    $deskripsi = str_replace("'","''",$deskripsi);
                    $terbilang = $stdArray[$key]['Terbilang'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z','',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z','',$last_update);
                    $jenis_penilaian = $stdArray[$key]['JenisPenilaian'];
                
                    if($jenis_penilaian=='PTS'){                        
                        $sql="                        
                        insert into raport_siswa_detail(
                            nis,
                            nama,
                            thnajaran_cls,
                            kelas_cls,
                            subkelas_cls,
                            semester,                        
                            matapel_cls,
                            kkm,
                            nilai,
                            terbilang,
                            register_user,
                            register_date,
                            last_user,
                            last_update,
                            transfer_date
                        )
                        values
                        (
                            '$nis',
                            '$nama',
                            '$thnajaran_cls',
                            '$kelas_cls',
                            '$subkelas_cls',
                            '$semester',                        
                            '$matapel_cls',
                            '$kkm',
                            '$nilai',
                            '$terbilang',                        
                            '$register_user',
                            '$register_date',
                            '$last_user',
                            '$last_update',                            
                            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                        )
                        ";

                    }else{

                        $sql="                        
                        insert into raport_pas(
                            nis,
                            nama,
                            thnajaran_cls,
                            kelas_cls,
                            subkelas_cls,
                            semester,
                            aspek_jenis_kd,
                            matapel_cls,
                            kkm,
                            nilai,
                            predikat,
                            deskripsi,
                            register_user,
                            register_date,
                            last_user,
                            last_update,
                            transfer_date
                        )
                        values
                        (
                            '$nis',
                            '$nama',
                            '$thnajaran_cls',
                            '$kelas_cls',
                            '$subkelas_cls',
                            '$semester',
                            '$aspek_jenis_kd',
                            '$matapel_cls',
                            '$kkm',
                            '$nilai',
                            '$predikat',
                            '$deskripsi',
                            '$register_user',
                            '$register_date',
                            '$last_user',
                            '$last_update',
                            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                        )
                        ";

                    }               

                           
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
            
            //data master siswa
            if( count($data[1]) > 0 ){
                foreach($data[1] as $key => $value){
                    $stdArray[$key] = (array) $value;  
                    $nis = $stdArray[$key]['NIS'];  
                    $nama = $stdArray[$key]['Nama'];
                    $nama = str_replace("'","''",$nama);
                    $nama_ayah = $stdArray[$key]['NamaAyah'];
                    $nama_ayah = str_replace("'","''",$nama_ayah);
                    $nama_ibu = $stdArray[$key]['NamaIbu'];
                    $nama_ibu = str_replace("'","''",$nama_ibu);
                    $no_wa = $stdArray[$key]['No_WA'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z','',$register_date);
                    $last_user = $stdArray[$key]['Last_User'];
                    $last_update = $stdArray[$key]['Last_Update'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z',' ',$last_update);

                    $ls_query ="
                    select nis, last_update from master_siswa 
                    where   nis = '$nis'
                    ";
                    $rs_siswa = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_siswa);
                    $rows_num = mysqli_num_rows($rs_siswa);
                                        
                    if($rows_num > 0){
                        if ($nis == $rs['nis'] && substr($last_update,0,16) < substr($rs['last_update'],0,16) ){                            
                            $sql = "
                            delete from master_siswa                       
                            where   nis = '$nis' ";                        
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into master_siswa 
                            (   nis,	
                                nama,	
                                nama_ayah,	
                                nama_ibu,
                                no_wa,	
                                register_user,
                                register_date,
                                last_user,
                                last_update,	
                                transfer_date
                            )
                            values
                            (   '$nis',
                                '$nama',
                                '$nama_ayah',
                                '$nama_ibu',
                                '$no_wa',
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
                        $sql = "
                        insert into master_siswa 
                        (   nis,	
                            nama,	
                            nama_ayah,	
                            nama_ibu,
                            no_wa,	
                            register_user,
                            register_date,
                            last_user,
                            last_update,	
                            transfer_date
                        )
                        values
                        (   '$nis',
                            '$nama',
                            '$nama_ayah',
                            '$nama_ibu',
                            '$no_wa',
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

            //data master thn ajaran
            if( count($data[2]) > 0 ){
                foreach($data[2] as $key => $value){
                    $stdArray[$key] = (array) $value;  
                    $thnajaran_cls = $stdArray[$key]['ThnAjaranCls'];
                    $deskripsi = $stdArray[$key]['Description'];
                    $tgl_mulai = $stdArray[$key]['TglMulai'];
                    $tgl_mulai = str_replace('T',' ',$tgl_mulai);
                    $tgl_mulai = str_replace('Z',' ',$tgl_mulai);
                    $tgl_selesai = $stdArray[$key]['TglSelesai'];
                    $tgl_selesai = str_replace('T',' ',$tgl_selesai);
                    $tgl_selesai = str_replace('Z',' ',$tgl_selesai);
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z','',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];                    
                    $last_update = $stdArray[$key]['LastUpdate'];   
                    // $last_update = str_replace('T',' ',$last_update);
                    // $last_update = str_replace('Z','',$last_update);                

                    $ls_query ="
                    select thnajaran_cls, last_update, deskripsi 
                    from   master_thnajaran 
                    where  thnajaran_cls = '$thnajaran_cls'
                    ";
                    $rs_thnajaran = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_thnajaran);
                    $rows_num = mysqli_num_rows($rs_thnajaran);                     
                    
                    if($rows_num > 0){
                        if ($thnajaran_cls == $rs['thnajaran_cls'] && $deskripsi != $rs['deskripsi'] ){
                            $sql = "
                            update  from master_thnajaran  
                            set     deskirpsi = '$deskripsi'
                                ,   tgl_mulai = '$tgl_mulai'
                                ,   tgl_selesai = '$tgl_selesai'
                            where   thnajaran_cls = '$thnajaran_cls' ";                        
                            // mysqli_query($conn, $sql);

                            // $sql = "
                            // insert into master_thnajaran 
                            // (   thnajaran_cls,	
                            //     deskripsi,	
                            //     tgl_mulai,	
                            //     tgl_selesai,                               
                            //     register_user,
                            //     register_date,
                            //     last_user,
                            //     last_update,
                            //     transfer_date
                            // )
                            // values
                            // (   '$thnajaran_cls',
                            //     '$deskripsi',
                            //     '$tgl_mulai',
                            //     '$tgl_selesai',                              
                            //     '$register_user',
                            //     '$register_date',
                            //     '$last_user',   
                            //     '$last_update',                         
                            //     CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                            // )";
                              
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
                        $sql = "
                        insert into master_thnajaran 
                        (   thnajaran_cls,	
                            deskripsi,	
                            tgl_mulai,	
                            tgl_selesai,                               
                            register_user,
                            register_date,
                            last_user,
                            last_update,	
                            transfer_date
                        )
                        values
                        (   '$thnajaran_cls',
                            '$deskripsi',
                            '$tgl_mulai',
                            '$tgl_selesai',                              
                            '$register_user',
                            '$register_date',";
                            
                        if($last_user==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $last_user,";
                        }
                        if($last_update==null){  
                            $sql .= "
                            NULL,";      
                        }else{
                            $last_update = str_replace('T',' ',$last_update);
                            $last_update = str_replace('Z',' ',$last_update);
                            $sql .= "
                            '$last_update',";
                        }
                        
                        $sql .= "
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

            //mapel per kelas
            if( count($data[3]) > 0 ){
                foreach ($data[3] as $key => $value) {
                    $stdArray[$key] = (array) $value;
                    $thnajaran_cls =  $stdArray[$key]['ThnAjaranCls'];
                    $kelas_cls = $stdArray[$key]['KelasCls'];

                    $ls_query ="
                    select  thnajaran_cls, kelas_cls, matapel_cls, last_update 
                    from    matapel_kelas 
                    where   thnajaran_cls = '$thnajaran_cls'
                    and     kelas_cls = '$kelas_cls'                    
                    ";
                    $rs_mapel = mysqli_query($conn, $ls_query);
                    $rs = mysqli_fetch_assoc($rs_mapel);
                    $rows_num = mysqli_num_rows($rs_mapel);
                    
                    if($rows_num > 0){
                        $ls_query ="
                        delete  from    matapel_kelas 
                        where   thnajaran_cls = '$thnajaran_cls'
                        and     kelas_cls = '$kelas_cls'
                        ";
                        mysqli_query($conn, $ls_query);
                    }                   
                    break;
                }

                foreach ($data[3] as $key => $value) {
                    $stdArray[$key] = (array) $value;
                    $thnajaran_cls =  $stdArray[$key]['ThnAjaranCls'];
                    $kelas_cls = $stdArray[$key]['KelasCls'];
                    $matapel_cls = $stdArray[$key]['MataPelCls'];
                    $no_urut = $stdArray[$key]['NoUrut'];
                    $seq_no = $stdArray[$key]['SeqNo'];
                    $muatan_mapel = $stdArray[$key]['Muatan_MAPEL'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z','',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z','',$last_update);
                   
                    $sql = "
                    insert into matapel_kelas 
                    (   thnajaran_cls,	
                        kelas_cls,	
                        matapel_cls,	
                        no_urut, 
                        seq_no,
                        muatan_mapel,                              
                        register_user,
                        register_date,
                        last_user,
                        last_update,	
                        transfer_date
                    )
                    values
                    (   '$thnajaran_cls',
                        '$kelas_cls',
                        '$matapel_cls',
                        '$no_urut',
                        '$seq_no',
                        '$muatan_mapel',                                                  
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

            //master matapel_cls
            if( count($data[4]) > 0 ){
                foreach ($data[4] as $key => $value) {
                    $stdArray[$key] = (array) $value;
                    $matapel_cls = $stdArray[$key]['MataPelCls'];
        	        $deskripsi = $stdArray[$key]['Description'];
                    $deskripsi = str_replace("'","''",$deskripsi);
                	$deskripsi_smp = $stdArray[$key]['Description_SMP'];
                    $deskripsi_smp = str_replace("'","''",$deskripsi_smp);
                    // $stat_not_aktif = $stdArray[$key]['stat_not_aktif'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z','',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z','',$last_update);

                    $ls_query ="
                    select  matapel_cls, last_update 
                    from    matapel_cls 
                    where   matapel_cls = '$matapel_cls'
                    ";
                    $rs_siswa = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_siswa);
                    $rows_num = mysqli_num_rows($rs_siswa);
                                        
                    if($rows_num > 0){
                        if ($matapel_cls == $rs['matapel_cls'] && substr($last_update,0,16) > substr($rs['last_update'],0,16) ){                            
                            $sql = "
                            delete from matapel_cls                       
                            where   matapel_cls = '$matapel_cls' ";                        
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into matapel_cls 
                            (   matapel_cls,	
                                deskripsi,	
                                deskripsi_smp,	
                                register_user,
                                register_date,
                                last_user,
                                last_update,	
                                transfer_date
                            )
                            values
                            (   '$matapel_cls',
                                '$deskripsi',
                                '$deskripsi_smp',                               
                                '$register_user',
                                '$register_date',";
                               
                            if($last_user==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $last_user,";
                            }
                            if($last_update==null){  
                                $sql .= "
                                NULL,";      
                            }else{
                                $last_update = str_replace('T',' ',$last_update);
                                $last_update = str_replace('Z',' ',$last_update);
                                $sql .= "
                                '$last_update',";
                            }
                                $sql .= "
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
                        insert into matapel_cls 
                        (   matapel_cls,	
                            deskripsi,	
                            deskripsi_smp,	
                            register_user,
                            register_date,
                            last_user,
                            last_update,	
                            transfer_date
                        )
                        values
                        (   '$matapel_cls',
                            '$deskripsi',
                            '$deskripsi_smp',                               
                            '$register_user',
                            '$register_date',";

                            if($last_user==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $last_user,";
                            }
                            if($last_update==null){  
                                $sql .= "
                                NULL,";      
                            }else{
                                $last_update = str_replace('T',' ',$last_update);
                                $last_update = str_replace('Z',' ',$last_update);
                                $sql .= "
                                '$last_update',";
                            }
                                $sql .= "
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

            //kriteria tuntas
            if( count($data[5]) > 0 ){
                foreach ($data[5] as $key => $value) {
                    $stdArray[$key] = (array) $value;
                    $thnajaran_cls = $stdArray[$key]['ThnAjaranCls'];
                    $kelas_cls = $stdArray[$key]['KelasCls'];
                    $matapel_cls = $stdArray[$key]['MataPelCls'];
                    $nilai_kkm = $stdArray[$key]['NilaiKKM'];
                    $panjang_interval = $stdArray[$key]['PanjangInterval'];
                    $a_min = $stdArray[$key]['A_Min'];
                    $a_max = $stdArray[$key]['A_Max'];
                    $b_min = $stdArray[$key]['B_Min'];
                    $b_max = $stdArray[$key]['B_Max'];
                    $c_min = $stdArray[$key]['C_Min'];
                    $c_max = $stdArray[$key]['C_Max'];
                    $d_min = $stdArray[$key]['D_Min'];
                    $d_max = $stdArray[$key]['D_Max'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z','',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z','',$last_update);

                    $ls_query ="
                    select  thnajaran_cls, kelas_cls, matapel_cls, last_update 
                    from    kriteria_tuntas 
                    where   thnajaran_cls = '$thnajaran_cls'
                    and     matapel_cls = '$matapel_cls'
                    and     kelas_cls = '$kelas_cls'
                    ";
                    $rs_siswa = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_siswa);
                    $rows_num = mysqli_num_rows($rs_siswa);
                                        
                    if($rows_num > 0){
                        if ($thnajaran_cls == $rs['thnajaran_cls'] && 
                            $kelas_cls == $rs['kelas_cls'] &&
                            $matapel_cls == $rs['matapel_cls'] &&
                            substr($last_update,0,16) > substr($rs['last_update'],0,16)  ){                            
                            $sql = "
                            delete from kriteria_tuntas                       
                            where   thnajaran_cls = '$thnajaran_cls'
                            and     matapel_cls = '$matapel_cls'
                            and     kelas_cls = '$kelas_cls' ";             
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into kriteria_tuntas 
                            (   thnajaran_cls,	
                                kelas_cls,	
                                matapel_cls,
                                nilai_kkm,
                                panjang_interval,
                                a_min,
                                a_max,
                                b_min,
                                b_max,
                                c_min,
                                c_max,
                                d_min,
                                d_max,
                                register_user,
                                register_date,
                                last_user,
                                last_update,	
                                transfer_date
                            )
                            values
                            (   '$thnajaran_cls',
                                '$kelas_cls',
                                '$matapel_cls',
                                '$nilai_kkm',
                                '$panjang_interval',    
                                '$a_min',
                                '$a_max',
                                '$b_min',
                                '$b_max',
                                '$c_min',
                                '$c_max',
                                '$d_min',
                                '$d_max',
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
                        insert into kriteria_tuntas 
                        (   thnajaran_cls,	
                            kelas_cls,	
                            matapel_cls,
                            nilai_kkm,
                            panjang_interval,
                            a_min,
                            a_max,
                            b_min,
                            b_max,
                            c_min,
                            c_max,
                            d_min,
                            d_max,
                            register_user,
                            register_date,
                            last_user,
                            last_update,	
                            transfer_date
                        )
                        values
                        (   '$thnajaran_cls',
                            '$kelas_cls',
                            '$matapel_cls',
                            '$nilai_kkm',
                            '$panjang_interval',    
                            '$a_min',
                            '$a_max',
                            '$b_min',
                            '$b_max',
                            '$c_min',
                            '$c_max',
                            '$d_min',
                            '$d_max',
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
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
            }            
           
        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>mysqli_error($conn))) ;
        }
    }
    

}
?>