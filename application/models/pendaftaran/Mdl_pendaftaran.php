<?php 

class Mdl_pendaftaran extends ci_model
{

    function get_data_thn_ajaran_with_status_open($kode_jenjang) {
        try {
            $query ="
            select  ta.thn_ajaran_cls
                ,   ta.thn_ajaran_nama
                ,	status_open
            from    thn_ajaran_cls ta
            left join thn_ajaran_setting_pendaftaran sp
            on 		ta.thn_ajaran_cls = sp.thn_ajaran_cls
            and 	sp.status_open = '1'
            and 	sp.status_close = '0'
            and 	group_cls = '$kode_jenjang' ";
            
            return $this->db->query($query);            
    
        } catch (error) {
            return error;
        }
    }

    function get_data_info_pendaftaran($kode_jenjang, $thn_ajaran_cls) {
        try {
            $query ="
            select info_pendaftaran
            from info_pendaftaran       
            where thn_ajaran_cls = '$thn_ajaran_cls'
            and   group_cls = '$kode_jenjang'  
            ";   
            return $this->db->query($query);    
    
        } catch (error) {
            return error;
        }
    }

    function get_thn_ajaran_and_jenjang($kode_jenjang, $thn_ajaran_cls) {
        try {
            $query ="
            select thn_ajaran_cls, thn_ajaran_nama, group_cls, deskripsi
            from thn_ajaran_cls
            cross join group_cls
            on	group_cls = '$kode_jenjang'
            where thn_ajaran_cls = '$thn_ajaran_cls' ";                   
            
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }

    function get_data_siswa_exists($siswa_id, $nama_lengkap) {
        try {
            $query ="
            select  siswa_id, nama, nama_ayah, nama_ibu
            from    master_siswa_baru
            where   siswa_id = '$siswa_id'
            and     nama like '%$nama_lengkap%'
            ";  
           
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }


    function get_data_tbl_daftar_calon_siswa($kode_jenjang, $thn_ajaran_cls ) {
        try {    
            $query ="
            call sp_daftar_siswa_baru ('$kode_jenjang', '$thn_ajaran_cls')
            ";
            
            //return $this->db->query($query);
            return $query;
            
        } catch (error) {
            return error;
        }
    }

    function get_data_siswa_detail($siswa_id) {
        try {    
            $query ="
            call sp_siswa_detail ('$siswa_id')
            ";           
          
            return $query;
            
        } catch (error) {
            return error;
        }
    }


    function get_data_tbl_daftar_siswa_hasil_observasi_adm($kode_jenjang, $thn_ajaran_cls) {
        try {    
            $query ="
            SELECT ROW_NUMBER() OVER (ORDER BY no_pendaftaran) AS no_urut, q.*
            FROM (
            select no_pendaftaran, siswa_id, nama, alamat from master_siswa_baru
            where group_cls = '$kode_jenjang' and thn_ajaran_cls = '$thn_ajaran_cls'
            union all
            select nis, '' as siswa_id, nama, alamat from master_siswa_baru_upload
            where group_cls = '$kode_jenjang' and thn_ajaran_cls = '$thn_ajaran_cls'
            )q";                     
          
            //return $query;
            return $this->db->query($query);

        } catch (error) {
            return error;
        }
    }

    function get_data_tbl_daftar_siswa_hasil_observasi($kode_jenjang) {
        try {    
            $query ="
            SELECT  ROW_NUMBER() OVER (PARTITION BY q.thn_ajaran_cls ORDER BY q.thn_ajaran_cls DESC) AS no_urut
                ,   q.no_pendaftaran
                ,   q.siswa_id
                ,	q.nama
                ,	q.alamat
                ,	q.group_cls
                ,	IFNULL(q.thn_ajaran_cls, ho.thn_ajaran_cls) as thn_ajaran_cls
                ,  	ta.thn_ajaran_nama
                , 	IFNULL(ho.deskripsi,'') as deskripsi
            FROM (
            select  no_pendaftaran, siswa_id, nama, alamat, group_cls, thn_ajaran_cls 
            from    master_siswa_baru
            where   group_cls = '$kode_jenjang'
            union   all
            select  nis, '' as siswa_id, nama, alamat, group_cls, thn_ajaran_cls 
            from    master_siswa_baru_upload
            where   group_cls = '$kode_jenjang' 
            )q 
            left join hasil_observasi ho 
            on      q.group_cls = ho.group_cls 
            and     q.thn_ajaran_cls = ho.thn_ajaran_cls 
            left join thn_ajaran_cls ta
            on      IFNULL(q.thn_ajaran_cls, ho.thn_ajaran_cls) = ta.thn_ajaran_cls 
            order by q.thn_ajaran_cls desc";                     
                      
            //return $query;
            return $this->db->query($query);

        } catch (error) {
            return error;
        }
    }

    function get_data_tbl_brosur($kode_jenjang, $thn_ajaran_cls) {
        try {
             $query ="
             select keterangan_brosur, img_path, brosur_id
             from   brosur
             where  group_cls = '$kode_jenjang'
             and    thn_ajaran_cls = '$thn_ajaran_cls'
             ";
             return $query;
        } catch (error) {
            return error;
        }
    }

    function get_data_brosur($kode_jenjang) {
        try {
             $query ="
             select b.keterangan_brosur, b.img_path, b.brosur_id, b.thn_ajaran_cls, ta.thn_ajaran_nama
             from   brosur b
             left join thn_ajaran_cls ta
             on     b.thn_ajaran_cls = ta.thn_ajaran_cls
             where  b.group_cls = '$kode_jenjang'      
             order by b.thn_ajaran_cls desc
             ";
             return $query;
        } catch (error) {
            return error;
        }
    }

    function get_data_brosur_home() {
        try {
             $query ="
             select b.keterangan_brosur, b.img_path, b.brosur_id, b.thn_ajaran_cls, ta.thn_ajaran_nama, b.register_date
             from   brosur b
             left join thn_ajaran_cls ta
             on     b.thn_ajaran_cls = ta.thn_ajaran_cls             
             where  ta.thn_ajaran_nama is not null
             order  by b.register_date desc
             limit  6

             /*(select b.keterangan_brosur, b.img_path, b.brosur_id, b.thn_ajaran_cls, ta.thn_ajaran_nama, b.register_date
             from   brosur b
             left join thn_ajaran_cls ta
             on     b.thn_ajaran_cls = ta.thn_ajaran_cls
             where  b.group_cls = 'TKIT'
             order  by b.thn_ajaran_cls desc
             limit  1)
             union 
             (select b.keterangan_brosur, b.img_path, b.brosur_id, b.thn_ajaran_cls, ta.thn_ajaran_nama, b.register_date
             from   brosur b
             left join thn_ajaran_cls ta
             on     b.thn_ajaran_cls = ta.thn_ajaran_cls
             where  b.group_cls = 'SDIT'
             order  by b.thn_ajaran_cls desc
             limit  1)
             union
             (select b.keterangan_brosur, b.img_path, b.brosur_id, b.thn_ajaran_cls, ta.thn_ajaran_nama, b.register_date
             from   brosur b
             left join thn_ajaran_cls ta
             on     b.thn_ajaran_cls = ta.thn_ajaran_cls
             where  b.group_cls = 'SMPIT'
             order  by b.thn_ajaran_cls desc
             limit  1)*/
             ";

             return $this->db->query($query);
        } catch (error) {
            return error;
        }
    }
    
    function cek_data_konfirmasi_double($siswa_id){
        try {
            $query ="
            select  siswa_id
            from    konfirmasi_pembayaran
            where   siswa_id = '$siswa_id'           
            ";  
           
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }

    public function cek_thn_ajaran_exists($thn_ajaran){
        try {
            $query ="
            select  *
            from    thn_ajaran_cls
            where   thn_ajaran_cls = '$thn_ajaran'           
            ";             
            return $this->db->query($query);    
        } catch (error) {
            return error;
        }
    }
    
    public function cek_unit_sekolah_exists($unit_sekolah){
        try {
            $query ="
            select  *
            from    group_cls
            where   group_cls = '$unit_sekolah'           
            ";             
            return $this->db->query($query);    
        } catch (error) {
            return error;
        }
    }

    public function cek_nis_double($nis){
        try {
            $query ="
            select  nis
            from    master_siswa_baru_upload
            where   nis = '$nis'           
            ";  
           
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }
    
    function simpan_info_pendaftaran($list_thn_ajaran, $txt_kode_jenjang, $txt_info_pendaftaran, $username) {
        try {
            $query ="
            call sp_simpan_info_pendaftaran ('$list_thn_ajaran', '$txt_kode_jenjang', '$txt_info_pendaftaran', '$username')
            ";
            return $query;
    
        } catch (error) {
            return error;
        }
    }

    function simpan_konfirmasi_pembayaran($data) {
        extract($data); //extract data to variable
        $tgl_transfer = date('Y-m-d', strtotime($dt_tgl_transfer));  
        $jml_pembayaran =  preg_replace("/([^0-9\\.])/i", "", $txt_jml_pembayaran);
       
        $query = "
        insert into konfirmasi_pembayaran (
            siswa_id,          
            nama , 
            no_telp,            
            jml_pembayaran,
            nama_pemilik_rekening,
            tgl_transfer,
            pesan,
            path_bukti_transfer,
            register_date       
        ) 
        values 
        (
            '$txt_siswa_id',
            '$txt_nama_lengkap',     
            '$txt_no_telp',              
            '$jml_pembayaran',
            '$txt_nama_pemilik_rekening',
            '$tgl_transfer',
            '$txt_pesan',
            '$uploaded_image_konfirmasi_path',   
            now()
        )";

        return $query;
        
    } 
    
    function simpan_input_pendaftaran($data) {
        try {        
            extract($data); //extract data to variable
                       
            $tgl_lahir = date('Y-m-d', strtotime($dt_tgl_lahir));  
            $tgl_lahir_ayah = date('Y-m-d', strtotime($dt_tgl_lahir_ayah));  
            $tgl_lahir_ibu = date('Y-m-d', strtotime($dt_tgl_lahir_ibu));  
                       
            $query ="        
                insert into  master_siswa_baru 
                (	
                    thn_ajaran_cls,
                    group_cls,
                    no_pendaftaran,
                    jenis_pendaftaran,
                    kelas_cls,
                    nisn, 
                    nama,
                    nama_panggilan,
                    tempat_lahir,
                    tgl_lahir,
                    jenis_kelamin,
                    anak_ke,
                    jml_saudara,
                    golongan_darah,
                    no_hp,
                    alamat,
                    nama_sekolah_asal,
                    alamat_sekolah_asal,
                    berat_badan,
                    tinggi_badan,
                    sifat,
                    status_anak_inklusi,
                    status_bayar_biaya_inklusi,                  
                    nama_ayah,
                    tempat_lahir_ayah,
                    tgl_lahir_ayah,
                    agama_ayah,
                    pendidikan_ayah,
                    pekerjaan_ayah,                  
                    nama_ibu,
                    tempat_lahir_ibu,
                    tgl_lahir_ibu,
                    agama_ibu,                   
                    pendidikan_ibu,
                    pekerjaan_ibu,	
                    file_path_photo,
                    file_path_ktp_ayah,
                    file_path_ktp_ibu,
                    file_path_kk,
                    file_path_akta_kelahiran,                    
                    setuju,
                    register_date
                )
                select                 
                    '$txt_thn_ajaran_cls', /*thn_ajaran_cls*/
                    '$txt_kode_jenjang', /*group_cls*/
                    (select IFNULL(max(convert(no_pendaftaran, UNSIGNED)),0) + 1 from master_siswa_baru ), /*no_pendaftaran*/
                    ";
                    if($chk_siswa_baru_temp=='true'){
                        $query.="'siswa baru', /*jenis_pendaftaran*/
                                 'I', /*kelas_cls*/";    
                    }else{
                        $query.="'siswa pindahan', /*jenis_pendaftaran*/
                                '$txt_kelas', /*kelas_cls*/";    
                    }
                    $query.="
                    '$txt_nisn', /*nisn*/
                    '$txt_nama_lengkap', /*nama*/
                    '$txt_nama_panggilan', /*nama_panggilan*/
                    '$txt_tempat_lahir', /*tempat_lahir*/
                    '$tgl_lahir', /*tgl_lahir*/       
                    '$list_jenis_kelamin', /*jenis_kelamin*/                             	
                     $list_anak_ke, /*anak_ke*/
                     $list_jml_saudara, /*jml_saudara*/
                    '$txt_golongan_darah', /*golongan_darah*/
                    '$txt_no_hp', /*no_hp*/
                    '$txt_alamat_rumah', /*alamat*/                    
                    '$txt_nama_sekolah_asal', /*nama_sekolah_asal*/
                    '$txt_alamat_sekolah_asal', /*alamat_sekolah_asal*/
                     $txt_berat_badan, /*berat_badan*/
                     $txt_tinggi_badan, /*tinggi_badan*/";
                    /*sifat*/
                    if($chk_sifat_pendiam_temp=='true'){
                        $query.="'pendiam', ";                                   
                    }
                    if($chk_sifat_aktif_temp=='true'){
                        $query.="'aktif',";                                 
                    }
                    if($chk_sifat_sangat_aktif_temp=='true'){
                        $query.="'sangat aktif',";                                 
                    }
                    /*status_anak_inklusi*/
                    if($chk_status_ya_anak_inklusi_temp=='true'){
                        $query.="'Ya',";                                   
                    }else{
                        $query.="'Tidak',"; 
                    }
                    /*status_bayar_biaya_inklusi*/
                    if($chk_status_ya_membayar_biaya_inklusi_temp=='true'){
                        $query.="'Ya',";                                   
                    }else{
                        $query.="'Tidak',"; 
                    }

                    $query.="                 
                    '$txt_nama_ayah_kandung', /*nama_ayah*/
                    '$txt_tempat_lahir_ayah', /*tempat_lahir_ayah*/
                    '$tgl_lahir_ayah', /*tgl_lahir_ayah*/
                    '$list_agama_ayah', /*agama_ayah*/                    
                    '$list_pendidikan_ayah', /*pendidikan_ayah*/
                    '$txt_pekerjaan_ayah', /*pekerjaan_ayah*/                   
                    '$txt_nama_ibu_kandung', /*nama_ibu*/
                    '$txt_tempat_lahir_ibu', /*tempat_lahir_ibu*/
                    '$tgl_lahir_ibu', /*tgl_lahir_ibu*/
                    '$list_agama_ibu', /*agama_ibu*/      
                    '$list_pendidikan_ibu', /*pendidikan_ibu*/
                    '$txt_pekerjaan_ibu', /*pekerjaan_ibu*/
                    '$uploaded_file_photo_siswa', /*file_path_photo*/
                    '$uploaded_file_ktp_ayah', /*file_path_ktp_ayah*/
                    '$uploaded_file_ktp_ibu', /*file_path_ktp_ibu*/
                    '$uploaded_file_kk', /*file_path_kk*/
                    '$uploaded_file_akta_kelahiran', /*file_path_akta_kelahiran*/    
                     $chk_setuju_temp, /*setuju*/
                     now() /*register_date*/
                    ";                     
            return  $query;
    
        } catch (error) {
            return error;
        }
    }
    
    function simpan_hasil_observasi($data, $username) {
        extract($data); //extract data to variable                
        $query = "
            call sp_simpan_hasil_observasi ('$list_thn_ajaran', '$txt_kode_jenjang', '$dt_tgl_pengumuman', '$txt_deskripsi', '$username')
        ";
        return $query;
    }

    function get_data_hasil_observasi_adm($kode_jenjang, $thn_ajaran_cls){
         $query = "
            select tgl_pengumuman, deskripsi from hasil_observasi where thn_ajaran_cls = '$thn_ajaran_cls' and group_cls = '$kode_jenjang'
         ";
         return $query;
    }
    
    function get_data_hasil_observasi($kode_jenjang){
        $query = "
           select ho.tgl_pengumuman, ho.deskripsi, ho.thn_ajaran_cls , ta.thn_ajaran_nama
           from hasil_observasi ho
           left join thn_ajaran_cls ta
           on   ho.thn_ajaran_cls = ta.thn_ajaran_cls
           where group_cls = '$kode_jenjang'
        ";
        return $query;
    }

    function simpan_brosur($status_edit,
                            $brosur_id,
                            $kode_jenjang,
                            $thn_ajaran_cls,
                            $keterangan_brosur,                                                     
                            $uploaded_img_brosur_path,
                            $username) {                              
        try {        
            $ls_query = '';
            if($status_edit=='true'){
                $ls_query .="
                update  brosur
                set     group_cls = '$kode_jenjang',
                        thn_ajaran_cls = '$thn_ajaran_cls',
                        keterangan_brosur = '$keterangan_brosur', 
                        img_path = '$uploaded_img_brosur_path',
                        update_user = '$username',
                        update_date = now()
                where   brosur_id = '$brosur_id'
                ";
            }else{
                if($brosur_id>0){
                    $ls_query .="
                    update  brosur
                    set     group_cls = '$kode_jenjang',
                            thn_ajaran_cls = '$thn_ajaran_cls',
                            keterangan_brosur = '$keterangan_brosur', 
                            img_path = '$new_path_brosur',
                            update_user = '$username',
                            update_date = now()
                    where   brosur_id = '$brosur_id'
                    ";
                }else{
                    

                    $ls_query .="
                    insert  into brosur
                    (
                        group_cls,
                        thn_ajaran_cls,
                        keterangan_brosur,                       
                        img_path, 
                        register_user,
                        register_date,
                        update_user,
                        update_date
                    )
                    values  
                    (
                        '$kode_jenjang',
                        '$thn_ajaran_cls',
                        '$keterangan_brosur',                     
                        '$uploaded_img_brosur_path',
                        '$username',
                        now(),
                        '$username',
                        now()
                    )";
                }            
            }
               
            return $ls_query;
    
        } catch (error) {
            return error;
        }
    }
    
    function simpan_file_path($data, $username) {
        try {    
            extract($data);
            // var_dump($data);

                $ls_query ="
                update  master_siswa_baru
                set     file_path_photo = '$file_photo_siswa',
                        file_path_ktp_ayah = '$file_ktp_ayah',
                        file_path_ktp_ibu = '$file_ktp_ibu', 
                        file_path_kk = '$file_kk',
                        file_path_akta_kelahiran = '$file_akta_kelahiran'                       
                where   siswa_id = '$siswa_id'
                ";
                return $ls_query;
           
        } catch (error) {
            return error;
        }
    }

    function get_data_siswa_konfirmasi($siswa_id, $tgl_lahir) {
        try {
            $query ="
            select 	ms.siswa_id 
                ,	ms.nama
                ,	ms.nama_ayah
                ,	ms.nama_ibu
                ,	ms.no_hp
                ,	IFNULL(kp.jml_pembayaran,0) as jml_pembayaran
                ,	IFNULL(kp.nama_pemilik_rekening,'') as nama_pemilik_rekening
                ,	IFNULL(kp.tgl_transfer,'') as tgl_transfer
                ,	IFNULL(kp.pesan,'') as pesan
                ,	IFNULL(kp.path_bukti_transfer,'') as path_bukti_transfer
                ,   ms.thn_ajaran_cls
                ,   ms.group_cls
                ,   ta.thn_ajaran_nama
            from 	master_siswa_baru ms
            left join konfirmasi_pembayaran kp
            on      ms.siswa_id = kp.siswa_id
            left join thn_ajaran_cls ta
            on      ms.thn_ajaran_cls = ta.thn_ajaran_cls
            where 	ms.siswa_id = '$siswa_id'
            and 	ms.tgl_lahir = '$tgl_lahir'                   
            ";  
           
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }

}
?>