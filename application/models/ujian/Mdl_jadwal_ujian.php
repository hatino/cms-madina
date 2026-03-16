<?php 

class Mdl_jadwal_ujian extends ci_model
{
    function get_nama_mapel($mapel) {
        $query="
        select * from matapel_cls
        where   matapel_cls = '$mapel'
        ";
        return $this->db->query($query);
    }
    
    function get_tbl_jadwal_ujian($thnajaran, $jenjang, $semester, $kelas, $jenis_penilaian){
        $query="
            select 	bs.matapel_cls
                ,   ifnull(mc.deskripsi, pc.deskripsi) as deskripsi
                ,   IFNULL(DATE(ju.tgl),'') as tgl
                ,   IFNULL(DATE_FORMAT(ju.jam_mulai, '%H:%i'),'') as jam_mulai
                ,   IFNULL(DATE_FORMAT(ju.jam_selesai, '%H:%i'),'') as jam_selesai                
                ,   concat('PG (',IFNULL(pga.jml_pg,0),'/',bs.jml_soal_pg,'), Uraian (',IFNULL(esa.jml_essai,0),'/',bs.jml_soal_essai,')') as jml_soal               
                ,   bs.id as bank_soal_id
                ,   ju.bank_soal_id as id
                ,   case when IFNULL(pga.jml_pg,0) < bs.jml_soal_pg then 0
                         when IFNULL(esa.jml_essai,0) < bs.jml_soal_essai then 0
                         else 1 end as status_soal
                ,	ifnull(pc.status_ekskul,'0') as status_ekskul
            from 	bank_soal bs
            left join jadwal_ujian ju
            on 		bs.id = ju.bank_soal_id
            left join matapel_cls mc
            on 		bs.matapel_cls = mc.matapel_cls
            left join pembayaran_cls pc
            on 		bs.matapel_cls = pc.pembayaran_cls
            and 	pc.status_ekskul = '1'
            left join	(
                        select 	IFNULL(count(pertanyaan),0) as jml_pg
                            , 	bank_soal_id
                        from soal_pg                    
                        group by bank_soal_id
                        )sp
            on		bs.id = sp.bank_soal_id
            left join (
                        select 	IFNULL(count(pertanyaan),0) as jml_essai
                            , 	bank_soal_id
                        from soal_essai                    
                        group by bank_soal_id
            )se
            on		bs.id = se.bank_soal_id
            left join (
                    select 	count(pg.matapel_cls) jml_pg 
                        ,	pg.thnajaran_cls
                        ,	pg.semester
                        ,	pg.kelas_cls
                        ,	pg.matapel_cls
                        ,	pg.jenis_penilaian
                    from soal_pg pg   
                    group by pg.thnajaran_cls
                        ,	pg.semester
                        ,	pg.kelas_cls
                        ,	pg.matapel_cls
                        ,	pg.jenis_penilaian
            )pga
            on		bs.thnajaran_cls = pga.thnajaran_cls
            and		bs.semester = pga.semester
            and		bs.kelas_cls = pga.kelas_cls
            and		bs.matapel_cls = pga.matapel_cls
            and 	bs.jenis_penilaian = pga.jenis_penilaian
            left join (
                    select 	count(es.matapel_cls) jml_essai 
                        ,	es.thnajaran_cls
                        ,	es.semester
                        ,	es.kelas_cls
                        ,	es.matapel_cls
                        ,	es.jenis_penilaian
                    from soal_essai es   
                    group by es.thnajaran_cls
                        ,	es.semester
                        ,	es.kelas_cls
                        ,	es.matapel_cls
                        ,	es.jenis_penilaian
            )esa
            on		bs.thnajaran_cls = esa.thnajaran_cls
            and		bs.semester = esa.semester
            and		bs.kelas_cls = esa.kelas_cls
            and		bs.matapel_cls = esa.matapel_cls
            and 	bs.jenis_penilaian = esa.jenis_penilaian
            where   bs.thnajaran_cls = '$thnajaran'
            and		bs.kelas_cls = '$kelas'
            and		bs.semester = '$semester'
            and 	bs.jenis_penilaian = '$jenis_penilaian' 
            order by ju.tgl, ju.jam_mulai, mc.deskripsi           
        ";
        
        return $this->db->query($query);
    }

    function simpan_jadwal_ujian($data, $username) {
       
        extract($data);
        $txt_jam_mulai = $txt_tgl." ".$txt_jam_mulai;
        $txt_jam_selesai = $txt_tgl." ".$txt_jam_selesai;
               
        if($txt_id=="null"){
            $query =" 
            insert into jadwal_ujian (            
                thnajaran_cls,
                kelas_cls,
                matapel_cls,
                semester,
                jenis_penilaian,
                tgl,
                jam_mulai,
                jam_selesai,
                bank_soal_id,
                register_user,
                register_date,
                last_user,
                last_update  
            ) values (
                '$list_thnajaran',
                '$list_kelas',
                '$txt_mapel_cls',
                '$list_semester',
                '$list_jenis_penilaian',
                '$txt_tgl',
                '$txt_jam_mulai',
                '$txt_jam_selesai',
                '$txt_bank_soal_id',
                '$username',
                CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
                '$username',
                CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            )";
        }else{
            $query =" 
            update  jadwal_ujian
            set        
                tgl = '$txt_tgl',                
                jam_mulai = '$txt_jam_mulai',
                jam_selesai = '$txt_jam_selesai',                              
                last_user = '$username',
                last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            where
                bank_soal_id = '$txt_id'          
            ";
        }
                
        return $query;
    }
    
    function delete_jadwal_ujian($data) {
        extract($data);
        $query =" 
        delete  from jadwal_ujian      
        where   thnajaran_cls = '$list_thnajaran'
        and     kelas_cls = '$list_kelas'
        and     matapel_cls = '$mapel_cls'
        and     semester = '$list_semester'
        and     jenis_penilaian = '$list_jenis_penilaian'
        and     bank_soal_id = '$id'
        ";
        return $query;
    }

    function get_waktu_mengerjakan($bank_soal_id) {
        $query="
        select waktu_mengerjakan from bank_soal
        where id = '$bank_soal_id' ";
       
        return $this->db->query($query);
    }

    function get_data_jadwal_dashboard($user_id) {
        $query = "
                select  ju.matapel_cls
            , 	ifnull(mc.deskripsi, pc.deskripsi) as deskripsi
            ,	ju.jenis_penilaian
            ,	ju.semester
            ,	ju.thnajaran_cls
            ,	ju.jam_mulai
            ,	ju.jam_selesai    
            ,   ju.bank_soal_id
        from 	jadwal_ujian ju
        left join matapel_cls mc
        on 		ju.matapel_cls = mc.matapel_cls
        left join pembayaran_cls pc
        on 		ju.matapel_cls = pc.pembayaran_cls
        and 	pc.status_ekskul = '1'
        left join kelas_siswa ks
        on		ks.nis = '$user_id'
        and 	ju.kelas_cls = ks.kelas_cls
        where 	ju.tgl = left(CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),10)
        and 	left(CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),10) between ks.tgl_mulai and ks.tgl_selesai ";
        
        return $this->db->query($query);

    }

}

?>