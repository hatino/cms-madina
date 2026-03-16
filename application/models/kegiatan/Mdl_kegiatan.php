<?php 

class Mdl_kegiatan extends ci_model
{    
    function get_data_tbl_kegiatan($kode_jenjang) {
        try {
            $query ="
            select  kegiatan_id, nama_kegiatan, tgl_kegiatan, deskripsi, img_path            
            from    kegiatan
            where   group_cls = '$kode_jenjang'
            order by tgl_kegiatan desc
            ";                     
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }
    
    function simpan_kegiatan($_status_edit,
                            $_kegiatan_id,
                            $_kode_jenjang,
                            $txt_nama_kegiatan,
                            $dt_tgl_kegiatan,
                            $txt_deskripsi_kegiatan,
                            $uploaded_img_kegiatan_path,
                            $user_id) {
        try {                    

            $ls_query = '';
            if($_status_edit=='true'){
                $ls_query .="
                update  kegiatan
                set     nama_kegiatan = '$txt_nama_kegiatan',
                        tgl_kegiatan = '$dt_tgl_kegiatan',
                        deskripsi = '$txt_deskripsi_kegiatan',
                        img_path = '$uploaded_img_kegiatan_path',
                        update_user = '$user_id',
                        update_date = now()
                where   kegiatan_id = '$_kegiatan_id'
                ";
            }else{
                if($_kegiatan_id>0){
                    $ls_query .="
                    update  kegiatan
                    set     nama_kegiatan = '$txt_nama_kegiatan',
                            tgl_kegiatan = '$dt_tgl_kegiatan',
                            deskripsi = '$txt_deskripsi_kegiatan',
                            img_path = '$uploaded_img_kegiatan_path',
                            update_user = '$user_id',
                            update_date = now()
                    where   kegiatan_id = '$_kegiatan_id'
                    ";
                }else{
                    

                    $ls_query .="
                    insert  into kegiatan
                    (
                        group_cls,
                        nama_kegiatan,
                        tgl_kegiatan,
                        deskripsi,
                        img_path, 
                        register_user,
                        register_date,
                        update_user,
                        update_date
                    )
                    values  
                    (
                        '$_kode_jenjang',
                        '$txt_nama_kegiatan',
                        '$dt_tgl_kegiatan`',
                        '$txt_deskripsi_kegiatan',
                        '$uploaded_img_kegiatan_path',
                        '$user_id',
                        now(),
                        '$user_id',
                        now()
                    )";
                }            
            }
               
            return $ls_query;
    
        } catch (error) {
            return error;
        }
    }
    
}
?>