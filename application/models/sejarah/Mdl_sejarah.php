<?php 

class Mdl_sejarah extends ci_model
{

    function get_data_sejarah() {
        try {
            $query ="
            select  sejarah, photo_sejarah_path
            from    profil_yayasan
            ";
            return $this->db->query($query);
            
        } catch (error) {
            return error;
        }
    }
    
    function get_data_sejarah_yayasan_home() {
        try {
            $query ="
            select  sejarah, visi, misi, photo_sejarah_path
            from    profil_yayasan
            where 	sejarah <> '' or visi <> '' or misi <> ''
            ";
            return $this->db->query($query);
            
        } catch (error) {
            return error;
        }
    }

    function get_data_sejarah_yayasan() {
        try {
            $query ="
            select  sejarah, photo_sejarah_path
            from    profil_yayasan
            ";
            return $query;
            
        } catch (error) {
            return error;
        }
    }

    function get_data_sejarah_sekolah($kode_jenjang) {
        try {
            $query ="
            select  group_cls, sejarah_sekolah, meluluskan_angkatan_ke, photo_sejarah_sekolah_path
            from    sejarah_sekolah
            where   group_cls = '$kode_jenjang'
            ";
            return $query;
            
        } catch (error) {
            return error;
        }
    }

    function get_data_sejarah_unit_sekolah_home() {
        try {
            $query ="
            select  ss.group_cls, ss.sejarah_sekolah, ss.meluluskan_angkatan_ke, ss.photo_sejarah_sekolah_path, gc.deskripsi
            from    sejarah_sekolah ss
            left join group_cls gc 
            on      ss.group_cls = gc.group_cls
            order by gc.no_urut";
            
            return $this->db->query($query);
            
        } catch (error) {
            return error;
        }
    }
}
?>