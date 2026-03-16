<?php 

class Mdl_pelajaran extends ci_model
{
    function get_data_pelajaran($kode_jenjang) {
        try {
            $query ="
            select  group_cls, pelajaran
            from    pelajaran
            where   group_cls = '$kode_jenjang'
            ";
            return $this->db->query($query);
            
        } catch (error) {
            return error;
        }
    }

    function get_data_tbl_pelajaran($kode_jenjang) {
        try {
            $query ="
            select  up.group_cls, up.kelas, up.kelompok_mapel, up.nama_pelajaran, up.no_urut
            ,  	(
                select  count(kelas) as jml_kelas 
                from 	upload_mata_pelajaran um
                where 	up.group_cls = um.group_cls               
                and 	up.kelas = um.kelas
                ) as jml_kelas
            ,	(
                            select count(kelompok_mapel) as jml 
                            from 	upload_mata_pelajaran um
                            where 	up.group_cls = um.group_cls
                            and 	up.kelompok_mapel = um.kelompok_mapel
                            and 	up.kelas = um.kelas
                ) as jml
            from    upload_mata_pelajaran up          
            where   up.group_cls = '$kode_jenjang'
            order   by kelas, up.no_urut
            ";
            return $this->db->query($query);
            
        } catch (error) {
            return error;
        }
    }

    function cek_data_pelajaran_exists($kode_jenjang, $pelajaran) {
        try {
            $query ="
            select  count(nama_pelajaran) as jml
            from    upload_mata_pelajaran
            where   group_cls = '$kode_jenjang'
            and     nama_pelajaran = '$pelajaran'            
            ";
            return $this->db->query($query);
            
        } catch (error) {
            return error;
        }
    }

    function cek_upload_pelajaran_exists($unit_sekolah, $kelas, $nama_pelajaran ) {
        try {
            $query ="
            select  nama_pelajaran
            from    upload_mata_pelajaran
            where   group_cls = '$unit_sekolah'
            and     nama_pelajaran = '$nama_pelajaran'     
            and     kelas = '$kelas'       
            ";
            return $this->db->query($query);
            
        } catch (error) {
            return error;
        }
    }

    function get_data_pelajaran_home() {
        try {
            $query ="
            SELECT  um.group_cls
            FROM    upload_mata_pelajaran um
            LEFT JOIN group_cls gc
            on		um.group_cls = gc.group_cls
            group by um.group_cls, gc.no_urut
            order by gc.no_urut ";
            
            return $this->db->query($query);
            
        } catch (error) {
            return error;
        }
    }
    
}

?>