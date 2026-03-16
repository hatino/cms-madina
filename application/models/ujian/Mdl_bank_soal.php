<?php 
class Mdl_bank_soal extends CI_Model{
	function get_mapel(){
        $query="
        select * from (
        select 	mk.matapel_cls, mc.deskripsi, '0' as stat_ekskul
        from 	matapel_kelas mk
        left join matapel_cls mc
        on 		mk.matapel_cls = mc.matapel_cls
        group by mk.matapel_cls      

        union all
      
        select pembayaran_cls, deskripsi, '1' as stat_ekskul
        from pembayaran_cls
        where status_ekskul = '1'       
        )q
        order by stat_ekskul, deskripsi
        ";
        return $this->db->query($query);
    }

    function get_data_exists($x){
        $thnajaran=$x['thnajaran'];
        $kelas=$x['kelas'];
        $mapel=$x['mapel'];
        $semester=$x['semester'];
        $jenis_penilaian = $x['jenis_penilaian'];

        $query="
        select * from bank_soal
        where
            thnajaran_cls = '$thnajaran'
        and kelas_cls = '$kelas'
        and matapel_cls = '$mapel'
        and semester = '$semester'
        and jenis_penilaian = '$jenis_penilaian'";
        return $this->db->query($query);
    }

    function simpan_bank_soal($data, $username) {
       
        extract($data);
        //bobot nilai
        $arr_bobot = explode(",",$txt_bobot_nilai);       
        $arr_bobot_pg = explode(": ",$arr_bobot[0]);
        $arr_bobot_uraian = explode(": ",$arr_bobot[1]);
        $bobot_pg = $arr_bobot_pg[1];
        $bobot_uraian = $arr_bobot_uraian[1];
        
        //waktu pengerjaan
        $arr_waktu = explode(",",$txt_waktu_pengerjaan);       
        $arr_waktu_pg = explode(": ",$arr_waktu[0]);
        $arr_waktu_uraian = explode(": ",$arr_waktu[1]);
        $waktu_pg = $arr_waktu_pg[1];
        $waktu_uraian = $arr_waktu_uraian[1];

        //jumlah soal
        $arr_jml_soal = explode(",",$txt_jml_soal);
        $arr_jml_soal_pg = explode(": ", $arr_jml_soal[0]);
        $arr_jml_soal_uraian = explode(": ",$arr_jml_soal[1]);      
        $jml_soal_pg = $arr_jml_soal_pg[1];
        $jml_soal_uraian = $arr_jml_soal_uraian[1];

        if($list_mapel_ori==''){
            $query =" 
            insert into bank_soal(            
                thnajaran_cls,
                kelas_cls,
                matapel_cls,
                semester,
                jenis_penilaian,
                waktu_pengerjaan_pg,
                waktu_pengerjaan_essai,
                bobot_pg,
                bobot_essai,
                -- no_kd,
                jml_soal_pg,
                jml_soal_essai,
                register_user,
                register_date,
                last_user,
                last_update  
            ) values (
                '$list_thnajaran',
                '$list_kelas',
                '$list_mapel',
                '$list_semester',
                '$list_jenis_penilaian',
                '$waktu_pg',
                '$waktu_uraian',
                '$bobot_pg',
                '$bobot_uraian',
                -- 'list_kd',
                '$jml_soal_pg',
                '$jml_soal_uraian',
                '$username',
                CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
                '$username',
                CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            )";
        }else{
            $query =" 
            update  bank_soal
            set        
                matapel_cls = '$list_mapel',                
                waktu_pengerjaan_pg = '$waktu_pg',
                waktu_pengerjaan_essai = '$waktu_uraian',
                bobot_pg = '$bobot_pg',
                bobot_essai = '$bobot_uraian',   
                jml_soal_pg = '$jml_soal_pg',
                jml_soal_essai = '$jml_soal_uraian',
                -- no_kd,            
                last_user = '$username',
                last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            where
                thnajaran_cls = '$list_thnajaran'
            and kelas_cls = '$list_kelas'
            and matapel_cls = '$list_mapel_ori'
            and semester = '$list_semester'
            and jenis_penilaian = '$list_jenis_penilaian'
            ";
        }
        
        return $query;
    }

    function delete_bank_soal($data) {
        extract($data);
        $query =" 
        delete  from bank_soal      
        where   thnajaran_cls = '$list_thnajaran'
        and     kelas_cls = '$list_kelas'
        and     matapel_cls = '$list_mapel'
        and     semester = '$list_semester'
        and     jenis_penilaian = '$list_jenis_penilaian'
        ";
        return $query;
    }

    function get_tbl_bank_soal($thnajaran, $jenjang, $semester, $kelas, $jenis_penilaian){
        $query="
            select  bs.matapel_cls
                , 	ifnull(mc.deskripsi, pc.deskripsi) as deskripsi
                ,	concat('PG (',bs.waktu_pengerjaan_pg,'), Uraian (',bs.waktu_pengerjaan_essai,')') as waktu_pengerjaan
                ,   bs.bobot_pg
                ,   bs.bobot_essai
                ,	concat('PG (',bs.bobot_pg,'), Uraian (',bs.bobot_essai,')') as bobot_nilai
                ,   concat('PG (',IFNULL(pga.jml_pg,0),'/',bs.jml_soal_pg,'), Uraian (',IFNULL(esa.jml_essai,0),'/',bs.jml_soal_essai,')') as jml_soal               
                ,   bs.id
                ,   IFNULL(ks.jml_kd,0) as no_kd
                ,   case when IFNULL(pga.jml_pg,0) < bs.jml_soal_pg then 0
						 when IFNULL(esa.jml_essai,0) < bs.jml_soal_essai then 0
                         else 1 end status_soal
            from    bank_soal bs         
            left join matapel_cls mc
            on      bs.matapel_cls = mc.matapel_cls
            left join pembayaran_cls pc
            on 		bs.matapel_cls = pc.pembayaran_cls
            and 	pc.status_ekskul = '1'
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
            left join (
                    select  count(no_kd) as jml_kd 
                        ,	thnajaran_cls
                        ,	semester
                        ,	kelas_cls
                        ,	matapel_cls
                        ,	jenis_penilaian   
                    from kd_soal
                    group by thnajaran_cls
                        ,	semester
                        ,	kelas_cls
                        ,	matapel_cls
                        ,	jenis_penilaian   
            )ks
            on		bs.thnajaran_cls = ks.thnajaran_cls
            and		bs.semester = ks.semester
            and		bs.kelas_cls = ks.kelas_cls
            and		bs.matapel_cls = ks.matapel_cls
            and 	bs.jenis_penilaian = ks.jenis_penilaian
            where 	bs.semester = '$semester'
            and     bs.kelas_cls = '$kelas'
            and		bs.thnajaran_cls = '$thnajaran' 
            and		bs.jenis_penilaian = '$jenis_penilaian' 
        ";
       
        return $this->db->query($query);
    }

    function get_jenjang_pendidikan($kelas){
        $query="
        select gc.group_cls, case when sgk.kelas_cls is not null then '1' else '0' end as flag
        from group_cls gc
        left join
            (
                select 	sg.group_cls, sg.kelas_cls 
                from 	setting_group_kelas sg
                where 	sg.kelas_cls = '$kelas'
                group by sg.group_cls, sg.kelas_cls
            )sgk
        on	gc.group_cls = sgk.group_cls
        where gc.no_urut IN (2,3)";
        return $this->db->query($query);
    }

    function get_kelas($jenjang) {
        $query="
        select  gk.kelas_cls 
        from    setting_group_kelas gk
        left join angka_rom_terbilang ar
        on      gk.kelas_cls = ar.angka
        where   gk.group_cls in ('$jenjang')";
        if($jenjang=='SDIT'){
        $query.="
        and     gk.kelas_cls in ('V','VI')";
        }
        $query.="
        group by gk.kelas_cls
        order by ar.angka_sort ";
        return $this->db->query($query);
    }

    function get_subkelas($kelas) {
        $query="
        select subkelas_cls 
        from setting_group_kelas
        where kelas_cls in ('$kelas')
        group by subkelas_cls";
        return $this->db->query($query);
    }

    function get_thn_ajaran() {
        $query="
        select 	thnajaran_cls
            ,   case when now() between tgl_mulai and tgl_selesai then '1' else '0' end as aktif 
        from 	master_thnajaran        
        order by thnajaran_cls desc
        ";
        return $this->db->query($query);
    }

    function get_tbl_guru($par) {
        $jenjang = $par['list_jenjang'];
        if($jenjang=='SDIT'){
            $query = "
            select q.*, sg.subkelas_cls , COALESCE(gk.nama_guru_kelas, gk2.nama_guru_kelas,'') as nama_guru
            from (
                select  '".$par['list_thnajaran']."' as thn_ajaran,
                        '".$par['list_jenjang']."' as jenjang,
                        '".$par['list_kelas']."' as kelas,
                        '".$par['list_semester']."' as semester,
                        '".$par['list_jenis_penilaian']."' as jenis_penilaian
            )q 
            left join setting_group_kelas sg
            on      q.kelas = sg.kelas_cls
            left join guru_kelas gk     
            on		q.thn_ajaran = gk.thnajaran_cls
            and 	q.kelas = gk.kelas_cls
            and 	sg.subkelas_cls = gk.subkelas_cls
            and 	q.semester = gk.semester
            and 	q.jenis_penilaian = gk.jenis_penilaian
            left join (
                select * from guru_kelas 
                where (thnajaran_cls, kelas_cls, subkelas_cls) IN
                    ( 
                    select max(thnajaran_cls), kelas_cls, subkelas_cls 
                    from guru_kelas
                    group by kelas_cls, subkelas_cls          
                    )
                order by semester desc
                limit 1    
                )gk2
            on 	q.kelas = gk2.kelas_cls
            and sg.subkelas_cls = gk2.subkelas_cls;
            ";
        }

        if($jenjang=='SMPIT'){
            $query = "
            select q.*, COALESCE(gp.nama_guru_pelajaran, gp2.nama_guru_pelajaran,'') as nama_guru
            from (
                select  '".$par['list_thnajaran']."' as thn_ajaran,
                        '".$par['list_jenjang']."' as jenjang,
                        '".$par['list_kelas']."' as kelas,
                        '".$par['list_semester']."' as semester,
                        '".$par['list_jenis_penilaian']."' as jenis_penilaian,
                        '".$par['list_mapel']."' as mapel
            )q 
            left join guru_pelajaran gp     
            on		q.thn_ajaran = gp.thnajaran_cls
            and 	q.kelas = gp.kelas_cls
            and 	q.semester = gp.semester
            and 	q.jenis_penilaian = gp.jenis_penilaian
            and 	q.mapel = gp.matapel_cls
            left join (
                select * from guru_pelajaran 
                where (thnajaran_cls, kelas_cls) IN
                    ( 
                    select max(thnajaran_cls), kelas_cls 
                    from guru_pelajaran
                    group by kelas_cls          
                    )	
                order by semester desc
                limit 1    
                )gp2
            on 	q.kelas = gp2.kelas_cls
            and q.mapel = gp2.matapel_cls
            ";
        }
        // echo $query;
        return $this->db->query($query);
    }

    function cek_nama_guru($data, $subkelas_cls, $nama_guru) {
        if($data['list_jenjang'] == 'SDIT'){
            $query = "
            select * from guru_kelas
            where   thnajaran_cls = '".$data['list_thnajaran']."' 
            and     kelas_cls = '".$data['list_kelas']."'
            and     subkelas_cls = '".$subkelas_cls."'
            and     semester = '".$data['list_semester']."'
            and     jenis_penilaian = '".$data['list_jenis_penilaian']."'
            ";
        }
        if ($data['list_jenjang'] == 'SMPIT'){
            $query = "
            select * from guru_pelajaran
            where   thnajaran_cls = '".$data['list_thnajaran']."' 
            and     kelas_cls = '".$data['list_kelas']."'           
            and     semester = '".$data['list_semester']."'
            and     jenis_penilaian = '".$data['list_jenis_penilaian']."'
            and     matapel_cls = '".$data['list_mapel']."'
            ";
        }
        
        return $this->db->query($query);
    } 

    function simpan_guru_kelas($data, $username, $subkelas_cls, $nama_guru, $rows){       
        if($rows>0){ 
            if($data['list_jenjang'] == 'SDIT'){   
                if ($nama_guru != ''){        
                    $query = "
                    update  guru_kelas
                    set     nama_guru_kelas = '".$nama_guru."'
                    where   thnajaran_cls = '".$data['list_thnajaran']."' 
                    and     kelas_cls = '".$data['list_kelas']."'
                    and     subkelas_cls = '".$subkelas_cls."'
                    and     semester = '".$data['list_semester']."'
                    and     jenis_penilaian = '".$data['list_jenis_penilaian']."'
                    ";
                }else{
                    $query = "
                    delete  from guru_kelas               
                    where   thnajaran_cls = '".$data['list_thnajaran']."' 
                    and     kelas_cls = '".$data['list_kelas']."'
                    and     subkelas_cls = '".$subkelas_cls."'
                    and     semester = '".$data['list_semester']."'
                    and     jenis_penilaian = '".$data['list_jenis_penilaian']."'
                    ";
                }

                return $query;
            }

            if($data['list_jenjang'] == 'SMPIT'){
                if ($nama_guru != ''){        
                    $query = "
                    update  guru_pelajaran
                    set     nama_guru_pelajaran = '".$nama_guru."'
                    where   thnajaran_cls = '".$data['list_thnajaran']."' 
                    and     kelas_cls = '".$data['list_kelas']."'                    
                    and     semester = '".$data['list_semester']."'
                    and     jenis_penilaian = '".$data['list_jenis_penilaian']."'
                    and     matapel_cls = '".$data['list_mapel']."'
                    ";
                }else{
                    $query = "
                    delete  from guru_pelajaran               
                    where   thnajaran_cls = '".$data['list_thnajaran']."' 
                    and     kelas_cls = '".$data['list_kelas']."'                    
                    and     semester = '".$data['list_semester']."'
                    and     jenis_penilaian = '".$data['list_jenis_penilaian']."'
                    and     matapel_cls = '".$data['list_mapel']."'
                    ";
                }

                return $query;
            }

        }else{
            if($data['list_jenjang'] == 'SDIT'){   
                if ($nama_guru != ''){
                    $query = "
                    insert into guru_kelas
                    (
                        id,
                        thnajaran_cls,
                        kelas_cls,
                        subkelas_cls,
                        semester,
                        jenis_penilaian,
                        nama_guru_kelas,
                        register_user,
                        register_date,
                        last_user,
                        last_update
                    )
                    values
                    (
                        (SELECT IFNULL(MAX(id), 0) + 1 FROM guru_kelas gk),
                        '".$data['list_thnajaran']."',
                        '".$data['list_kelas']."',
                        '".$subkelas_cls."',
                        '".$data['list_semester']."',
                        '".$data['list_jenis_penilaian']."',
                        '".$nama_guru."',
                        '".$username."',
                        CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
                        '".$username."',
                        CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                    )";

                    return $query;
                }
            }

            if($data['list_jenjang'] == 'SMPIT'){   
                if ($nama_guru != ''){
                    $query = "
                    insert into guru_pelajaran
                    (
                        id,
                        thnajaran_cls,
                        kelas_cls,
                        subkelas_cls,
                        semester,
                        jenis_penilaian,
                        matapel_cls,
                        nama_guru_pelajaran,
                        register_user,
                        register_date,
                        last_user,
                        last_update
                    )
                    values
                    (
                        (SELECT IFNULL(MAX(id), 0) + 1 FROM guru_pelajaran gp),
                        '".$data['list_thnajaran']."',
                        '".$data['list_kelas']."',
                        '-',
                        '".$data['list_semester']."',
                        '".$data['list_jenis_penilaian']."',
                        '".$data['list_mapel']."',
                        '".$nama_guru."',
                        '".$username."',
                        CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
                        '".$username."',
                        CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                    )";

                    return $query;
                }
            }            
        }
    }

    function get_data_bank_soal($bank_soal_id) {
        $query="
        select * from bank_soal 
        where id='".$bank_soal_id."' ";
        return $this->db->query($query);
    }
    
    function simpan_kd_soal($data, $username, $no_kd) {
        $query = "
        insert into kd_soal
        (
            id,
            thnajaran_cls,
            kelas_cls,            
            semester,
            jenis_penilaian,
            matapel_cls,
            no_kd,
            register_user,
            register_date,
            last_user,
            last_update
        )
        values
        (
            (SELECT IFNULL(MAX(id), 0) + 1 FROM kd_soal ks),
            '".$data['list_thnajaran']."',
            '".$data['list_kelas']."',           
            '".$data['list_semester']."',
            '".$data['list_jenis_penilaian']."',
            '".$data['list_mapel']."',
            '".$no_kd."',           
            '".$username."',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
            '".$username."',
            CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
        )";
        return $query;
    }

    function get_data_kd_exists($data) {
        $query = "
        select * 
        from    kd_soal
        where   thnajaran_cls = '".$data['thnajaran']."'
        and     kelas_cls = '".$data['kelas']."'          
        and     semester = '".$data['semester']."'
        and     jenis_penilaian = '".$data['jenis_penilaian']."'
        and     matapel_cls = '".$data['mapel']."'
        ";
        return $this->db->query($query);
    }

    function hapus_kd_soal($data){
        $query = "
        delete
        from    kd_soal
        where   thnajaran_cls = '".$data['list_thnajaran']."'
        and     kelas_cls = '".$data['list_kelas']."'          
        and     semester = '".$data['list_semester']."'
        and     jenis_penilaian = '".$data['list_jenis_penilaian']."'
        and     matapel_cls = '".$data['list_mapel']."'
        ";
        return $query;
    }
  
    function get_tbl_search_mapel($cari_mapel) {
        if ($cari_mapel!=''){
            $query="
            select * from (
            select 	mk.matapel_cls, mc.deskripsi, '0' as stat_ekskul
            from 	matapel_kelas mk
            left join matapel_cls mc
            on 		mk.matapel_cls = mc.matapel_cls
            group by mk.matapel_cls      

            union all
        
            select pembayaran_cls, deskripsi, '1' as stat_ekskul
            from pembayaran_cls
            where status_ekskul = '1'            
            )q
            where    q.deskripsi like '%$cari_mapel%'
            order by q.stat_ekskul, q.deskripsi            
            ";
        }else{
            $query="
            select * from (
            select 	mk.matapel_cls, mc.deskripsi, '0' as stat_ekskul
            from 	matapel_kelas mk
            left join matapel_cls mc
            on 		mk.matapel_cls = mc.matapel_cls
            group by mk.matapel_cls      

            union all
        
            select pembayaran_cls, deskripsi, '1' as stat_ekskul
            from pembayaran_cls
            where status_ekskul = '1'            
            )q
            order by q.stat_ekskul, q.deskripsi 
            ";
        }
        
    
        return $this->db->query($query);
    }

    function cek_soal_b4_delete($data){
        $query = "
        select bank_soal_id from soal_pg
        where bank_soal_id = '".$data['bank_soal_id']."'
        group by bank_soal_id
        union all
        select bank_soal_id from soal_essai
        where bank_soal_id = '".$data['bank_soal_id']."'
        group by bank_soal_id 
        ";
        
        return $this->db->query($query);
    }

}

?>