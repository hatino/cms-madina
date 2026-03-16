<?php 

class Mdl_lowongan extends ci_model
{        
    function get_data_tbl_lowongan() {
        try {
            $query ="
            select  lowongan_id
                ,   case when status_lowongan = '1' then 'Buka'else 'Tutup' end as status_lowongan
                ,   deskripsi_lowongan
                ,   img_path           
            from    lowongan          
            order by register_date desc
            ";                     
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }

    function get_data_lowongan() {
        try {
            $query ="
            select  lowongan_id               
                ,   deskripsi_lowongan
                ,   img_path           
            from    lowongan
            where   status_lowongan = '1'  
            order by register_date desc
            ";                     
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }
    
    function get_data_lowongan_home() {
        try {
            $query ="
            select  lowongan_id               
                ,   deskripsi_lowongan
                ,   img_path
                ,   register_date           
            from    lowongan
            where   status_lowongan = '1'  
            order by register_date desc
            limit 6
            ";                     
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }

    function simpan_lowongan($_status_edit,
                            $_lowongan_id,                           
                            $list_status_lowongan,                           
                            $txt_deskripsi_lowongan,
                            $uploaded_img_lowongan_path,
                            $user_id) {
        try {                    

            $ls_query = '';
            if($_status_edit=='true'){
                $ls_query .="
                update  lowongan
                set     status_lowongan = '$list_status_lowongan',                        
                        deskripsi_lowongan = '$txt_deskripsi_lowongan',
                        img_path = '$uploaded_img_lowongan_path',
                        update_user = '$user_id',
                        update_date = now()
                where   lowongan_id = '$_lowongan_id'
                ";
            }else{
                if($_lowongan_id>0){
                    $ls_query .="
                    update  lowongan
                    set     status_lowongan = '$list_status_lowongan',                           
                            deskripsi_lowongan = '$txt_deskripsi_lowongan',
                            img_path = '$uploaded_img_lowongan_path',
                            update_user = '$user_id',
                            update_date = now()
                    where   lowongan_id = '$_lowongan_id'
                    ";
                }else{
                    

                    $ls_query .="
                    insert  into lowongan
                    (                        
                        status_lowongan,                      
                        deskripsi_lowongan,
                        img_path, 
                        register_user,
                        register_date,
                        update_user,
                        update_date
                    )
                    values  
                    (
                        '$list_status_lowongan',
                        '$txt_deskripsi_lowongan',                       
                        '$uploaded_img_lowongan_path',
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