<?php

use phpDocumentor\Reflection\Types\Nullable;
use SebastianBergmann\Environment\Console;

class Master_data extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('ujian/Mdl_input_soal');             
    }

    function get_thn_ajaran() {
        $data = $this->Mdl_raport->get_thn_ajaran()->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function simpan_master_data_sks() {
        try {
            $json_catch = file_get_contents('php://input');
            $data = json_decode($json_catch, true);
            
            $rows_affected = 0;  
            $rows = 0;      
            // echo count($data);        
            for ($i=0; $i < count($data); $i++) { 
                $key = array_keys($data[$i]);

                if ($key[0]=='master_siswa'){
                    if(count($data[$i]['master_siswa']) > 0){
                        $rows = $this->simpan_master_siswa($data[$i]); 
                        $rows_affected = $rows_affected + $rows;                    
                    };                                    
                }

                if ($key[0]=='thn_ajaran'){
                    if(count($data[$i]['thn_ajaran']) > 0){
                        $rows = $this->simpan_thn_ajaran($data[$i]); 
                        $rows_affected = $rows_affected + $rows; 
                    };                                    
                }

                if ($key[0]=='mapel'){                   
                    if(count($data[$i]['mapel']) > 0 ) {                        
                        $rows = $this->simpan_mapel($data[$i]);  
                        $rows_affected = $rows_affected + $rows; 
                    }             
                }

                if ($key[0]=='mapel_kelas'){                              
                    if(count($data[$i]['mapel_kelas']) > 0 ) {                        
                       $rows = $this->simpan_mapel_kelas($data[$i]); 
                       $rows_affected = $rows_affected + $rows; 
                    }                                     
                }

                if ($key[0]=='setting_group_kelas'){                                               
                    if(count($data[$i]['setting_group_kelas']) > 0 ) {                        
                        $rows = $this->simpan_setting_group_kelas($data[$i]);  
                        $rows_affected = $rows_affected + $rows;
                    }                                     
                }

                if ($key[0]=='kelas_siswa'){
                    if(count($data[$i]['kelas_siswa']) > 0 ) {                        
                        $rows = $this->simpan_kelas_siswa($data[$i]);
                        $rows_affected = $rows_affected + $rows;  
                    }                                     
                }

                if ($key[0]=='user_setup'){
                    if(count($data[$i]['user_setup']) > 0 ) {                        
                        $rows = $this->simpan_user_setup($data[$i]);
                        $rows_affected = $rows_affected + $rows;  
                    }                                     
                }

            }
            echo json_encode(array('status'=>true,'data'=>$rows_affected, 'message'=>'Proses Selesai'));

        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->getMessage())) ;
        } 
    }

    function simpan_master_siswa($data) {
        try {
            include 'conn.php';                        
            $conn->autocommit(FALSE);   

            $master_siswa = $data['master_siswa'];
            $rows=0;
            for ($i=0; $i < count($master_siswa) ; $i++) { 
                $nis = $master_siswa[$i]['NIS'];  
                $nama = $master_siswa[$i]['Nama'];
                $nama = str_replace("'","''",$nama);
                $nama_ayah = $master_siswa[$i]['NamaAyah'];
                if($nama_ayah==null){ 
                    $nama_ayah=''; 
                }
                $nama_ayah = str_replace("'","''",$nama_ayah);
                $nama_ibu = $master_siswa[$i]['NamaIbu'];
                if($nama_ibu==null){ 
                    $nama_ibu=''; 
                }
                $nama_ibu = str_replace("'","''",$nama_ibu);
                $no_wa = $master_siswa[$i]['No_WA'];
                $register_user = $master_siswa[$i]['RegisterUser'];
                $register_date = $master_siswa[$i]['RegisterDate'];
                $register_date = str_replace('T',' ',$register_date);
                $register_date = str_replace('Z','',$register_date);
                $last_user = $master_siswa[$i]['Last_User'];
                $last_update = $master_siswa[$i]['Last_Update'];
                $last_update = str_replace('T',' ',$last_update);
                $last_update = str_replace('Z',' ',$last_update);

                $ls_query ="
                select nis, last_update 
                from master_siswa 
                where   nis = '$nis'
                ";
                $rs_siswa = mysqli_query($conn, $ls_query);                 
                $rs = mysqli_fetch_assoc($rs_siswa);
                $rows_num = mysqli_num_rows($rs_siswa);
                                    
                if($rows_num > 0){
                    if ($nis == $rs['nis'] && substr($last_update,0,16) > substr($rs['last_update'],0,16) ){                            
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
                            $row = mysqli_affected_rows($conn);
                            $rows= $rows + $row;
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
                        $row = mysqli_affected_rows($conn); 
                        $rows= $rows + $row;
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

            //end loop
            }

            $conn->commit();
            $conn->autocommit(TRUE);

            mysqli_close($conn);
            return $rows;
            // if($rows>0){        
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
            // }else{
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
            // }   

        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>mysqli_error($conn))) ;
        }
    }

    function simpan_thn_ajaran($data){
        //print_r($data);
        try { 
            include 'conn.php';                        
            $conn->autocommit(FALSE);   

            $thn_ajaran = $data['thn_ajaran'];
            $rows=0;
            for ($i=0; $i < count($thn_ajaran) ; $i++) { 
                $thnajaran_cls = $thn_ajaran[$i]['ThnAjaranCls'];
                $deskripsi = $thn_ajaran[$i]['Description'];
                $tgl_mulai = $thn_ajaran[$i]['TglMulai'];
                $tgl_mulai = str_replace('T',' ',$tgl_mulai);
                $tgl_mulai = str_replace('Z',' ',$tgl_mulai);
                $tgl_selesai = $thn_ajaran[$i]['TglSelesai'];
                $tgl_selesai = str_replace('T',' ',$tgl_selesai);
                $tgl_selesai = str_replace('Z',' ',$tgl_selesai);
                $register_user = $thn_ajaran[$i]['RegisterUser'];
                $register_date = $thn_ajaran[$i]['RegisterDate'];
                $register_date = str_replace('T',' ',$register_date);
                $register_date = str_replace('Z','',$register_date);
                $last_user =  $thn_ajaran[$i]['LastUser'];                    
                $last_update =  $thn_ajaran[$i]['LastUpdate'];   

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
                            
                        if (mysqli_query($conn, $sql)) {
                            $row = mysqli_affected_rows($conn); 
                            $rows = $rows + $row;
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
                        $row = mysqli_affected_rows($conn); 
                        $rows = $rows + $row;
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
            
            //end loop
            }

            $conn->commit();
            $conn->autocommit(TRUE);

            mysqli_close($conn);
            return $rows;
            // if($rows>0){        
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
            // }else{
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
            // }   
        
        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>mysqli_error($conn))) ;
        }
                 

    }

    function simpan_mapel($data){
        try {
            include 'conn.php';                        
            $conn->autocommit(FALSE);   

            $mapel = $data['mapel'];
            $rows=0;           
            for ($i=0; $i < count($mapel) ; $i++) { 
                $matapel_cls = $mapel[$i]['MataPelCls'];               
                $deskripsi = $mapel[$i]['Description'];
                $deskripsi = str_replace("'","''",$deskripsi);
                $deskripsi_smp = $mapel[$i]['Description_SMP'];
                $deskripsi_smp = str_replace("'","''",$deskripsi_smp);
                // $stat_not_aktif = $stdArray[$key]['stat_not_aktif'];
                $register_user = $mapel[$i]['RegisterUser'];
                $register_date = $mapel[$i]['RegisterDate'];
                $register_date = str_replace('T',' ',$register_date);
                $register_date = str_replace('Z','',$register_date);
                $last_user = $mapel[$i]['LastUser'];
                $last_update = $mapel[$i]['LastUpdate'];
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
                            $row = mysqli_affected_rows($conn); 
                            $rows = $rows + $row;
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
                        $row = mysqli_affected_rows($conn);
                        $rows = $rows + $row; 
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
                
            //end looping
            }

            $conn->commit();
            $conn->autocommit(TRUE);

            mysqli_close($conn);
            return $rows;
            // if($rows>0){        
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
            // }else{
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
            // }   
            
        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>mysqli_error($conn))) ;
        }
    }

    function simpan_mapel_kelas($data) {
        try {
            include 'conn.php';                        
            $conn->autocommit(FALSE);   

            $mapel_kelas = $data['mapel_kelas'];
            $rows=0;
            for ($i=0; $i < count($mapel_kelas) ; $i++) { 
                $thnajaran_cls = $mapel_kelas[$i]['ThnAjaranCls'];
                $ls_query ="
                select  thnajaran_cls, kelas_cls, matapel_cls, last_update 
                from    matapel_kelas 
                where   thnajaran_cls = '$thnajaran_cls'                      
                ";
                $rs_mapel = mysqli_query($conn, $ls_query);
                $rs = mysqli_fetch_assoc($rs_mapel);
                $rows_num = mysqli_num_rows($rs_mapel);
                
                if($rows_num > 0){
                    $ls_query ="
                    delete  from    matapel_kelas 
                    where   thnajaran_cls = '$thnajaran_cls'                  
                    ";
                    mysqli_query($conn, $ls_query);
                }                   
                break;   
            }

            for ($i=0; $i < count($mapel_kelas) ; $i++) {
                $thnajaran_cls = $mapel_kelas[$i]['ThnAjaranCls'];
                $kelas_cls = $mapel_kelas[$i]['KelasCls'];
                $matapel_cls = $mapel_kelas[$i]['MataPelCls'];
                $no_urut = $mapel_kelas[$i]['NoUrut'];
                $seq_no = $mapel_kelas[$i]['SeqNo'];
                $muatan_mapel = $mapel_kelas[$i]['Muatan_MAPEL'];
                $register_user = $mapel_kelas[$i]['RegisterUser'];
                $register_date = $mapel_kelas[$i]['RegisterDate'];
                $register_date = str_replace('T',' ',$register_date);
                $register_date = str_replace('Z','',$register_date);
                $last_user = $mapel_kelas[$i]['LastUser'];
                $last_update = $mapel_kelas[$i]['LastUpdate'];
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
                    $row = mysqli_affected_rows($conn); 
                    $rows = $rows + $row; 
                }else {
                    $conn->rollBack();
                    $err_code = mysqli_errno($conn);                       
                    if($err_code==1062){
                        echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                    }else{
                        echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
                    }            
                }    
            
            //end looping
            }

            $conn->commit();
            $conn->autocommit(TRUE);

            mysqli_close($conn);
            return $rows;
            // if($rows>0){        
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
            // }else{
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
            // }   
        
        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>mysqli_error($conn))) ;
        }

    }

    function simpan_setting_group_kelas($data) {
        try {
            include 'conn.php';                        
            $conn->autocommit(FALSE);   

            $setting_group_kelas = $data['setting_group_kelas'];
            $rows=0;
            for ($i=0; $i < count($setting_group_kelas) ; $i++) { 
                $group_cls = $setting_group_kelas[$i]['GroupCls'];
                $kelas_cls = $setting_group_kelas[$i]['KelasCls'];
                $subkelas_cls = $setting_group_kelas[$i]['SubKelasCls'];
                $register_user = $setting_group_kelas[$i]['RegisterUser'];
                $register_date = $setting_group_kelas[$i]['RegisterDate'];
                $register_date = str_replace('T',' ',$register_date);
                $register_date = str_replace('Z',' ',$register_date);
                $last_user = $setting_group_kelas[$i]['LastUser'];                
                $last_update = $setting_group_kelas[$i]['LastUpdate'];
                if ($last_update!=null){
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z',' ',$last_update);
                }                

                $ls_query ="
                select  group_cls, kelas_cls, last_update 
                from    setting_group_kelas 
                where   group_cls = '$group_cls'
                and     kelas_cls = '$kelas_cls'               
                ";
                $rs_mapel = mysqli_query($conn, $ls_query);
                $rs = mysqli_fetch_assoc($rs_mapel);
                $rows_num = mysqli_num_rows($rs_mapel);
                
                if($rows_num > 0){
                    if ($group_cls == $rs['group_cls'] && $kelas_cls == $rs['kelas_cls'] && substr($last_update,0,16) > substr($rs['last_update'],0,16) ){                            
                        $ls_query ="
                        delete  from    setting_group_kelas 
                        where   group_cls = '$group_cls'       
                        and     kelas_cls = '$kelas_cls'
                        ";
                        mysqli_query($conn, $ls_query);

                        $sql= "
                        INSERT INTO setting_group_kelas
                        (
                        group_cls,
                        kelas_cls,
                        subkelas_cls,
                        register_user,
                        register_date,
                        last_user,
                        last_update,
                        transfer_date
                        )
                        VALUES
                        (
                        '$group_cls',
                        '$kelas_cls',
                        '$subkelas_cls',
                        '$register_user',
                        '$register_date',
                        '$last_user',
                        '$last_update',
                        CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                        ) ";

                        if (mysqli_query($conn, $sql)) {
                            $row = mysqli_affected_rows($conn); 
                            $rows = $rows + $row; 
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
                    $sql= "
                    INSERT INTO setting_group_kelas
                    (
                    group_cls,
                    kelas_cls,
                    subkelas_cls,
                    register_user,
                    register_date,
                    last_user,
                    last_update,
                    transfer_date
                    )
                    VALUES
                    (
                    '$group_cls',
                    '$kelas_cls',
                    '$subkelas_cls',
                    '$register_user',
                    '$register_date',
                    '$last_user',
                    '$last_update',
                    CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                    ) ";

                    if (mysqli_query($conn, $sql)) {
                        $row = mysqli_affected_rows($conn); 
                        $rows = $rows + $row; 
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

            //end loop
            }

            $conn->commit();
            $conn->autocommit(TRUE);

            mysqli_close($conn);
            return $rows; 
            // if($rows>0){        
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
            // }else{
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
            // }   

        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>mysqli_error($conn))) ;
        }
    }

    function simpan_kelas_siswa($data) {
        try {
            include 'conn.php';                        
            $conn->autocommit(FALSE);   

            $kelas_siswa = $data['kelas_siswa'];
            $rows=0;
            $row=0;
            for ($i=0; $i < count($kelas_siswa) ; $i++) {                
                $nis = $kelas_siswa[$i]['NIS'];
                $thnajaran_cls = $kelas_siswa[$i]['ThnAjaranCls'];
                $kelas_cls = $kelas_siswa[$i]['KelasCls'];
                $subkelas_cls = $kelas_siswa[$i]['SubKelasCls'];
                $tgl_mulai = $kelas_siswa[$i]['TglMulai'];
                $tgl_mulai = str_replace('T',' ',$tgl_mulai);
                $tgl_mulai = str_replace('Z',' ',$tgl_mulai);
                $tgl_selesai = $kelas_siswa[$i]['TglSelesai'];
                $tgl_selesai = str_replace('T',' ',$tgl_selesai);
                $tgl_selesai = str_replace('Z',' ',$tgl_selesai);
                $remarks = $kelas_siswa[$i]['Remarks'];                    
                $seq_no = $kelas_siswa[$i]['SeqNo'];
                $register_user = $kelas_siswa[$i]['RegisterUser'];
                $register_date = $kelas_siswa[$i]['RegisterDate'];
                $register_date = str_replace('T',' ',$register_date);
                $register_date = str_replace('Z',' ',$register_date);
                $last_user = $kelas_siswa[$i]['LastUser'];                
                $last_update = $kelas_siswa[$i]['LastUpdate'];    

                $ls_query ="
                select  nis, thnajaran_cls, last_update 
                from    kelas_siswa 
                where   nis = '$nis'
                and     thnajaran_cls = '$thnajaran_cls'
                ";
                $rs_siswa = mysqli_query($conn, $ls_query);                 
                $rs = mysqli_fetch_assoc($rs_siswa);
                $rows_num = mysqli_num_rows($rs_siswa);
                                    
                if($rows_num > 0){
                    if($last_update!=null){
                        if ($nis == $rs['nis'] &&
                            $thnajaran_cls == $rs['thnajaran_cls'] &&
                            substr($last_update,0,16) > substr($rs['last_update'],0,16) ){                            
                            $sql = "
                            delete  from kelas_siswa                       
                            where   nis = '$nis' 
                            and     thnajaran_cls = '$thnajaran_cls'";                        
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into kelas_siswa 
                            (   nis,
                                thnajaran_cls,
                                kelas_cls,
                                subkelas_cls,
                                tgl_mulai,
                                tgl_selesai,
                                remarks,	
                                seq_no,
                                register_user,
                                register_date,
                                last_user,
                                last_update,
                                transfer_date
                            )
                            values
                            (   '$nis',
                                '$thnajaran_cls',
                                '$kelas_cls',
                                '$subkelas_cls',
                                '$tgl_mulai',
                                '$tgl_selesai',
                                '$remarks',
                                '$seq_no',
                                '$register_user',
                                '$register_date',";
                                
                            if($last_user==null){  
                                $sql .="
                                NULL, ";                 
                            }else{
                                $sql .="
                                '$last_user', ";   
                            }

                            if($last_update==null){  
                                $sql .="
                                NULL, ";                 
                            }else{                           
                                $last_update = str_replace('T',' ',$last_update);
                                $last_update = str_replace('Z',' ',$last_update);
                                $sql .="
                                '$last_update', ";
                            }      

                            $sql .="
                                CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                            )";
                        
                            if (mysqli_query($conn, $sql)) {
                                $row = mysqli_affected_rows($conn); 
                                $rows = $rows + $row;
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

                }else{

                    $sql ="
                    insert into kelas_siswa 
                    (   nis,
                        thnajaran_cls,
                        kelas_cls,
                        subkelas_cls,
                        tgl_mulai,
                        tgl_selesai,
                        remarks,	
                        seq_no,
                        register_user,
                        register_date,
                        last_user,
                        last_update,
                        transfer_date
                    )
                    values
                    (   '$nis',
                        '$thnajaran_cls',
                        '$kelas_cls',
                        '$subkelas_cls',
                        '$tgl_mulai',
                        '$tgl_selesai',
                        '$remarks',
                        '$seq_no',
                        '$register_user',
                        '$register_date', ";                      

                    if($last_user==null){
                        $sql .= "
                        NULL,";  
                    }else{
                        $sql .= "
                        '$last_user',";
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
                        $row = mysqli_affected_rows($conn); 
                        $rows = $rows + $row;
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
            
            //end looping
            }

            $conn->commit();
            $conn->autocommit(TRUE);

            mysqli_close($conn);
            return $rows; 
            // if($rows>0){        
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
            // }else{
            //     echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Tidak ada perubahan data'));
            // }   
            
        
        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>mysqli_error($conn))) ;
        }
    }

    function simpan_user_setup($data) {
        try {
            include 'conn.php';                        
            $conn->autocommit(FALSE);   

            $user_setup = $data['user_setup'];
            $rows=0;
            $row=0;
            for ($i=0; $i < count($user_setup) ; $i++) {
                $user_id = $user_setup[$i]['Username'];
                $user_name = $user_setup[$i]['Name'];
                $password = $user_setup[$i]['Password'];
                $status_admin = $user_setup[$i]['Status_Admin'];
                $group_cls = $user_setup[$i]['GroupCls'];
                $nip = $user_setup[$i]['NIP'];

                $ls_query ="
                select  * 
                from    user_setup 
                where   user_id = '$user_id'                   
                ";
                $rs_user = mysqli_query($conn, $ls_query);                 
                $rs = mysqli_fetch_assoc($rs_user);
                $rows_num = mysqli_num_rows($rs_user);
                                    
                if($rows_num > 0){                                          
                    $sql = "
                    update  user_setup      
                    set     user_name = '$user_name',
                            password = '$password',    
                            status_admin = '$status_admin',
                            group_cls = '$group_cls',
                            nip = '$nip'
                    where   user_id = '$user_id' 
                    ";
                    
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

                }else{
                    $sql ="
                    insert into user_setup (   
                        user_id,
                        user_name,
                        password,
                        status_admin,
                        group_cls,
                        nip
                    )
                    values (
                        '$user_id',
                        '$user_name',
                        '$password',
                        '$status_admin',
                        '$group_cls',
                        '$nip'
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

            $conn->commit();
            $conn->autocommit(TRUE);

            mysqli_close($conn);
            return $rows; 

        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>mysqli_error($conn))) ;
        }

    }

}

?>