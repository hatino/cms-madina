<?php
class Mdl_daftar_nilai extends CI_Model{
    function get_tbl_daftar_nilai($req) {
        $thnajaran= $req['thnajaran'];       
        $jenjang=$req['jenjang'];
        $kelas=$req['kelas'];
        $subkelas=$req['subkelas'];
        $semester=$req['semester'];                                                                        
        $jenis_penilaian=$req['jenis_penilaian'];
        $mapel=$req['mapel'];

        $query = "
            select 	ms.nis, ms.nama, ks.kelas_cls, ks.subkelas_cls, nu.nilai, bs.id as bank_soal_id
            from 	master_siswa ms
            left join (
                select * from kelas_siswa 
                where (nis, thnajaran_cls, kelas_cls, tgl_mulai) in 
                    ( select  nis,thnajaran_cls, kelas_cls,	max(tgl_mulai) 
                    from 		kelas_siswa 
                    where 	thnajaran_cls = '$thnajaran'   
                    and 		kelas_cls = '$kelas'
                    group by nis,thnajaran_cls, kelas_cls)
            )ks
            on 		ms.nis = ks.nis
            left join bank_soal bs
            on 		ks.thnajaran_cls = bs.thnajaran_cls
            and 	ks.kelas_cls = bs.kelas_cls
            and 	bs.semester = '$semester'
            and 	bs.jenis_penilaian = '$jenis_penilaian'
            and 	bs.matapel_cls = '$mapel'
            left join nilai_ujian nu 
            on 		bs.id = nu.bank_soal_id
            and 	ms.nis = nu.nis          
            where 	ks.thnajaran_cls = '$thnajaran'
            and		ks.kelas_cls = '$kelas'
            and 	ks.subkelas_cls = '$subkelas'
            and 	bs.semester = '$semester'
            and		bs.jenis_penilaian = '$jenis_penilaian'
            order by ms.nama
        ";
       
        return $this->db->query($query);
        
    }

    function get_data_tbl_hasil_ujian($req) {
        $thnajaran= $req['thnajaran'];
        $kelas=$req['kelas'];
        $subkelas=$req['subkelas'];
        $semester=$req['semester'];                                                                        
        $jenis_penilaian=$req['jenis_penilaian'];
        $mapel=$req['mapel'];
       
        $query="
        select 	ms.nis, ms.nama, ks.kelas_cls, ks.subkelas_cls
            ,	bs.matapel_cls                     
            ,   nu.nilai
            ,   ifnull(kds.no_kd,'') as no_kd
            ,	ifnull(mc.deskripsi, pc.deskripsi) as deskripsi
        from 	master_siswa ms
        left join (
            select * from kelas_siswa 
            where (nis, thnajaran_cls, kelas_cls, tgl_mulai) in 
                ( select  nis,thnajaran_cls, kelas_cls,	max(tgl_mulai) 
                from 		kelas_siswa 
                where 	thnajaran_cls = '$thnajaran'   
                and 		kelas_cls = '$kelas'
                group by nis,thnajaran_cls, kelas_cls)
        )ks
        on 		ms.nis = ks.nis
        left join bank_soal bs
        on 		ks.thnajaran_cls = bs.thnajaran_cls
        and 	ks.kelas_cls = bs.kelas_cls
        and 	bs.semester = '$semester'
        and 	bs.jenis_penilaian = '$jenis_penilaian'          
        left join (
            select nilai, bank_soal_id , nis
            from nilai_ujian            
        )nu
        on 		bs.id = nu.bank_soal_id
        and 	ms.nis = nu.nis        
        left join (
            select count(no_kd) as jml_kd, thnajaran_cls, kelas_cls, semester, jenis_penilaian , matapel_cls
            from kd_soal    
            group by thnajaran_cls, kelas_cls, semester, jenis_penilaian, matapel_cls
        )kd     on 	bs.thnajaran_cls = kd.thnajaran_cls
        and     bs.kelas_cls = kd.kelas_cls 
        and     bs.semester = kd.semester
        and     bs.jenis_penilaian = kd.jenis_penilaian
        and     bs.matapel_cls = kd.matapel_cls
        left join kd_soal kds
        on 		bs.thnajaran_cls = kds.thnajaran_cls
        and		bs.semester = kds.semester
        and 	bs.kelas_cls = kds.kelas_cls
        and 	bs.jenis_penilaian = kds.jenis_penilaian
        and 	bs.matapel_cls = kds.matapel_cls
        left join matapel_cls mc
        on 		bs.matapel_cls = mc.matapel_cls
        left join pembayaran_cls pc
        on		bs.matapel_cls = pc.pembayaran_cls
        and 	pc.status_ekskul = '1'
        where 	ks.thnajaran_cls = '$thnajaran'
        and		ks.kelas_cls = '$kelas'
        and 	ks.subkelas_cls = '$subkelas'
        and 	bs.semester = '$semester'
        and		bs.jenis_penilaian = '$jenis_penilaian'
        and 	IFNULL(nu.nilai,0) > 0";
        if($mapel!='SEMUA'){
        $query.="
        and		bs.matapel_cls = '$mapel' ";
        }
        $query.="     
        order by ms.nama, bs.matapel_cls, kds.no_kd;
        ";
        return $this->db->query($query);
    }

    function get_data_kd_soal($req) {
        $thnajaran= $req['thnajaran'];
        $kelas=$req['kelas'];
        $subkelas=$req['subkelas'];
        $semester=$req['semester'];                                                                        
        $jenis_penilaian=$req['jenis_penilaian'];
       
        $query="
        select  thnajaran_cls
            ,   kelas_cls
            ,   semester
            ,   jenis_penilaian
            ,   matapel_cls
            ,   no_kd 
        from kd_soal
        where 	thnajaran_cls = '$thnajaran'
        and		kelas_cls = '$kelas'       
        and 	semester = '$semester'
        and		jenis_penilaian = '$jenis_penilaian'
        ";
        return $this->db->query($query);
    }

    function get_data_soal($par) {      
        $thnajaran = $par['thnajaran'];
        $semester = $par['semester'];
        $kelas = $par['kelas'];
        $mapel = $par['mapel'];             
        $jenis_penilaian = $par['jenis_penilaian'];           
        $nis = $par['nis'];      
                                                                                
        $query="
        select  
                sp.id
            ,   sp.pertanyaan
            ,   sp.jawaban_a
            ,   sp.jawaban_b
            ,   sp.jawaban_c
            ,   sp.jawaban_d
            ,   sp.jawaban_e            
            ,   sp.kunci_jawaban
            ,   '' as kata_kunci_1
            ,   '' as kata_kunci_2
            ,   sp.img_path
            ,   sp.bank_soal_id
            ,   'pg' as jenis_soal
            ,	js.jawaban
            ,	js.nilai as nilai_bobot
            ,   sp.img_path_jawaban_a
            ,   sp.img_path_jawaban_b
            ,   sp.img_path_jawaban_c
            ,   sp.img_path_jawaban_d
        from    soal_pg sp
        left join jawab_soal_pg js
        on 		sp.bank_soal_id = js.bank_soal_id
        and 	sp.id = js.soal_id
        and 	js.nis = '".$nis."'
        where   thnajaran_cls = '$thnajaran'
        and     semester = '$semester'
        and     kelas_cls = '$kelas'
        and     matapel_cls = '$mapel'
        and     jenis_penilaian = '$jenis_penilaian'

        union all

        select  se.id 
            ,   se.pertanyaan
            ,   '' as jawaban_a
            ,   '' as jawaban_b
            ,   '' as jawaban_c
            ,   '' as jawaban_d
            ,   '' as jawaban_e            
            ,   '' as kunci_jawaban
            ,   se.kata_kunci_1
            ,   se.kata_kunci_2
            ,   se.img_path
            ,   se.bank_soal_id
            ,   'essai' as jenis_soal
            ,	IFNULL(js.jawaban,'') as jawaban
            ,	js.nilai as nilai_bobot
            ,   '' as img_path_jawaban_a
            ,   '' as img_path_jawaban_b
            ,   '' as img_path_jawaban_c
            ,   '' as img_path_jawaban_d
        from    soal_essai se
        left join jawab_soal_essai js
        on 		se.bank_soal_id = js.bank_soal_id
        and 	se.id = js.soal_id
        and 	js.nis = '".$nis."'
        where   thnajaran_cls = '$thnajaran'
        and     semester = '$semester'
        and     kelas_cls = '$kelas'
        and     matapel_cls = '$mapel'
        and     jenis_penilaian = '$jenis_penilaian'
        ";
        return $this->db->query($query);
    }

    function get_data_soal_uraian($par) {      
        $thnajaran = $par['thnajaran'];
        $semester = $par['semester'];
        $kelas = $par['kelas'];
        $mapel = $par['mapel'];             
        $jenis_penilaian = $par['jenis_penilaian'];           
        $nis = $par['nis'];      
                                                                                
        $query="
        select  se.id 
            ,   se.pertanyaan          
            ,   se.kata_kunci_1
            ,   se.kata_kunci_2
            ,   se.img_path
            ,   se.bank_soal_id
            ,   'essai' as jenis_soal
            ,	IFNULL(js.jawaban,'') as jawaban
            ,	js.nilai as nilai_bobot
        from    soal_essai se
        left join jawab_soal_essai js
        on 		se.bank_soal_id = js.bank_soal_id
        and 	se.id = js.soal_id
        and 	js.nis = '".$nis."'
        where   thnajaran_cls = '$thnajaran'
        and     semester = '$semester'
        and     kelas_cls = '$kelas'
        and     matapel_cls = '$mapel'
        and     jenis_penilaian = '$jenis_penilaian'
        ";
        return $this->db->query($query);
    }

    function get_nilai_siswa($par) {
        $query = "
        select	nu.nis, round(nu.nilai,0) as nilai
            ,   IFNULL(sp.jml_soal_pg,0) as jml_soal_pg
            ,   IFNULL(se.jml_soal_essai,0) as jml_soal_essai
            , 	IFNULL(jsp.jawab_benar_pg, 0) as jawab_benar_pg
            , 	IFNULL(jse.jawab_benar_essai,0) as jawab_benar_essai
            ,	IFNULL(jsp.bobot_nilai_pg, bn.bobot_pg) as bobot_nilai_pg
                /* jika jumlah soal mapel_pg > 0 maka bobot nilai essai = 0 berarti mapel khusus pg*/
            ,	IFNULL(jse.bobot_nilai_essai, bn.bobot_uraian) as bobot_nilai_essai
            ,	ks.kelas_cls
            ,	ks.subkelas_cls
        from 	nilai_ujian nu
        left join (
                select count(pertanyaan) as jml_soal_pg, bank_soal_id
                from soal_pg    
                group by bank_soal_id
        )sp	
        on 		nu.bank_soal_id = sp.bank_soal_id
        left join (
                select count(pertanyaan) as jml_soal_essai, bank_soal_id
                from soal_essai   
                group by bank_soal_id
        )se
        on 		nu.bank_soal_id = se.bank_soal_id
        left join (
                select nis, count(nilai) as jawab_benar_pg, bank_soal_id, bobot_nilai as bobot_nilai_pg
                from jawab_soal_pg
                where nilai > 0
                group by bank_soal_id, nis, bobot_nilai
        )jsp
        on		nu.bank_soal_id = jsp.bank_soal_id
        and 	nu.nis = jsp.nis
        left join (
                select nis, count(nilai) as jawab_benar_essai, bank_soal_id, bobot_nilai as bobot_nilai_essai
                from jawab_soal_essai
                where nilai > 0
                group by bank_soal_id, nis, bobot_nilai
        )jse
        on		nu.bank_soal_id = jse.bank_soal_id
        and 	nu.nis = jse.nis
        left join bank_soal bs
        on 		nu.bank_soal_id = bs.id
        left join kelas_siswa ks
        on 		nu.nis = ks.nis
        and 	bs.thnajaran_cls = ks.thnajaran_cls
        left join bobot_nilai bn
        on 		bs.kelas_cls = bn.kelas_cls
        and 	bs.semester = bn.semester
        left join mapel_pg mp
        on 		bs.kelas_cls = mp.kelas_cls
        and 	bs.semester = mp.semester
        and 	bs.matapel_cls = mp.matapel_cls
        where 	nu.nis = '".$par['nis']."'
        and     nu.bank_soal_id = '".$par['bank_soal_id']."'
        ";
        return $this->db->query($query);
    }

    function get_data_nilai_dashboard($user_id) {
        $query = "
        select ni.nis, nua.matapel_cls, nua.deskripsi, nua.nilai, nua.jenis_penilaian, nua.semester, nua.thnajaran_cls
        from 	(select '".$user_id."'as nis) as ni
        inner join (
            select 	nu1.*, ju1.matapel_cls, ifnull(mc.deskripsi, pc.deskripsi) as deskripsi, ju1.jenis_penilaian, ju1.semester, ju1.thnajaran_cls
            from 	nilai_ujian nu1
            left join jadwal_ujian ju1
            on		nu1.bank_soal_id = ju1.bank_soal_id
            left join matapel_cls mc
            on		ju1.matapel_cls = mc.matapel_cls
            left join pembayaran_cls pc
            on 		ju1.matapel_cls = pc.pembayaran_cls
            and 	pc.status_ekskul = '1'
            where 	(ju1.tgl, ju1.jam_mulai) in (
                select 	max(ju2.tgl), max(ju2.jam_mulai)
                from 	nilai_ujian nu2
                inner join jadwal_ujian ju2
                on 		nu2.bank_soal_id = ju2.bank_soal_id
                inner join master_thnajaran mt
                on 		ju2.tgl between mt.tgl_mulai and mt.tgl_selesai
                where 	convert_tz(utc_timestamp(),'+00:00','+07:00') between mt.tgl_mulai and mt.tgl_selesai  
                and 	ju2.jam_selesai < convert_tz(utc_timestamp(),'+00:00','+07:00')
                and 	nu1.nis = nu2.nis
                )
        )as nua
        on ni.nis = nua.nis
        ";
        return $this->db->query($query);
    }

    function get_tbl_daftar_nilai_siswa($req) {
        $thnajaran= $req['thnajaran'];      
        $semester=$req['semester'];                                                                        
        $jenis_penilaian=$req['jenis_penilaian'];
        $nis = $req['nis'];
       
        $query="
        select 	ms.nis
            ,   ms.nama
            ,   ks.kelas_cls
            ,   ks.subkelas_cls
            ,	bs.matapel_cls                     
            ,	mc.deskripsi
            ,   nu.nilai
            ,   bs.no_kd
        from 	master_siswa ms
        left join (
            select * from kelas_siswa 
            where (nis, thnajaran_cls, kelas_cls, tgl_mulai) in 
                ( select    nis,thnajaran_cls, kelas_cls,	max(tgl_mulai) 
                from 		kelas_siswa 
                where 	    thnajaran_cls = '$thnajaran'   
                and 		nis = '$nis'
                group by    nis,thnajaran_cls, kelas_cls)
        )ks
        on 		ms.nis = ks.nis
        left join bank_soal bs
        on 		ks.thnajaran_cls = bs.thnajaran_cls
        and 	ks.kelas_cls = bs.kelas_cls
        and 	bs.semester = '$semester'
        and 	bs.jenis_penilaian = '$jenis_penilaian'    
        left join matapel_cls mc
        on 		bs.matapel_cls = mc.matapel_cls      
        left join (
            select nilai, bank_soal_id , nis
            from nilai_ujian            
        )nu
        on 		bs.id = nu.bank_soal_id
        and 	ms.nis = nu.nis        
        where 	ks.thnajaran_cls = '$thnajaran'      
        and 	bs.semester = '$semester'
        and		bs.jenis_penilaian = '$jenis_penilaian'
        and     ms.nis = '$nis'
        and 	IFNULL(nu.nilai,0) > 0
        order by ms.nama
        ";     
        return $this->db->query($query);
    }


}

?>