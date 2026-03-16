<?php 
class Mdl_master extends CI_Model{

    function cek_data_exists() {
        $query = "
        select * from waktu_pengerjaan";
        return $this->db->query($query);
    }

    function get_data_waktu_pengerjaan_with_mapel($data) {
        $query ="call sp_get_waktu_pengerjaan('".$data['mapel']."','".$data['kelas']."','".$data['semester']."' )" ;                        
        return $this->db->query($query);    
    }
        
    function get_tbl_bobot_nilai($par){  
        $kelas = $par['list_kelas'];
        $semester = $par['list_semester'];

        $query = "
        select * from bobot_nilai 
        where   kelas_cls = '$kelas'
        and     semester = '$semester' ";        
        return $this->db->query($query);
    }

    function get_tbl_bobot_nilai_ekskul($par){  
        $kelas = $par['list_kelas'];
        $semester = $par['list_semester'];

        $query = "
        select * from bobot_nilai_ekskul 
        where   kelas_cls = '$kelas'
        and     semester = '$semester' ";        
        return $this->db->query($query);
    }

    function get_tbl_mapel_pg(){
        $query = "
        select  mp.*, ifnull(mc.deskripsi, pc.deskripsi) as deskripsi, sg.kelas_cls, sg.group_cls
        from mapel_pg mp
        left join matapel_cls mc
        on mp.matapel_cls = mc.matapel_cls
        left join pembayaran_cls pc
        on mp.matapel_cls = pc.pembayaran_cls
        and pc.status_ekskul = '1'
        left join ( 
            select group_cls, kelas_cls from setting_group_kelas
            group by group_cls, kelas_cls
        )sg
        on 	mp.kelas_cls = sg.kelas_cls
        left join angka_rom_terbilang ar
        on  sg.kelas_cls = ar.angka
        order by sg.group_cls, ar.angka_sort, mc.deskripsi, mp.semester";        
        return $this->db->query($query);
    }
    
    function get_tbl_waktu_permapel(){
        $query = "
        select  wp.*, ifnull(mc.deskripsi, pc.deskripsi) as deskripsi, sg.kelas_cls, sg.group_cls
        from waktu_pengerjaan_permapel wp
        left join matapel_cls mc
        on wp.matapel_cls = mc.matapel_cls
        left join pembayaran_cls pc
        on wp.matapel_cls = pc.pembayaran_cls
        and pc.status_ekskul = '1'
        left join ( 
            select group_cls, kelas_cls from setting_group_kelas
            group by group_cls, kelas_cls
        )sg
        on 	wp.kelas_cls = sg.kelas_cls
        left join angka_rom_terbilang ar
        on  sg.kelas_cls = ar.angka
        order by sg.group_cls, ar.angka_sort, mc.deskripsi, wp.semester";        
        return $this->db->query($query);
    }

    function get_mapel_pg($par) {
        $query = "
        select  mp.jml_soal as jml_soal_pg
            , 	0 as jml_soal_uraian
            ,	bn.bobot_pg
            ,	0 as bobot_uraian
        from    mapel_pg mp
        left join bobot_nilai bn
        on      mp.kelas_cls = bn.kelas_cls
        and 	mp.semester = bn.semester
        where   mp.matapel_cls = '".$par['list_mapel']."' 
        and     mp.semester = '".$par['list_semester']."' 
        and     mp.kelas_cls = '".$par['list_kelas']."'
        ";
        return $this->db->query($query);
    }
    
    function simpan_waktu_mengerjakan($data,$rows,$username){
        if($rows>0){
            $query = "
            update  waktu_pengerjaan
            set     soal_pg = '".$data['txt_pg']."', 
                    soal_uraian = '".$data['txt_uraian']."', 
                    last_user = '$username', 
                    last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')";            
        }else{
            $query = "
            insert into waktu_pengerjaan
            values (
            '".$data['txt_pg']."', 
            '".$data['txt_uraian']."',
            '$username',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
            '$username',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            )";               
        }
        return $query;
    }
    
    function simpan_waktu_permapel($data, $username){
        if($data['txt_seq_no']>0){
            $query = "
            update  waktu_pengerjaan_permapel
            set     kelas_cls = '".$data['list_kelas']."',
                    matapel_cls = '".$data['txt_mapel']."', 
                    semester = '".$data['list_semester']."',
                    soal_pg = ".$data['txt_waktu_pg'].", 
                    soal_uraian = '".$data['txt_waktu_uraian']."', 
                    last_user = '$username', 
                    last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            where   seq_no = '".$data['txt_seq_no']."' ";            
        }else{
            $query = "
            insert into waktu_pengerjaan_permapel
            (kelas_cls, matapel_cls, semester, soal_pg, soal_uraian, seq_no, register_user, register_date, last_user, last_update)
            values (
            '".$data['list_kelas']."', 
            '".$data['txt_mapel']."',
            '".$data['list_semester']."',
            ".$data['txt_waktu_pg'].",
            ".$data['txt_waktu_uraian'].",
            (select ifnull(max(seq_no),0) + 1 from waktu_pengerjaan_permapel mp),
            '$username',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
            '$username',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            )";               
        }
        return $query;
    }

    function simpan_bobot_nilai($data, $rows, $username) {
         if($rows>0){
            $query = "
            update  bobot_nilai
            set     bobot_pg = '".$data['txt_bobot_pg']."', 
                    bobot_uraian = '".$data['txt_bobot_uraian']."', 
                    jml_soal_pg = '".$data['txt_jml_pg']."',
                    jml_soal_uraian = '".$data['txt_jml_uraian']."',
                    last_user = '$username', 
                    last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            where   kelas_cls = '".$data['list_kelas']."' 
            and     semester = '".$data['list_semester']."' ";            
        }else{
            $query = "
            insert into bobot_nilai
            values (
            '".$data['list_kelas']."',
            '".$data['list_semester']."',
            '".$data['txt_bobot_pg']."', 
            '".$data['txt_bobot_uraian']."',
            '".$data['txt_jml_pg']."',
            '".$data['txt_jml_uraian']."',
            '$username',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
            '$username',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            )";               
        }
        return $query;
    }
    
    function simpan_bobot_nilai_ekskul($data, $rows, $username) {
         if($rows>0){
            $query = "
            update  bobot_nilai_ekskul
            set     bobot_pg = '".$data['txt_bobot_pg']."', 
                    bobot_uraian = '".$data['txt_bobot_uraian']."', 
                    jml_soal_pg = '".$data['txt_jml_pg']."',
                    jml_soal_uraian = '".$data['txt_jml_uraian']."',
                    last_user = '$username', 
                    last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            where   kelas_cls = '".$data['list_kelas']."' 
            and     semester = '".$data['list_semester']."' ";            
        }else{
            $query = "
            insert into bobot_nilai_ekskul (            
            kelas_cls,
            semester,
            bobot_pg,
            bobot_uraian,
            jml_soal_pg,
            jml_soal_uraian,
            register_user,
            register_date,
            last_user,
            last_update)
            values (
            '".$data['list_kelas']."',
            '".$data['list_semester']."',
            '".$data['txt_bobot_pg']."', 
            '".$data['txt_bobot_uraian']."',
            '".$data['txt_jml_pg']."',
            '".$data['txt_jml_uraian']."',
            '$username',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
            '$username',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            )";               
        }

        return $query;
    }

    function cek_mapel_pg_exists_insert($data){
        $query = "
        select * from mapel_pg 
        where   matapel_cls = '".$data['list_mapel']."' 
        and     semester = '".$data['list_semester']."' 
        and     kelas_cls = '".$data['list_kelas']."' 
        and     seq_no != '".$data['txt_seq_no']."'  ";            
        return $this->db->query($query);
    }

    function simpan_mapel_pg($data, $username) {
        if($data['txt_seq_no']>0){
            $query = "
            update  mapel_pg
            set     matapel_cls = '".$data['list_mapel']."', 
                    semester = '".$data['list_semester']."', 
                    jml_soal = '".$data['txt_jml_soal']."',          
                    kelas_cls = '".$data['list_kelas']."',
                    last_user = '$username', 
                    last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            where   seq_no = '".$data['txt_seq_no']."' ";                  
        }else{
            $query = "
            insert into mapel_pg
            (kelas_cls, matapel_cls, semester, jml_soal, seq_no, register_user, register_date, last_user, last_update)
            values (
            '".$data['list_kelas']."',
            '".$data['list_mapel']."',
            '".$data['list_semester']."',
            '".$data['txt_jml_soal']."', 
            (select ifnull(max(seq_no),0) + 1 from mapel_pg mp),            
            '$username',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
            '$username',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            )";               
        }
        return $query;
    }

    function get_thnajaran($thnajaran){
        $query = "
        select * from master_thnajaran where thnajaran_cls = '".$thnajaran."' ";
        return $this->db->query($query);
    }

    function get_nama_siswa($nis) {
        $query = "
        select * from master_siswa where nis = '".$nis."' ";
        return $this->db->query($query);
    }
}

?>