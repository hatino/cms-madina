<?php

use SebastianBergmann\Environment\Console;

class Pembayaran extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('pembayaran/Mdl_pembayaran');  
        $this->load->model('mdl_user');       
    }

    function show_pembayaran(){
        if(isset($_COOKIE['cms-swi-user'])) {
            $username = $_COOKIE['cms-swi-user'];         
            $data['username'] = $username;
            $hasil = $this->mdl_user->cek_user($username);
            $data['status_admin'] = $hasil;
            $this->template->load('template_siswa','pembayaran/frm_pembayaran', $data); 
        }else{
            redirect('auth/login'); 	
        }
    }
        
    function get_thn_ajaran() {
        $data = $this->Mdl_pembayaran->get_thn_ajaran()->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_jenjang_pendidikan() {
        $thnajaran = $this->input->get('thnajaran');
        $data = $this->Mdl_pembayaran->get_jenjang_pendidikan($thnajaran)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_kelas() {
        $thnajaran = $this->input->get('thnajaran');
        $jenjang = $this->input->get('jenjang'); 
        $data = $this->Mdl_pembayaran->get_kelas($thnajaran, $jenjang)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_subkelas() {
        $thnajaran = $this->input->get('thnajaran');
        $jenjang = $this->input->get('jenjang'); 
        $kelas = $this->input->get('kelas'); 
        $data = $this->Mdl_pembayaran->get_subkelas($thnajaran, $jenjang, $kelas)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }    

    function get_nama_siswa() {
        $thnajaran = $this->input->get('thnajaran');
        $jenjang = $this->input->get('jenjang'); 
        $kelas = $this->input->get('kelas'); 
        $subkelas = $this->input->get('subkelas'); 
        $data = $this->Mdl_pembayaran->get_nama_siswa($thnajaran, $jenjang, $kelas, $subkelas)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_nama_siswa_by_user() {
        $req_data = $this->input->get(); 
        $data = $this->Mdl_pembayaran->get_nama_siswa_by_user($req_data)->result();
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }

    function get_data_tbl_pembayaran() {
        $req_data = $this->input->get(); 
        $data = $this->Mdl_pembayaran->get_data_tbl_pembayaran($req_data)->result();       
        echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>''));
    }    

    function get_data_tbl_pembayaran_cms() {
        $req_params = $this->input->get();           
        $data=$this->Mdl_pembayaran->get_data_tbl_pembayaran_cms($req_params)->result();
        echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>'get data berhasil'));
    }

    function simpan_kwitansi_baru() {
        $json_catch = file_get_contents('php://input');
        $data = json_decode($json_catch, true);
        //var_dump($data[0]);

        try {                            
            include 'conn.php';
                        
            $conn->autocommit(FALSE);   
            $rows=0;

            //data kwitansi detail         
            if( count($data[0]) > 0 ){
                foreach($data[0] as $key => $value){
                    $stdArray[$key] = (array) $value;
                    $no_kwitansi = $stdArray[$key]['NoKwitansi'];                 
                    $pembayaran_cls = $stdArray[$key]['PembayaranCls'];
                    $curr_cls = $stdArray[$key]['CurrCls'];
                    $amount = $stdArray[$key]['Amount'];
                    $seqno_pem = $stdArray[$key]['SeqNoPem'];
                    $seqno_pemdetail = $stdArray[$key]['SeqNoPemDetail'];
                    $seq_no = $stdArray[$key]['SeqNo'];
                    $period = $stdArray[$key]['Period'];
                    $period = str_replace('T',' ',$period);
                    $period = str_replace('Z',' ',$period);
                    $status_disc_auto = $stdArray[$key]['status_disc_auto'];
                    $disc_auto_persen = $stdArray[$key]['disc_auto_persen'];
                    $amount_wnot_discAuto = $stdArray[$key]['amount_wnot_discAuto'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z',' ',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z',' ',$last_update);

                    $ls_query ="
                    select  no_kwitansi, seq_no, last_update 
                    from    kw_siswa_detail 
                    where   no_kwitansi = '$no_kwitansi' 
                    and     seq_no = '$seq_no'
                    ";
                    $rs_pembayaran = mysqli_query($conn, $ls_query);  
                    $rs = mysqli_fetch_assoc($rs_pembayaran);
                    // var_dump($rs);
                    // echo substr($last_update,0,16).'-';
                    // echo substr($rs['last_update'],0,16);

                    $rows_num = mysqli_num_rows($rs_pembayaran);
                                        
                    if($rows_num > 0){                        
                        if ($no_kwitansi == $rs['no_kwitansi'] &&                           
                            $seq_no==$rs['seq_no'] && 
                            substr($last_update,0,16) > substr($rs['last_update'],0,16) ){  

                            $sql = "
                            delete from kw_siswa_detail                       
                            where   no_kwitansi = '$no_kwitansi'                          
                            and     seq_no = '$seq_no' ";                        
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into kw_siswa_detail 
                            (   no_kwitansi,	
                                pembayaran_cls,
                                curr_cls,
                                amount,
                                seqno_pem,
                                seqno_pemdetail,	
                                seq_no,
                                period,
                                status_disc_auto,
                                disc_auto_persen,
                                amount_wnot_discAuto,
                                register_user,
                                register_date,
                                last_user,
                                last_update,
                                transfer_date
                            )
                            values
                            (   '$no_kwitansi',
                                '$pembayaran_cls',
                                '$curr_cls',
                                '$amount',
                                '$seqno_pem',    
                                '$seqno_pemdetail',
                                '$seq_no',
                                '$period',";

                            if($status_disc_auto==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $status_disc_auto,";
                            }

                            if($disc_auto_persen==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $disc_auto_persen,";
                            }

                            if($amount_wnot_discAuto==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $amount_wnot_discAuto,";
                            }
                                
                            $sql .= "                                     
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
                        insert into kw_siswa_detail 
                        (   no_kwitansi,	
                            pembayaran_cls,
                            curr_cls,
                            amount,
                            seqno_pem,
                            seqno_pemdetail,	
                            seq_no,
                            period,
                            status_disc_auto,
                            disc_auto_persen,
                            amount_wnot_discAuto,
                            register_user,
                            register_date,
                            last_user,
                            last_update,
                            transfer_date
                        )
                        values
                        (   '$no_kwitansi',
                            '$pembayaran_cls',
                            '$curr_cls',
                            '$amount',
                            '$seqno_pem',    
                            '$seqno_pemdetail',
                            '$seq_no',
                            '$period',"; 

                        if($status_disc_auto==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $status_disc_auto,";
                        }

                        if($disc_auto_persen==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $disc_auto_persen,";
                        }

                        if($amount_wnot_discAuto==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $amount_wnot_discAuto,";
                        }

                        $sql .= "                                
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

            //data kwitansi master         
            if( count($data[1]) > 0 ){
                foreach($data[1] as $key => $value){
                    $stdArray[$key] = (array) $value;
                    $no_kwitansi = $stdArray[$key]['NoKwitansi']; 
                    $tgl_kwitansi = $stdArray[$key]['TglKwitansi']; 
                    $tgl_kwitansi = str_replace('T',' ',$tgl_kwitansi);
                    $tgl_kwitansi = str_replace('Z',' ',$tgl_kwitansi);
                    $nis = $stdArray[$key]['NIS'];
                    $total_amount = $stdArray[$key]['TotalAmount'];
                    $keterangan = $stdArray[$key]['Keterangan'];
                    $diterima_dari = $stdArray[$key]['DiterimaDari'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z',' ',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z',' ',$last_update);

                    $ls_query ="
                    select  no_kwitansi, last_update 
                    from    kw_siswa_master 
                    where   no_kwitansi = '$no_kwitansi' 
                    ";
                    $rs_pembayaran = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_pembayaran);
                    $rows_num = mysqli_num_rows($rs_pembayaran);
                                        
                    if($rows_num > 0){                        
                        if ($no_kwitansi == $rs['no_kwitansi'] && 
                            substr($last_update,0,16) > substr($rs['last_update'],0,16) ){  

                            $sql = "
                            delete from kw_siswa_master                       
                            where   no_kwitansi = '$no_kwitansi' ";
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into kw_siswa_master 
                            (   no_kwitansi,
                                tgl_kwitansi,
                                nis,
                                total_amount,
                                keterangan,
                                diterima_dari,
                                register_user,
                                register_date,
                                last_user,
                                last_update,	
                                transfer_date
                            )
                            values
                            (   '$no_kwitansi',
                                '$tgl_kwitansi',
                                '$nis',
                                '$total_amount',
                                '$keterangan',    
                                '$diterima_dari',                                                                       
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
                        insert into kw_siswa_master 
                        (   no_kwitansi,
                            tgl_kwitansi,
                            nis,
                            total_amount,
                            keterangan,
                            diterima_dari,
                            register_user,
                            register_date,
                            last_user,
                            last_update,	
                            transfer_date
                        )
                        values
                        (   '$no_kwitansi',
                            '$tgl_kwitansi',
                            '$nis',
                            '$total_amount',
                            '$keterangan',    
                            '$diterima_dari',                                                                       
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
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        } 
        

    }

    function simpan_pembayaran(){
        try {
            $json_catch = file_get_contents('php://input');
            $data = json_decode($json_catch, true);
            //var_dump($data);
            $this->simpan_pembayaran_detail($data);

        } catch (Exception $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        } 
    }

    public function simpan_pembayaran_detail($data) {
        try {                            
            include 'conn.php';
                        
            $conn->autocommit(FALSE);   
            $rows=0;

            //data pembayaran siswa          
            if( count($data[0]) > 0 ){
                foreach($data[0] as $key => $value){
                    $stdArray[$key] = (array) $value;
                    $nis = $stdArray[$key]['NIS'];
                    $pembayaran_cls = $stdArray[$key]['PembayaranCls'];
                    $curr_cls = $stdArray[$key]['CurrCls'];
                    $amount = $stdArray[$key]['Amount'];
                    $tgl_mulai = $stdArray[$key]['TglMulai'];
                    $tgl_mulai = str_replace('T',' ',$tgl_mulai);
                    $tgl_mulai = str_replace('Z',' ',$tgl_mulai);
                    $tgl_selesai = $stdArray[$key]['TglSelesai'];
                    $tgl_selesai = str_replace('T',' ',$tgl_selesai);
                    $tgl_selesai = str_replace('Z',' ',$tgl_selesai);
                    $seq_no = $stdArray[$key]['SeqNo'];
                    $angsuran = $stdArray[$key]['Angsuran'];
                    $thnajaran_cls = $stdArray[$key]['ThnAjaranCls'];
                    $amount_b4_disc = $stdArray[$key]['AmountB4Disc'];
                    $disc = $stdArray[$key]['Disc'];
                    $status_disc_auto = $stdArray[$key]['status_disc_auto'];
                    $disc_auto_persen = $stdArray[$key]['disc_auto_persen'];
                    $amount_b4_discAuto = $stdArray[$key]['amount_b4_discAuto'];
                    $last_update_disc_auto = $stdArray[$key]['last_update_disc_auto'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z',' ',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z',' ',$last_update);

                    $ls_query ="
                    select  nis, seq_no, last_update 
                    from    pembayaran_siswa 
                    where   nis = '$nis'
                    and     seq_no = '$seq_no'
                    ";
                    $rs_pembayaran = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_pembayaran);
                    $rows_num = mysqli_num_rows($rs_pembayaran);
                                        
                    if($rows_num > 0){
                        
                        if ($nis == $rs['nis'] && $seq_no==$rs['seq_no'] && substr($last_update,0,16) > substr($rs['last_update'],0,16) ){                            
                            $sql = "
                            delete from pembayaran_siswa                       
                            where   nis = '$nis' and seq_no = '$seq_no' ";                        
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into pembayaran_siswa 
                            (   nis,	
                                pembayaran_cls,	
                                curr_cls,
                                amount,
                                tgl_mulai,
                                tgl_selesai,
                                seq_no,
                                angsuran,
                                thnajaran_cls,
                                amount_b4_disc,
                                disc,
                                status_disc_auto,
                                disc_auto_persen,
                                amount_b4_discAuto,
                                last_update_disc_auto,
                                register_user,
                                register_date,
                                last_user,
                                last_update,	
                                transfer_date
                            )
                            values
                            (   '$nis',
                                '$pembayaran_cls',
                                '$curr_cls',
                                '$amount',
                                '$tgl_mulai',    
                                '$tgl_selesai',
                                '$seq_no',
                                '$angsuran',
                                '$thnajaran_cls',
                                '$amount_b4_disc',
                                '$disc', ";

                            if($status_disc_auto==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $status_disc_auto,";
                            }

                            if($disc_auto_persen==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $disc_auto_persen,";
                            }

                            if($amount_b4_discAuto==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $amount_b4_discAuto,";
                            }

                            if($last_update_disc_auto==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $last_update_disc_auto,";
                            }
                                
                            $sql .= "                           
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
                        else{
                            $sql = "
                            update  pembayaran_siswa        
                            set     transfer_date =  CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')              
                            where   nis = '$nis' and seq_no = '$seq_no' ";                        
                            mysqli_query($conn, $sql);
                        }

                    }else{

                        $sql ="
                        insert into pembayaran_siswa 
                        (   nis,	
                            pembayaran_cls,	
                            curr_cls,
                            amount,
                            tgl_mulai,
                            tgl_selesai,
                            seq_no,
                            angsuran,
                            thnajaran_cls,
                            amount_b4_disc,
                            disc,
                            status_disc_auto,
                            disc_auto_persen,
                            amount_b4_discAuto,
                            last_update_disc_auto,
                            register_user,
                            register_date,
                            last_user,
                            last_update,	
                            transfer_date
                        )
                        values
                        (   '$nis',
                            '$pembayaran_cls',
                            '$curr_cls',
                            '$amount',
                            '$tgl_mulai',    
                            '$tgl_selesai',
                            '$seq_no',
                            '$angsuran',
                            '$thnajaran_cls',
                            '$amount_b4_disc',
                            '$disc', ";

                        if($status_disc_auto==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $status_disc_auto,";
                        }

                        if($disc_auto_persen==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $disc_auto_persen,";
                        }

                        if($amount_b4_discAuto==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $amount_b4_discAuto,";
                        }

                        if($last_update_disc_auto==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $last_update_disc_auto,";
                        }
                            
                        $sql .= "                           
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

            //data pembayaran siswa detail         
            if( count($data[1]) > 0 ){
                foreach($data[1] as $key => $value){
                    $stdArray[$key] = (array) $value;
                    $trans_id = $stdArray[$key]['TransID'];
                    $period = $stdArray[$key]['Period'];
                    $period = str_replace('T',' ',$period);
                    $period = str_replace('Z',' ',$period);
                    $nis = $stdArray[$key]['NIS'];
                    $pembayaran_cls = $stdArray[$key]['PembayaranCls'];
                    $curr_cls = $stdArray[$key]['CurrCls'];
                    $harga = $stdArray[$key]['Harga'];
                    $amount = $stdArray[$key]['Amount'];
                    $seq_no = $stdArray[$key]['SeqNo'];
                    $amount_b4_disc = $stdArray[$key]['AmountB4Disc'];
                    $disc = $stdArray[$key]['Disc'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z',' ',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z',' ',$last_update);

                    $ls_query ="
                    select  nis, trans_id, pembayaran_cls, seq_no, last_update 
                    from    pembayaran_siswa_detail 
                    where   nis = '$nis'
                    and     trans_id = '$trans_id'
                    and     pembayaran_cls = '$pembayaran_cls'
                    and     seq_no = '$seq_no'
                    ";
                    $rs_pembayaran = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_pembayaran);
                    $rows_num = mysqli_num_rows($rs_pembayaran);
                                        
                    if($rows_num > 0){
                        
                        if ($nis == $rs['nis'] && 
                            $trans_id == $rs['trans_id'] &&
                            $pembayaran_cls == $rs['pembayaran_cls'] &&
                            $seq_no==$rs['seq_no'] && 
                            substr($last_update,0,16) > substr($rs['last_update'],0,16) ){  

                            $sql = "
                            delete from pembayaran_siswa_detail                       
                            where   nis = '$nis'
                            and     trans_id = '$trans_id'
                            and     pembayaran_cls = '$pembayaran_cls'
                            and     seq_no = '$seq_no' ";                        
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into pembayaran_siswa_detail 
                            (   trans_id,
                                period,
                                nis,
                                pembayaran_cls,	
                                curr_cls,
                                harga,
                                amount,
                                seq_no,	
                                amount_b4_disc,
                                disc,
                                register_user,
                                register_date,
                                last_user,
                                last_update,	
                                transfer_date
                            )
                            values
                            (   '$trans_id',
                                '$period',
                                '$nis',
                                '$pembayaran_cls',
                                '$curr_cls',    
                                '$harga',
                                '$amount',
                                '$seq_no',
                                '$amount_b4_disc',                                
                                '$disc',                                          
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
                        insert into pembayaran_siswa_detail 
                        (   trans_id,
                            period,
                            nis,
                            pembayaran_cls,	
                            curr_cls,
                            harga,
                            amount,
                            seq_no,	
                            amount_b4_disc,
                            disc,
                            register_user,
                            register_date,
                            last_user,
                            last_update,	
                            transfer_date
                        )
                        values
                        (   '$trans_id',
                            '$period',
                            '$nis',
                            '$pembayaran_cls',
                            '$curr_cls',    
                            '$harga',
                            '$amount',
                            '$seq_no',
                            '$amount_b4_disc',                                
                            '$disc',                                          
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

            //data kwitansi detail         
            if( count($data[2]) > 0 ){
                foreach($data[2] as $key => $value){
                    $stdArray[$key] = (array) $value;
                    $no_kwitansi = $stdArray[$key]['NoKwitansi'];                 
                    $pembayaran_cls = $stdArray[$key]['PembayaranCls'];
                    $curr_cls = $stdArray[$key]['CurrCls'];
                    $amount = $stdArray[$key]['Amount'];
                    $seqno_pem = $stdArray[$key]['SeqNoPem'];
                    $seqno_pemdetail = $stdArray[$key]['SeqNoPemDetail'];
                    $seq_no = $stdArray[$key]['SeqNo'];
                    $period = $stdArray[$key]['Period'];
                    $period = str_replace('T',' ',$period);
                    $period = str_replace('Z',' ',$period);
                    $status_disc_auto = $stdArray[$key]['status_disc_auto'];
                    $disc_auto_persen = $stdArray[$key]['disc_auto_persen'];
                    $amount_wnot_discAuto = $stdArray[$key]['amount_wnot_discAuto'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z',' ',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z',' ',$last_update);

                    $ls_query ="
                    select  no_kwitansi, seq_no, last_update 
                    from    kw_siswa_detail 
                    where   no_kwitansi = '$no_kwitansi' 
                    and     seq_no = '$seq_no'
                    ";
                    $rs_pembayaran = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_pembayaran);
                    $rows_num = mysqli_num_rows($rs_pembayaran);
                                        
                    if($rows_num > 0){                        
                        if ($no_kwitansi == $rs['no_kwitansi'] &&                           
                            $seq_no==$rs['seq_no'] && 
                            substr($last_update,0,16) > substr($rs['last_update'],0,16) ){  

                            $sql = "
                            delete from kw_siswa_detail                       
                            where   no_kwitansi = '$no_kwitansi'                          
                            and     seq_no = '$seq_no' ";                        
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into kw_siswa_detail 
                            (   no_kwitansi,	
                                pembayaran_cls,
                                curr_cls,
                                amount,
                                seqno_pem,
                                seqno_pemdetail,	
                                seq_no,
                                period,
                                status_disc_auto,
                                disc_auto_persen,
                                amount_wnot_discAuto,
                                register_user,
                                register_date,
                                last_user,
                                last_update,
                                transfer_date
                            )
                            values
                            (   '$no_kwitansi',
                                '$pembayaran_cls',
                                '$curr_cls',
                                '$amount',
                                '$seqno_pem',    
                                '$seqno_pemdetail',
                                '$seq_no',
                                '$period',";

                            if($status_disc_auto==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $status_disc_auto,";
                            }

                            if($disc_auto_persen==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $disc_auto_persen,";
                            }

                            if($amount_wnot_discAuto==null){
                                $sql .= "
                                NULL,";  
                            }else{
                                $sql .= "
                                $amount_wnot_discAuto,";
                            }
                               
                            $sql .= "                                     
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
                        insert into kw_siswa_detail 
                        (   no_kwitansi,	
                            pembayaran_cls,
                            curr_cls,
                            amount,
                            seqno_pem,
                            seqno_pemdetail,	
                            seq_no,
                            period,
                            status_disc_auto,
                            disc_auto_persen,
                            amount_wnot_discAuto,
                            register_user,
                            register_date,
                            last_user,
                            last_update,
                            transfer_date
                        )
                        values
                        (   '$no_kwitansi',
                            '$pembayaran_cls',
                            '$curr_cls',
                            '$amount',
                            '$seqno_pem',    
                            '$seqno_pemdetail',
                            '$seq_no',
                            '$period',"; 

                        if($status_disc_auto==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $status_disc_auto,";
                        }

                        if($disc_auto_persen==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $disc_auto_persen,";
                        }

                        if($amount_wnot_discAuto==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $sql .= "
                            $amount_wnot_discAuto,";
                        }

                        $sql .= "                                
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

            //data kwitansi master         
            if( count($data[3]) > 0 ){
                foreach($data[3] as $key => $value){
                    $stdArray[$key] = (array) $value;
                    $no_kwitansi = $stdArray[$key]['NoKwitansi']; 
                    $tgl_kwitansi = $stdArray[$key]['TglKwitansi']; 
                    $tgl_kwitansi = str_replace('T',' ',$tgl_kwitansi);
                    $tgl_kwitansi = str_replace('Z',' ',$tgl_kwitansi);
                    $nis = $stdArray[$key]['NIS'];
                    $total_amount = $stdArray[$key]['TotalAmount'];
                    $keterangan = $stdArray[$key]['Keterangan'];
                    $diterima_dari = $stdArray[$key]['DiterimaDari'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];
                    $register_date = str_replace('T',' ',$register_date);
                    $register_date = str_replace('Z',' ',$register_date);
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    $last_update = str_replace('T',' ',$last_update);
                    $last_update = str_replace('Z',' ',$last_update);

                    $ls_query ="
                    select  no_kwitansi, last_update 
                    from    kw_siswa_master 
                    where   no_kwitansi = '$no_kwitansi' 
                    ";
                    $rs_pembayaran = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_pembayaran);
                    $rows_num = mysqli_num_rows($rs_pembayaran);
                                        
                    if($rows_num > 0){                        
                        if ($no_kwitansi == $rs['no_kwitansi'] && 
                            substr($last_update,0,16) > substr($rs['last_update'],0,16) ){  

                            $sql = "
                            delete from kw_siswa_master                       
                            where   no_kwitansi = '$no_kwitansi' ";
                            mysqli_query($conn, $sql);

                            $sql ="
                            insert into kw_siswa_master 
                            (   no_kwitansi,
                                tgl_kwitansi,
                                nis,
                                total_amount,
                                keterangan,
                                diterima_dari,
                                register_user,
                                register_date,
                                last_user,
                                last_update,	
                                transfer_date
                            )
                            values
                            (   '$no_kwitansi',
                                '$tgl_kwitansi',
                                '$nis',
                                '$total_amount',
                                '$keterangan',    
                                '$diterima_dari',                                                                       
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
                        insert into kw_siswa_master 
                        (   no_kwitansi,
                            tgl_kwitansi,
                            nis,
                            total_amount,
                            keterangan,
                            diterima_dari,
                            register_user,
                            register_date,
                            last_user,
                            last_update,	
                            transfer_date
                        )
                        values
                        (   '$no_kwitansi',
                            '$tgl_kwitansi',
                            '$nis',
                            '$total_amount',
                            '$keterangan',    
                            '$diterima_dari',                                                                       
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

            //data pembayaran_cls         
            if( count($data[4]) > 0 ){
                foreach($data[4] as $key => $value){
                    $stdArray[$key] = (array) $value;                  
                    $pembayaran_cls = $stdArray[$key]['PembayaranCls']; 
                    $deskripsi = $stdArray[$key]['Description']; 
                    $deskripsi = str_replace("'","''",$deskripsi);
                    $bulanan = $stdArray[$key]['Bulanan'];
                    $fix = $stdArray[$key]['Fix'];
                    $yayasan_cls = $stdArray[$key]['YayasanCls'];
                    $psb_cls = $stdArray[$key]['PSBCls'];
                    $status_ekskul = $stdArray[$key]['StatusEkskul'];
                    $status_tidak_aktif = $stdArray[$key]['StatusTidakAktif'];
                    $status_lapkeuangan = $stdArray[$key]['StatusLapKeuangan'];
                    $register_user = $stdArray[$key]['RegisterUser'];
                    $register_date = $stdArray[$key]['RegisterDate'];                    
                    
                    $last_user = $stdArray[$key]['LastUser'];
                    $last_update = $stdArray[$key]['LastUpdate'];
                    
                    $ls_query ="
                    select  pembayaran_cls, last_update 
                    from    pembayaran_cls 
                    where   pembayaran_cls = '$pembayaran_cls' 
                    ";
                    $rs_pembayaran = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_pembayaran);
                    $rows_num = mysqli_num_rows($rs_pembayaran);
                                        
                    if($rows_num > 0){         
                        
                        if ($last_update==null){

                        }else{
                            if ($pembayaran_cls == $rs['pembayaran_cls'] && 
                            substr($last_update,0,16) > substr($rs['last_update'],0,16) ){  

                                $sql = "
                                delete from pembayaran_cls                       
                                where   pembayaran_cls = '$pembayaran_cls' ";
                                mysqli_query($conn, $sql);

                                $sql ="
                                insert into pembayaran_cls 
                                (   pembayaran_cls,
                                    deskripsi,
                                    bulanan,
                                    fix,	
                                    yayasan_cls,
                                    psb_cls,
                                    status_ekskul,
                                    status_tidak_aktif,
                                    status_lapkeuangan,
                                    register_user,
                                    register_date,
                                    last_user,
                                    last_update,
                                    transfer_date
                                )
                                values
                                (   '$pembayaran_cls',
                                    '$deskripsi',
                                    '$bulanan',
                                    '$fix',
                                    '$yayasan_cls',    
                                    '$psb_cls',      
                                    '$status_ekskul',
                                    '$status_tidak_aktif',
                                    '$status_lapkeuangan',                                                                 
                                    '$register_user',";
                                
                                if($register_date==null){
                                    $sql .= "
                                    NULL,";  
                                }else{
                                    $register_date = str_replace('T',' ',$register_date);
                                    $register_date = str_replace('Z',' ',$register_date);
                                    $sql .= "
                                    '$register_date',";
                                }                                

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

                    }else{
                        $sql ="
                        insert into pembayaran_cls 
                        (   pembayaran_cls,
                            deskripsi,
                            bulanan,
                            fix,	
                            yayasan_cls,
                            psb_cls,
                            status_ekskul,
                            status_tidak_aktif,
                            status_lapkeuangan,
                            register_user,
                            register_date,
                            last_user,
                            last_update,
                            transfer_date
                        )
                        values
                        (   '$pembayaran_cls',
                            '$deskripsi',
                            '$bulanan',
                            '$fix',
                            '$yayasan_cls',    
                            '$psb_cls',      
                            '$status_ekskul',
                            '$status_tidak_aktif',
                            '$status_lapkeuangan',                                                                 
                            '$register_user',";

                        if($register_date==null){
                            $sql .= "
                            NULL,";  
                        }else{
                            $register_date = str_replace('T',' ',$register_date);
                            $register_date = str_replace('Z',' ',$register_date);
                            $sql .= "
                            '$register_date',";
                        }            

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
                        
                        echo $sql;
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

            //data master siswa
            if( count($data[5]) > 0 ){
                foreach($data[5] as $key => $value){
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

                    //USER SETUP FOR SISWA
                    $ls_query ="
                    select user_id from user_setup_siswa 
                    where  user_id = '$nis'
                    ";
                    $rs_user_setup_siswa = mysqli_query($conn, $ls_query);
                    $rows_num_siswa = mysqli_num_rows($rs_user_setup_siswa);

                    if($rows_num_siswa == 0){
                        $sql = "
                        insert into user_setup_siswa 
                        (   user_id,	
                            user_name,	
                            password                            
                        )
                        values
                        (   '$nis',
                            '$nama',
                            (SELECT FLOOR(100000 + (RAND() * 899999)))
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

            //data kelas siswa
            if( count($data[6]) > 0 ){
                foreach($data[6] as $key => $value){
                    $stdArray[$key] = (array) $value;  
                    $nis = $stdArray[$key]['NIS'];
                    $thnajaran_cls = $stdArray[$key]['ThnAjaranCls'];
                    $kelas_cls = $stdArray[$key]['KelasCls'];
                    $subkelas_cls = $stdArray[$key]['SubKelasCls'];
                    $tgl_mulai = $stdArray[$key]['TglMulai'];
                    $tgl_mulai = str_replace('T',' ',$tgl_mulai);
                    $tgl_mulai = str_replace('Z',' ',$tgl_mulai);
                    $tgl_selesai = $stdArray[$key]['TglSelesai'];
                    $tgl_selesai = str_replace('T',' ',$tgl_selesai);
                    $tgl_selesai = str_replace('Z',' ',$tgl_selesai);
                    $remarks = $stdArray[$key]['Remarks'];                    
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
                    select  nis, thnajaran_cls, last_update 
                    from    kelas_siswa 
                    where   nis = '$nis'
                    and     thnajaran_cls = '$thnajaran_cls'
                    ";
                    $rs_siswa = mysqli_query($conn, $ls_query);                 
                    $rs = mysqli_fetch_assoc($rs_siswa);
                    $rows_num = mysqli_num_rows($rs_siswa);
                                        
                    if($rows_num > 0){
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

            //data user_setup
            if( count($data[7]) > 0 ){
                foreach($data[7] as $key => $value){
                    $stdArray[$key] = (array) $value;  
                    $user_id = $stdArray[$key]['Username'];
                    $user_name = $stdArray[$key]['Name'];
                    $password = $stdArray[$key]['Password'];
                    $status_admin = $stdArray[$key]['Status_Admin'];
                    $group_cls = $stdArray[$key]['GroupCls'];
                    $nip = $stdArray[$key]['NIP'];

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
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        } 
    }

}
?>