<?php 

class Mdl_jawab_soal extends ci_model {
    function get_data_adm($bank_soal_id, $username) {
        $query = "
        select  bs.matapel_cls
            ,   ifnull(mc.deskripsi, pec.deskripsi) as deskripsi
            ,   bs.waktu_mengerjakan
            ,   bs.jenis_penilaian 
            ,   pc.deskripsi as deskripsi_penilaian
            ,   bs.thnajaran_cls
            ,   right(mt.deskripsi,9) as deskripsi_thnajaran
            ,   bs.kelas_cls
            ,   bs.semester
            ,   bs.waktu_mengerjakan
            ,   ju.jam_mulai
            ,   ju.jam_selesai
            ,	sg.group_cls
			,   case when sg.group_cls = 'SDIT' then gk.nama_guru_kelas 
					 when sg.group_cls = 'SMPIT' then gp.nama_guru_pelajaran
                     end as nama_guru
            ,	ifnull(pec.status_ekskul,'0') as status_ekskul   
        from    bank_soal bs
        left join matapel_cls mc
        on	    bs.matapel_cls = mc.matapel_cls
        left join pembayaran_cls pec
        on 		bs.matapel_cls = pec.pembayaran_cls
        and 	pec.status_ekskul = '1'
        left join penilaian_cls pc
        on      bs.jenis_penilaian = pc.jenis_penilaian
        left join master_thnajaran mt
        on      bs.thnajaran_cls = mt.thnajaran_cls
        left join jadwal_ujian ju
        on      bs.id = ju.bank_soal_id
        left join (
			select group_cls, kelas_cls from setting_group_kelas             
            group by group_cls, kelas_cls
        )sg
        on bs.kelas_cls = sg.kelas_cls
		left join kelas_siswa ks
        on		bs.thnajaran_cls = ks.thnajaran_cls
        and  	ks.nis = '".$username."'
        left join guru_kelas gk
        on 		bs.thnajaran_cls = gk.thnajaran_cls
        and 	bs.kelas_cls = gk.kelas_cls
        and 	ks.subkelas_cls = gk.subkelas_cls
        and 	bs.semester = gk.semester
        and 	bs.jenis_penilaian = gk.jenis_penilaian    
        left join guru_pelajaran gp
        on 		bs.thnajaran_cls = gp.thnajaran_cls
        and 	bs.kelas_cls = gp.kelas_cls       
        and 	bs.semester = gp.semester
        and 	bs.jenis_penilaian = gp.jenis_penilaian    
        and 	bs.matapel_cls = gp.matapel_cls
        where   bs.id = '$bank_soal_id' ";
        
        return $this->db->query($query);
    }

    function get_data_siswa($username) {
        $query="
        select  nis
            ,   nama 
        from    master_siswa
        where   nis = '$username' ";
        return $this->db->query($query);
    }

    function get_data_soal_pg($bank_soal_id, $username) {
        $query = "
        select 	pg.pertanyaan
            ,	pg.jawaban_a
            ,	pg.jawaban_b
            ,	pg.jawaban_c
            ,	pg.jawaban_d
            ,	pg.jawaban_e
            ,	pg.img_path
            ,	pg.id
            ,   js.jawaban
        from    soal_pg pg
        left join jawab_soal_pg js
        on 	    pg.bank_soal_id = js.bank_soal_id
        and     pg.id = js.soal_id
        and 	js.nis = '".$username."'
        where   pg.bank_soal_id = '".$bank_soal_id."'
        ";
        return $this->db->query($query);
    }

    function get_data_soal_pg_db($bank_soal_id) {
        $query = "
        SELECT id,
            thnajaran_cls,
            semester,
            kelas_cls,
            matapel_cls,
            jenis_penilaian,
            tema_cls,
            no_kd,
            pertanyaan,
            jawaban_a,
            jawaban_b,
            jawaban_c,
            jawaban_d,
            jawaban_e,
            kunci_jawaban,
            img_path,
            bank_soal_id,
            img_path_jawaban_a,
            img_path_jawaban_b,
            img_path_jawaban_c,
            img_path_jawaban_d,
            register_user,
            register_date,
            last_user,
            last_update
        FROM soal_pg
        where   bank_soal_id = '".$bank_soal_id."';
        ";
        return $this->db->query($query);
    }

    function get_data_soal_essai_db($bank_soal_id) {
        $query = "
        SELECT id,
            thnajaran_cls,
            semester,
            kelas_cls,
            matapel_cls,
            jenis_penilaian,
            tema_cls,
            no_kd,
            pertanyaan,
            kata_kunci_1,
            kata_kunci_2,
            kata_kunci_3,
            kata_kunci_4,
            kata_kunci_5,
            img_path,
            bank_soal_id,
            register_user,
            register_date,
            last_user,
            last_update
        FROM soal_essai
        where   bank_soal_id = '".$bank_soal_id."';
        ";
        return $this->db->query($query);
    }


    function get_data_jawab_pg_db($bank_soal_id, $nis) {
        $query = "
        SELECT bank_soal_id,
            soal_id,
            nis,
            jawaban,
            kunci_jawaban,
            nilai,
            register_user,
            register_date,
            update_user,
            update_date,
            jml_soal,
            bobot_nilai
        FROM  jawab_soal_pg
        where bank_soal_id = '".$bank_soal_id."' 
        and   nis = '".$nis."' ";
        return $this->db->query($query);
    }

    function get_data_jawab_essai_db($bank_soal_id, $nis) {
        $query = "
        SELECT  bank_soal_id,
                soal_id,
                nis,
                jawaban,
                kata_kunci_1,
                kata_kunci_2,
                nilai,
                register_user,
                register_date,
                update_user,
                update_date,
                bobot_nilai,
                jml_soal
        FROM jawab_soal_essai
        where bank_soal_id = '".$bank_soal_id."' 
        and   nis = '".$nis."' ";
        return $this->db->query($query);
    }

    function get_data_soal_essai($bank_soal_id, $username) {
        $query = "
        select  se.pertanyaan
            ,   se.id
            ,   IFNULL(js.jawaban,'') as jawaban
            ,   se.img_path
        from    soal_essai se
        left join jawab_soal_essai js 
        on 	    se.bank_soal_id = js.bank_soal_id
        and     se.id = js.soal_id
        and 	js.nis = '".$username."'
        where   se.bank_soal_id = '$bank_soal_id'
        ";
        return $this->db->query($query);
    }

    function get_jumlah_jawab_soal($bank_soal_id, $username){
        $query = "
        select IFNULL(sum(jml_soal),0) as jml_soal, IFNULL(sum(jml_jawaban),0) as jml_jawaban
        from (
        select 	count(pertanyaan) as jml_soal , js.jml_jawaban as jml_jawaban
        from 	soal_pg sp
        left join (
                select 	count(jawaban) as jml_jawaban, bank_soal_id 
                from 	jawab_soal_pg   
                where 	IFNULL(jawaban,'') != ''
                and 	nis = '".$username."'
                group by bank_soal_id
        )js 
        on		sp.bank_soal_id = js.bank_soal_id
        where 	sp.bank_soal_id = '$bank_soal_id'
        group by js.jml_jawaban

        union all

        select count(pertanyaan) as jml_soal, js.jml_jawaban as jml_jawaban
        from soal_essai se
        left join (
                select 	count(jawaban) as jml_jawaban, bank_soal_id 
                from 	jawab_soal_essai   
                where 	IFNULL(jawaban,'') != ''
                and 	nis = '".$username."'
                group by bank_soal_id
        )js 
        on		se.bank_soal_id = js.bank_soal_id
        where 	se.bank_soal_id = '$bank_soal_id'
        )q ";
        
        return $this->db->query($query);
    }

    function hitung_nilai_pg($bank_soal_id, $soal_id, $nis, $jawaban) {
        $query = "
        select 	bs.thnajaran_cls, bs.kelas_cls, bs.matapel_cls, bs.semester, bs.jenis_penilaian
            ,	bs.bobot_pg, sp.kunci_jawaban, spa.jml_soal
            ,	case when sp.kunci_jawaban = '$jawaban' then bn.bobot_pg else 0 end as nilai
        from 	bank_soal bs
        left join soal_pg sp
        on		bs.id = sp.bank_soal_id
        left join (
            select count(pertanyaan) jml_soal, bank_soal_id 
            from soal_pg
            group by bank_soal_id
        )spa
        on		bs.id = spa.bank_soal_id
        left join bobot_nilai bn
        on      bs.kelas_cls = bn.kelas_cls
        and     bs.semester = bn.semester
        where 	bs.id = '$bank_soal_id'
        and		sp.id = '$soal_id'
        ";
        return $this->db->query($query);
    }

    function get_bobot_nilai($kelas, $semester) {
        $query = "
        select * from bobot_nilai
        where   kelas_cls = '".$kelas."'
        and     semester = '".$semester."'
        ";
        return $this->db->query($query);
    }

    function get_bobot_nilai_all($status_ekskul) {
        if($status_ekskul=='1'){
            $query = "select * from bobot_nilai_ekskul";
        }else{
            $query = "select * from bobot_nilai";
        }
        
        return $this->db->query($query);
    }

    function get_bobot_essai($bank_soal_id, $soal_id, $nis, $jawaban) {
        $query="
        select 	bs.thnajaran_cls, bs.kelas_cls, bs.matapel_cls, bs.semester, bs.jenis_penilaian
            ,	case when isnull(mc.matapel_cls) then bne.bobot_uraian else bn.bobot_uraian end as bobot_essai
            ,   sp.kata_kunci_1
            , 	sp.kata_kunci_2
            ,   spa.jml_soal
            ,	case when instr('$jawaban', sp.kata_kunci_1) > 0 && instr('$jawaban', sp.kata_kunci_2) > 0 
                     then bn.bobot_uraian else 0 end as nilai
        from 	bank_soal bs
        left join soal_essai sp
        on		bs.id = sp.bank_soal_id
        left join (
            select count(pertanyaan) jml_soal, bank_soal_id 
            from soal_essai
            group by bank_soal_id
        )spa
        on		bs.id = spa.bank_soal_id
        left join matapel_cls mc
        on		bs.matapel_cls = mc.matapel_cls
        left join pembayaran_cls pc
        on      bs.matapel_cls = pc.pembayaran_cls
        and     pc.status_ekskul = '1'
        left join bobot_nilai bn
        on      bs.kelas_cls = bn.kelas_cls
        and     bs.semester = bn.semester
        left join bobot_nilai_ekskul bne
        on      bs.kelas_cls = bne.kelas_cls
        and     bs.semester = bne.semester
        where 	bs.id = '$bank_soal_id'
        and		sp.id = '$soal_id' ";
        
        return $this->db->query($query);        
    }

    function hitung_nilai_essai($bank_soal_id, $soal_id, $kata_kunci_1, $kata_kunci_2, $nis, $akurasi_jwb_1, $akurasi_jwb_2) {
        $query="
        select  count(js.jawaban) status_jawaban, bn.bobot_uraian as nilai
        from 	jawab_soal_essai js
        left join bank_soal bs
        on 		js.bank_soal_id = bs.id
        left join bobot_nilai bn
        on      bs.kelas_cls = bn.kelas_cls
        and     bs.semester = bn.semester
        where 	bs.id = '".$bank_soal_id."'
        and		js.soal_id = '".$soal_id."' 
        and     js.nis = '".$nis."'
        -- and 	match(jawaban) against ('".$kata_kunci_1."' IN NATURAL LANGUAGE MODE) 
        -- and  	match(jawaban) against ('".$kata_kunci_2."' IN NATURAL LANGUAGE MODE) 
        and     ( ".$akurasi_jwb_1." >= 50 or ".$akurasi_jwb_2." >= 50)
        group by bn.bobot_uraian
        ";
       
        return $this->db->query($query); 
    }
    
}

?>