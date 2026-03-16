<?php 

class Mdl_ekstrakurikuler extends ci_model
{    
    function get_data_tbl_ekstrakurikuler($kode_jenjang) {
        try {
            $query ="
            select  ekstrakurikuler_id, group_cls, nama_ekstrakurikuler, img_path         
            from    ekstrakurikuler
            where   group_cls = '$kode_jenjang'           
            ";                              
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }

    function simpan_ekstrakurikuler($_status_edit,
                                    $_ekstrakurikuler_id,
                                    $_kode_jenjang,
                                    $txt_nama_ekstrakurikuler,                           
                                    $uploaded_img_ekstrakurikuler_path,
                                    $user_id) {
        try {                    

            $query = '';
            if($_status_edit=='true'){
                $query .="
                update  ekstrakurikuler
                set     nama_ekstrakurikuler = '$txt_nama_ekstrakurikuler',                      
                        img_path = '$uploaded_img_ekstrakurikuler_path',
                        update_user = '$user_id',
                        update_date = now()
                where   ekstrakurikuler_id = '$_ekstrakurikuler_id'
                ";
            }else{
                if($_ekstrakurikuler_id>0){
                    $query .="
                    update  ekstrakurikuler
                    set     nama_ekstrakurikuler = '$txt_nama_ekstrakurikuler',                           
                            img_path = '$new_path_ekstrakurikuler',
                            update_user = '$user_id',
                            update_date = now()
                    where   ekstrakurikuler_id = '$_ekstrakurikuler_id'
                    ";
                }else{
                    

                    $query .="
                    insert  into ekstrakurikuler
                    (
                        group_cls,
                        nama_ekstrakurikuler,                      
                        img_path, 
                        register_user,
                        register_date,
                        update_user,
                        update_date
                    )
                    values  
                    (
                        '$_kode_jenjang',
                        '$txt_nama_ekstrakurikuler',
                        '$uploaded_img_ekstrakurikuler_path',
                        '$user_id',
                        now(),
                        '$user_id',
                        now()
                    )";
                }            
            }
               
            return $query;
    
        } catch (error) {
            return error;
        }
    }



}

?>