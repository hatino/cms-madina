<?php 

class Mdl_berita extends ci_model
{    
    function get_data_berita_dtl($berita_id) {        
        try {
            $query ="
            select  berita_id, judul_berita, deskripsi_berita, img_path, img_path_2, img_path_3 , register_date           
            from    berita          
            where   berita_id = '$berita_id'
            ";                     
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }
    
    function get_data_berita_home() {        
        try {
            $query ="
            select  berita_id, judul_berita, deskripsi_berita, img_path_2, img_path_3, img_path , register_date           
            from    berita                      
            order by register_date desc
            limit 8
            ";                     
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }

    function simpan_berita($_status_edit,
                            $_berita_id,                           
                            $txt_judul_berita,                           
                            $txt_deskripsi_berita,                            
                            $user_id) {
        try {                    

            $ls_query = '';
            if($_status_edit=='true'){
                $ls_query .="
                update  berita
                set     judul_berita = '$txt_judul_berita',                        
                        deskripsi_berita = '$txt_deskripsi_berita',                        
                        update_user = '$user_id',
                        update_date = now()
                where   berita_id = '$_berita_id'
                ";
            }else{
                if($_berita_id>0){
                    $ls_query .="
                    update  berita
                    set     judul_berita = '$txt_judul_berita',                           
                            deskripsi_berita = '$txt_deskripsi_berita',                            
                            update_user = '$user_id',
                            update_date = now()
                    where   berita_id = '$_berita_id'
                    ";
                }else{
                    

                    $ls_query .="
                    insert  into berita
                    (                        
                        judul_berita,                      
                        deskripsi_berita,
                        img_path, 
                        register_user,
                        register_date,
                        update_user,
                        update_date
                    )
                    values  
                    (
                        '$txt_judul_berita',
                        '$txt_deskripsi_berita',                       
                        '',
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