<?php 

class Mdl_raport extends ci_model
{
	function get_data_raport($par){
        $thnajaran_cls = $par['thnajaran'];
        $group_cls = $par['jenjang'];
        $kelas_cls = $par['kelas'];
        $subkelas_cls = $par['subkelas'];
        $semester = $par['semester'];
        $jenis_penilaian = $par['jenis_penilaian'];
        
        if($jenis_penilaian=='PTS'){
            $query ="
            select  rp.nis, rp.transfer_date 
            from    raport_siswa_detail rp
            left join setting_group_kelas gk 
            on      rp.kelas_cls = gk.kelas_cls
            and     rp.subkelas_cls = gk.subkelas_cls       
            where   thnajaran_cls = '$thnajaran_cls'  
            and     gk.group_cls = '$group_cls'
            and     rp.semester = '$semester'
            and     rp.kelas_cls = '$kelas_cls'
            ";
            if($subkelas_cls!=''){
                $query .="        
                and     rp.subkelas_cls = '$subkelas_cls' ";
            }
            
            $query .="       
            group by rp.nis, rp.transfer_date";

        }else{
            $query ="
            select  rp.nis, rp.transfer_date 
            from    raport_pas rp
            left join setting_group_kelas gk 
            on      rp.kelas_cls = gk.kelas_cls
            and     rp.subkelas_cls = gk.subkelas_cls       
            where   thnajaran_cls = '$thnajaran_cls'  
            and     gk.group_cls = '$group_cls'    
            and     rp.semester = '$semester'  
            and     rp.kelas_cls = '$kelas_cls'
            ";
            if($subkelas_cls!=''){
                $query .="        
                and     rp.subkelas_cls = '$subkelas_cls' ";
            }
            
            $query .="       
            group by rp.nis, rp.transfer_date";
        }
        //echo $query;
        return $this->db->query($query);        
    }

    function get_thn_ajaran() {
        $query="
        select 	thnajaran_cls
            ,   case when now() between tgl_mulai and tgl_selesai then '1' else '0' end as aktif 
        from 	master_thnajaran
        where 	thnajaran_cls in
        (
        select thnajaran_cls from raport_pas
        group by thnajaran_cls
        union 
        select thnajaran_cls from raport_siswa_detail
        group by thnajaran_cls
        )
        order by thnajaran_cls desc
        ";
        return $this->db->query($query);
    }

    function get_jenjang_pendidikan($thnajaran) {
        $query="
        select 	group_cls 
        from 	setting_group_kelas
        where 	kelas_cls in
        (
        select  kelas_cls from raport_pas
        where   thnajaran_cls = '$thnajaran'
        group by kelas_cls
        union 
        select kelas_cls from raport_siswa_detail
        where   thnajaran_cls = '$thnajaran'
        group by kelas_cls
        )
        group by group_cls
        ";
        return $this->db->query($query);
    }

    function get_kelas($thnajaran, $jenjang) {
        $query="
        select 	kelas_cls 
        from 	setting_group_kelas
        where   group_cls = '$jenjang'
        and 	kelas_cls in
        (
        select kelas_cls from raport_pas
        where   thnajaran_cls = '$thnajaran'
        group by kelas_cls
        union 
        select kelas_cls from raport_siswa_detail
        where   thnajaran_cls = '$thnajaran'
        group by kelas_cls
        )
        group by kelas_cls
        ";
        return $this->db->query($query);
    }
    
    function get_kelas_by_user($nis) {
        $query="
        select kelas_cls from raport_siswa_detail
        where nis = '$nis'
        group by kelas_cls
        union
        select kelas_cls from raport_pas
        where nis = '$nis'
        group by kelas_cls
        ";
        return $this->db->query($query);
    }

    function get_subkelas($thnajaran, $jenjang, $kelas) {
        $query="
        select 	subkelas_cls 
        from 	setting_group_kelas
        where   kelas_cls = '$kelas'
        and     group_cls = '$jenjang'
        and 	subkelas_cls in
        (
        select  subkelas_cls from raport_pas
        where   thnajaran_cls = '$thnajaran'
        group by subkelas_cls
        union 
        select  subkelas_cls from raport_siswa_detail
        where   thnajaran_cls = '$thnajaran'
        group by subkelas_cls
        )
        group by subkelas_cls
        ";
        return $this->db->query($query);
    }

    function get_data_tbl_raport($par) {
        $thnajaran_cls = $par['thnajaran'];       
        $kelas_cls = $par['kelas'];
        $subkelas_cls = $par['subkelas'];
        $semester = $par['semester'];
        $jenis_penilaian = $par['jenis_penilaian'];
        $nis = $par['nis'];
               
        if($jenis_penilaian=='PTS'){
            $query ="
            select 		rsd.matapel_cls, mc.deskripsi , rsd.kkm, rsd.nilai
                ,		CASE	WHEN rsd.nilai BETWEEN kt.a_min AND kt.a_max THEN 'A' 
                                WHEN rsd.nilai BETWEEN kt.b_min AND kt.b_max THEN 'B' 
                                WHEN rsd.nilai BETWEEN kt.c_min AND kt.c_max THEN 'C' 
                                ELSE 'D' END  as predikat
                ,		CASE WHEN rsd.Nilai BETWEEN kt.D_Min AND kt.D_Max THEN 'Tidak Tuntas' ELSE 'Tuntas' END as keterangan
                ,		case when mk.muatan_mapel = '' then 'Utama' else mk.muatan_mapel end as muatan_mapel
                ,       sq.jml_baris
                ,		round(sq2.total_nilai,0) as total_nilai
                ,		round(sq3.rerata_nilai,2) as rerata_nilai
            from 		raport_siswa_detail rsd
            left join  	matapel_cls mc
            on 			rsd.matapel_cls = mc.matapel_cls
            left join 	kriteria_tuntas kt
            on 			rsd.thnajaran_cls = kt.thnajaran_cls
            and			rsd.kelas_cls = kt.kelas_cls
            and 		rsd.matapel_cls = kt.matapel_cls
            left join 	matapel_kelas mk
            on 			rsd.thnajaran_cls = mk.thnajaran_cls
            and			rsd.kelas_cls = mk.kelas_cls
            and 		rsd.matapel_cls = mk.matapel_cls 
            left join 	(	
			                select count(muatan_mapel) as jml_baris, muatan_mapel, thnajaran_cls, kelas_cls 
                            from matapel_kelas			
			                group by    muatan_mapel, thnajaran_cls, kelas_cls				
                        )sq 
            on		    mk.thnajaran_cls = sq.thnajaran_cls and mk.kelas_cls = sq.kelas_cls and mk.muatan_mapel = sq.muatan_mapel
            left join 	(	
                            select nis, sum(nilai) as total_nilai , thnajaran_cls, kelas_cls
                            from 	raport_siswa_detail			
                            group by  nis, thnajaran_cls, kelas_cls				
			            )sq2
            on	        rsd.thnajaran_cls = sq2.thnajaran_cls and rsd.kelas_cls = sq2.kelas_cls and rsd.nis = sq2.nis
            left join 	(	
                        select nis, avg(nilai) as rerata_nilai , thnajaran_cls, kelas_cls
                        from 	raport_siswa_detail			
                        group by  nis, thnajaran_cls, kelas_cls				
                        )sq3
            on	        rsd.thnajaran_cls = sq3.thnajaran_cls and rsd.kelas_cls = sq3.kelas_cls and rsd.nis = sq3.nis
            where       
                        rsd.kelas_cls = '$kelas_cls'
            /*and       rsd.subkelas_cls = '$subkelas_cls'*/
            and         rsd.semester = '$semester'      
            and         rsd.nis = '$nis'
            /*and         rsd.thnajaran_cls = '$thnajaran_cls'*/
            order by    mk.muatan_mapel, no_urut";
            
        }else{
            $query ="
            select 		rp.matapel_cls, mc.deskripsi as nama_mapel , rp.kkm, rp.nilai
                ,		CASE	WHEN rp.nilai BETWEEN kt.a_min AND kt.a_max THEN 'A' 
                                WHEN rp.nilai BETWEEN kt.b_min AND kt.b_max THEN 'B' 
                                WHEN rp.nilai BETWEEN kt.c_min AND kt.c_max THEN 'C' 
                                ELSE 'D' END  as predikat
                ,		rp.deskripsi
                , 		rp2.nilai as nilai_ket
                ,		CASE	WHEN rp2.nilai BETWEEN kt2.a_min AND kt2.a_max THEN 'A' 
                                WHEN rp2.nilai BETWEEN kt2.b_min AND kt2.b_max THEN 'B' 
                                WHEN rp2.nilai BETWEEN kt2.c_min AND kt2.c_max THEN 'C' 
                                ELSE 'D' END  as predikat_ket
                ,		rp2.deskripsi as deskripsi_ket
                ,		case when mk.muatan_mapel = '' then 'Utama' else mk.muatan_mapel end as muatan_mapel
                ,       sq.jml_baris
                ,		round(sq2.total_nilai,0) as total_nilai
                ,		round(sq3.rerata_nilai,2) as rerata_nilai
            from (
            select 		nis, kelas_cls, semester, matapel_cls 
            from 		raport_pas
            where 		nis = '$nis'
            and			kelas_cls = '$kelas_cls'
            and			semester = $semester
            group by 	nis, kelas_cls, semester, matapel_cls
            )ms
            left join 	raport_pas rp
            on 			ms.nis = rp.nis
            and			ms.kelas_cls = rp.kelas_cls
            and			ms.semester = rp.semester
            and 		ms.matapel_cls = rp.matapel_cls
            and 		rp.aspek_jenis_kd = 'pengetahuan'
            left join 	raport_pas rp2
            on 			ms.nis = rp2.nis
            and			ms.kelas_cls = rp2.kelas_cls
            and			ms.semester = rp2.semester
            and 		ms.matapel_cls = rp2.matapel_cls
            and 		rp2.aspek_jenis_kd = 'keterampilan'
            left join  	matapel_cls mc
            on 			rp.matapel_cls = mc.matapel_cls
            left join 	kriteria_tuntas kt
            on 			rp.thnajaran_cls = kt.thnajaran_cls
            and			rp.kelas_cls = kt.kelas_cls
            and 		rp.matapel_cls = kt.matapel_cls
            left join 	kriteria_tuntas kt2
            on 			rp2.thnajaran_cls = kt2.thnajaran_cls
            and			rp2.kelas_cls = kt2.kelas_cls
            and 		rp2.matapel_cls = kt2.matapel_cls
            left join 	matapel_kelas mk
            on 			rp.thnajaran_cls = mk.thnajaran_cls
            and			rp.kelas_cls = mk.kelas_cls
            and 		rp.matapel_cls = mk.matapel_cls 
            left join 	(	
                            select count(muatan_mapel) as jml_baris, muatan_mapel, thnajaran_cls, kelas_cls 
                            from matapel_kelas			
                            group by    muatan_mapel, thnajaran_cls, kelas_cls				
                        )sq 
            on		    mk.thnajaran_cls = sq.thnajaran_cls and mk.kelas_cls = sq.kelas_cls and mk.muatan_mapel = sq.muatan_mapel
            left join 	(	
                            select nis, sum(nilai) as total_nilai , thnajaran_cls, kelas_cls
                            from 	raport_pas			
                            group by  nis, thnajaran_cls, kelas_cls				
                        )sq2
            on	        rp.thnajaran_cls = sq2.thnajaran_cls and rp.kelas_cls = sq2.kelas_cls and rp.nis = sq2.nis
            left join 	(	
                        select nis, avg(nilai) as rerata_nilai , thnajaran_cls, kelas_cls
                        from 	raport_pas			
                        group by  nis, thnajaran_cls, kelas_cls				
                        )sq3
            on	        rp.thnajaran_cls = sq3.thnajaran_cls and rp.kelas_cls = sq3.kelas_cls and rp.nis = sq3.nis
            where      
                        rp.kelas_cls = '$kelas_cls'
            /*and         subkelas_cls = '$subkelas_cls'*/
            and         rp.semester = '$semester'      
            and         rp.nis = '$nis'
            /*and         thnajaran_cls = '$thnajaran_cls'*/
            order by    mk.muatan_mapel, mk.no_urut
            ";
        }       
       
        return $this->db->query($query);        
    }

    function get_nama_siswa($par) {
        $thnajaran_cls = $par['thnajaran'];       
        $kelas_cls = $par['kelas'];
        $subkelas_cls = $par['subkelas'];
        $semester = $par['semester'];
        $jenis_penilaian = $par['jenis_penilaian'];
        
        if($jenis_penilaian=='PTS'){
            $query ="
            select 	nis, nama  
            from raport_siswa_detail";
        }else{
            $query ="
            select 	nis, nama  
            from raport_pas";
        }
        $query .="        
        where   thnajaran_cls = '$thnajaran_cls'
        and     kelas_cls = '$kelas_cls'
        and     subkelas_cls = '$subkelas_cls'
        and     semester = '$semester'   
        group by nis, nama
        ";
        return $this->db->query($query); 
    }

    function get_nama_siswa_by_user($par) {
        $user_id = $par['user_id'];
        $query ="
            select 	nis, nama  
            from    master_siswa
            where   nis = '$user_id' ";
        return $this->db->query($query); 
    }

}

?>