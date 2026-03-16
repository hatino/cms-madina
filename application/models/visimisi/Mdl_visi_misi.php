<?php 

class Mdl_visi_misi extends ci_model
{

    function get_data_visi_misi() {
        try {

            $query ="
            select  visi, misi, photo_visi_path
            from    profil_yayasan
            ";
            
            return $this->db->query($query);

        } catch (error) {
            return error;
        }
    }


    function get_data_visimisi_unit_sekolah($kode_jenjang) {
        try {
            $query ="
            select  visi, misi, photo_visi_path, nama
            from    profil_unit_sekolah
            where   group_cls = '$kode_jenjang'
            ";            
            return $this->db->query($query);

        } catch (error) {
            return error;
        }
    }

    function get_data_visimisi_yayasan() {
        try {
            $query ="
            select  visi, misi, photo_visi_path
            from    profil_yayasan
            ";
            return $query;
            
        } catch (error) {
            return error;
        }
    }



}




// module.exports={
//     get_data_visi_misi,
//     get_data_visimisi_unit_sekolah
// }

?>