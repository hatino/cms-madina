<?php 

class Mdl_input_soal extends ci_model
{

    function get_nama_mapel($mapel) {
        $query="
        select * from matapel_cls
        where   matapel_cls = '$mapel'
        ";
        return $this->db->query($query);
    }
    
    function get_deskripsi_thnajaran($thnajaran) {
        $query="
        select  right(deskripsi,9) as deskripsi 
        from    master_thnajaran
        where   thnajaran_cls = '$thnajaran'
        ";
        return $this->db->query($query);
    }

    function get_data_kd($data) {
        extract($data);
      
        $query="
        select  * 
        from    kompetensi_dasar 
        where   thnajaran_cls='$thnajaran'
        and     semester='$semester'
        and     kelas_cls='$kelas'
        and     matapel_cls='$mapel'
        ";
        
       return $this->db->query($query);
        
    }

    function delete_soal_pg($data) {
        $id = $data['soal_pg_id'];
        $query = "
        delete from soal_pg
        where id = '$id' ";
        return $query;
    }

    function delete_soal_essai($data) {
        $id = $data['soal_essai_id'];
        $query = "
        delete from soal_essai
        where id = '$id' ";
        return $query;
    }

    function simpan_input_soal_pg($data, $username) {               
        extract($data);
       
        $txt_pertanyaan = str_replace("'","''",$txt_pertanyaan);
        $txt_pertanyaan = str_replace("\\","\\\\",$txt_pertanyaan);
        $txt_jawaban_a = str_replace("'","''",$txt_jawaban_a);
        $txt_jawaban_a = str_replace("\\","\\\\",$txt_jawaban_a);
        $txt_jawaban_b = str_replace("'","''",$txt_jawaban_b);
        $txt_jawaban_b = str_replace("\\","\\\\",$txt_jawaban_b);
        $txt_jawaban_c = str_replace("'","''",$txt_jawaban_c);
        $txt_jawaban_c = str_replace("\\","\\\\",$txt_jawaban_c);
        $txt_jawaban_d = str_replace("'","''",$txt_jawaban_d);
        $txt_jawaban_d = str_replace("\\","\\\\",$txt_jawaban_d);
        // $txt_jawaban_e = str_replace("'","''",$txt_jawaban_e);

        if($txt_id==0||$txt_id==''){
            $query =" 
            insert into soal_pg (
                thnajaran_cls ,
                semester ,
                kelas_cls ,  
                matapel_cls ,
                jenis_penilaian ,
                /*tema_cls ,
                no_kd ,*/
                pertanyaan ,
                jawaban_a ,
                jawaban_b ,
                jawaban_c ,
                jawaban_d ,
                /*jawaban_e ,*/
                kunci_jawaban ,
                /*img_path ,*/
                bank_soal_id ,
                register_user ,
                register_date ,
                last_user ,
                last_update
            ) values (
                '$txt_thnajaran',
                '$txt_semester',
                '$txt_kelas',
                '$txt_mapel',
                '$txt_jenis_penilaian',
                '$txt_pertanyaan',    
                '$txt_jawaban_a',
                '$txt_jawaban_b',           
                '$txt_jawaban_c',
                '$txt_jawaban_d',                        
                '$rb_jawaban',
                '$txt_bank_soal_id',
                '$username',
                CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
                '$username',
                CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            )";
        }else{
            $query =" 
            update  soal_pg
            set        
                pertanyaan = RTRIM('$txt_pertanyaan'),                
                jawaban_a = RTRIM('$txt_jawaban_a'),
                jawaban_b = RTRIM('$txt_jawaban_b'),
                jawaban_c = RTRIM('$txt_jawaban_c'),        
                jawaban_d = RTRIM('$txt_jawaban_d'),                
                kunci_jawaban = '$rb_jawaban',
                last_user = '$username',
                last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            where id = '$txt_id'          
            ";
        }       
        return $query;    
    }

    
    function simpan_input_soal_essai($data, $username){
        extract($data);        
        
        $txt_pertanyaan = str_replace("'","''",$txt_pertanyaan);
        $txt_pertanyaan = str_replace("\\","\\\\",$txt_pertanyaan);
        $txt_kata_kunci_1 = str_replace("'","''",$txt_kata_kunci_1);
        $txt_kata_kunci_2 = str_replace("'","''",$txt_kata_kunci_2);
       
        if($txt_id==0||$txt_id==''){
            $query =" 
            insert into soal_essai (
                thnajaran_cls ,
                semester ,
                kelas_cls ,  
                matapel_cls ,
                jenis_penilaian ,                
                pertanyaan ,
                kata_kunci_1 ,
                kata_kunci_2 ,                             
                bank_soal_id ,
                register_user ,
                register_date ,
                last_user ,
                last_update
            ) values (
                '$txt_thnajaran',
                '$txt_semester',
                '$txt_kelas',
                '$txt_mapel',
                '$txt_jenis_penilaian',
                '$txt_pertanyaan',    
                '$txt_kata_kunci_1',
                '$txt_kata_kunci_2',
                '$txt_bank_soal_id',
                '$username',
                CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),
                '$username',
                CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            )";
        }else{
            $query =" 
            update  soal_essai
            set        
                pertanyaan = RTRIM('$txt_pertanyaan'),                
                kata_kunci_1 = RTRIM('$txt_kata_kunci_1'),
                kata_kunci_2 = RTRIM('$txt_kata_kunci_2'),                
                last_user = '$username',
                last_update = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            where id = '$txt_id'          
            ";
        }

       
        return $query; 
    }
    
    function get_data_tbl_penilaian_cms($par) {  
        $thnajaran = $par['thnajaran'];
        $kelas = $par['kelas'];
               
        $query="
        select * 
        from    kompetensi_dasar
        where   thnajaran_cls = '$thnajaran'
        and     kelas_cls = '$kelas'
        ";
        return $this->db->query($query);
    }

    function get_data_tbl_soal($par) {
        $thnajaran = $par['thnajaran'];
        $semester = $par['semester'];
        $kelas = $par['kelas'];
        $mapel = $par['mapel'];             
        $jenis_penilaian = $par['jenis_penilaian'];                 
                                                                                
        $query="
        select  
                id
            ,   pertanyaan
            ,   jawaban_a
            ,   jawaban_b
            ,   jawaban_c
            ,   jawaban_d
            ,   jawaban_e
            ,   kunci_jawaban
            ,   '' as kata_kunci_1
            ,   '' as kata_kunci_2
            ,   img_path
            ,   bank_soal_id
            ,   'pg' as jenis_soal
            ,   img_path_jawaban_a
            ,   img_path_jawaban_b
            ,   img_path_jawaban_c
            ,   img_path_jawaban_d
        from    soal_pg
        where   thnajaran_cls = '$thnajaran'
        and     semester = '$semester'
        and     kelas_cls = '$kelas'
        and     matapel_cls = '$mapel'
        and     jenis_penilaian = '$jenis_penilaian'

        union all

        select  id 
            ,   pertanyaan
            ,   '' as jawaban_a
            ,   '' as jawaban_b
            ,   '' as jawaban_c
            ,   '' as jawaban_d
            ,   '' as jawaban_e
            ,   '' as kunci_jawaban
            ,   kata_kunci_1
            ,   kata_kunci_2
            ,   img_path
            ,   bank_soal_id
            ,   'essai' as jenis_soal
            ,   '' as img_path_jawaban_a
            ,   '' as img_path_jawaban_b
            ,   '' as img_path_jawaban_c
            ,   '' as img_path_jawaban_d
        from    soal_essai
        where   thnajaran_cls = '$thnajaran'
        and     semester = '$semester'
        and     kelas_cls = '$kelas'
        and     matapel_cls = '$mapel'
        and     jenis_penilaian = '$jenis_penilaian'
        ";
        return $this->db->query($query);
    }

    function load_data_soal_essai($par){
        $thnajaran = $par['thnajaran'];
        $semester = $par['semester'];
        $kelas = $par['kelas'];
        $mapel = $par['mapel'];             
        $jenis_penilaian = $par['jenis_penilaian']; 
        $soal_essai_id = $par['soal_essai_id'];
                                                                                
        $query="
        select  * 
        from    soal_essai
        where   thnajaran_cls = '$thnajaran'
        and     semester = '$semester'
        and     kelas_cls = '$kelas'
        and     matapel_cls = '$mapel'
        and     jenis_penilaian = '$jenis_penilaian'
        and     id = '$soal_essai_id'
        ";
        return $this->db->query($query);
    }

    function load_data_soal_pg($par) {
        $thnajaran = $par['thnajaran'];
        $semester = $par['semester'];
        $kelas = $par['kelas'];
        $mapel = $par['mapel'];             
        $jenis_penilaian = $par['jenis_penilaian']; 
        $soal_pg_id = $par['soal_pg_id'];
                                                                                
        $query="
        select  * 
        from    soal_pg
        where   thnajaran_cls = '$thnajaran'
        and     semester = '$semester'
        and     kelas_cls = '$kelas'
        and     matapel_cls = '$mapel'
        and     jenis_penilaian = '$jenis_penilaian'
        and     id = '$soal_pg_id'
        ";
        return $this->db->query($query);
    }

    function get_data_soal_dashboard() {
        $query="
        select 	q.thnajaran_cls
            , 	q.kelas_cls
            , 	q.semester
            , 	q.jenis_penilaian
            , 	ju.tgl 
            , 	concat(IFNULL(sp.jml_soal_pg,0),'/',jml.jml_soal_pg,' (PG), ', IFNULL(es.jml_soal_essai,0),'/',jml.jml_soal_uraian, ' (Uraian)' ) as jml_soal
            ,	q.group_cls
            ,   jml.jml_mapel
            ,	jml.jml_soal_pg
            ,	jml.jml_soal_uraian
        from
        (
            select 	sp.thnajaran_cls
                ,	sp.kelas_cls
                ,	sp.semester
                ,	sp.jenis_penilaian  
                ,   sg.group_cls
            from bank_soal sp
            inner join master_thnajaran mt
            on		sp.thnajaran_cls = mt.thnajaran_cls
            left join (
                    select group_cls, kelas_cls from setting_group_kelas
                    group by group_cls, kelas_cls
            )sg
            on		sp.kelas_cls = sg.kelas_cls
            where 	date_format(now(),'%Y-%m-%d') between mt.tgl_mulai and mt.tgl_selesai
            group by sp.thnajaran_cls
                ,	sp.kelas_cls
                ,	sp.semester
                ,	sp.jenis_penilaian    
                ,	sg.group_cls
        )q
        left join (
                select 	max(tgl) as tgl
                    ,	thnajaran_cls          
                    ,	kelas_cls
                    ,	semester
                    ,	jenis_penilaian           
                from jadwal_ujian   
                group by 	thnajaran_cls          
                    ,	kelas_cls
                    ,	semester
                    ,	jenis_penilaian             
        )ju
        on 	q.thnajaran_cls = ju.thnajaran_cls
        and	q.semester = ju.semester
        and q.kelas_cls = ju.kelas_cls
        and q.jenis_penilaian = ju.jenis_penilaian
        left join (
            select 	count(pertanyaan) jml_soal_pg
                , 	thnajaran_cls
                ,	semester
                ,	kelas_cls
                ,	jenis_penilaian
            from 	soal_pg   
            group by thnajaran_cls
                ,	semester
                ,	kelas_cls
                ,	jenis_penilaian
        )sp
        on 	q.thnajaran_cls = sp.thnajaran_cls
        and	q.semester = sp.semester
        and q.kelas_cls = sp.kelas_cls
        and q.jenis_penilaian = sp.jenis_penilaian
        left join (
            select 	count(pertanyaan) jml_soal_essai
                , 	thnajaran_cls
                ,	semester
                ,	kelas_cls
                ,	jenis_penilaian
            from 	soal_essai   
            group by thnajaran_cls
                ,	semester
                ,	kelas_cls
                ,	jenis_penilaian
        )es
        on 	q.thnajaran_cls = es.thnajaran_cls
        and	q.semester = es.semester
        and q.kelas_cls = es.kelas_cls
        and q.jenis_penilaian = es.jenis_penilaian
        left join (
			select 	bs.thnajaran_cls
				, 	bs.semester
                ,	bs.kelas_cls
                ,	bs.jenis_penilaian
                ,	count(bs.matapel_cls) as  jml_mapel
				, 	(count(bs.matapel_cls)*bn.jml_soal_pg) as jml_soal_pg
                ,	(count(bs.matapel_cls)*bn.jml_soal_uraian) as jml_soal_uraian
			from bank_soal bs
			left join bobot_nilai bn
			on	bs.kelas_cls = bn.kelas_cls		
            and 	bs.semester = bn.semester	
			group by bs.thnajaran_cls, bs.semester, bs.kelas_cls,	bs.jenis_penilaian , bn.jml_soal_pg, bn.jml_soal_uraian
		) jml
		on 	q.thnajaran_cls = jml.thnajaran_cls
        and	q.semester = jml.semester
        and q.kelas_cls = jml.kelas_cls
        and q.jenis_penilaian = jml.jenis_penilaian
        where ju.tgl >= date_format(now(),'%Y-%m-%d')   
        order by q.thnajaran_cls, q.semester, q.jenis_penilaian, 	q.kelas_cls   
        ";
        return $this->db->query($query);
    }
}

?>