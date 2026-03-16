<?php 

class Mdl_pembayaran extends ci_model
{
    function get_thn_ajaran() {
        $query="
        select 	thnajaran_cls
            ,   case when now() between tgl_mulai and tgl_selesai then '1' else '0' end as aktif 
        from 	master_thnajaran
        where 	thnajaran_cls in
        (
        select thnajaran_cls from pembayaran_siswa
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
        select  kelas_cls from kelas_siswa
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
        select  kelas_cls from kelas_siswa
        where   thnajaran_cls = '$thnajaran'
        group by kelas_cls       
        )
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
        select  subkelas_cls from kelas_siswa
        where   thnajaran_cls = '$thnajaran'
        group by subkelas_cls        
        )
        group by subkelas_cls
        ";
        return $this->db->query($query);        
    }

    function get_nama_siswa($thnajaran, $jenjang, $kelas, $subkelas) {                        
        $query ="
        select 	ps.nis, ms.nama  
        from    pembayaran_siswa ps
        left join master_siswa ms
        on      ps.nis = ms.nis
        left join (
                select * from kelas_siswa ks
                where   ks.thnajaran_cls = '$thnajaran'
        )kls
        on      ps.nis = kls.nis
        where   ps.thnajaran_cls = '$thnajaran'
        and     kls.kelas_cls = '$kelas'";

        if($subkelas != ''){
        $query .="
        and     kls.subkelas_cls = '$subkelas' ";        
        }

        $query .="
        group by ps.nis, ms.nama
        ";
        return $this->db->query($query); 
    }


    function get_data_tbl_pembayaran($par) {
        $thnajaran_cls = $par['thnajaran'];       
        $kelas_cls = $par['kelas'];
        $subkelas_cls = $par['subkelas'];       
        $nis = $par['nis'];       
        $lunas = $par['lunas'];

        $query ="
        call sp_tbl_pembayaran ('$thnajaran_cls', '$kelas_cls', '$subkelas_cls', '$nis', '$lunas')
        ";        
        return $this->db->query($query); 
    }

    function get_data_tbl_pembayaran_cms($par) {
        $thnajaran_cls = $par['thnajaran'];       
        $kelas_cls = $par['kelas'];

        $query ="
        select * from (
            select psd.nis, psd.transfer_date
            from pembayaran_siswa psd
            left join (
            select nis, kelas_cls, thnajaran_cls from kelas_siswa
            )ksa
            on psd.nis = ksa.nis and ksa.thnajaran_cls= '$thnajaran_cls'
            where ksa.kelas_cls = '$kelas_cls'    
        )q
        where (q.nis, q.transfer_date) in (
            select psd.nis, max(psd.transfer_date)
            from pembayaran_siswa psd
            left join (
            select nis, kelas_cls, thnajaran_cls from kelas_siswa
            )ksa
            on psd.nis = ksa.nis and ksa.thnajaran_cls= '$thnajaran_cls'
            where ksa.kelas_cls = '$kelas_cls' 
            group by psd.nis
        )
        group by q.nis, q.transfer_date
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