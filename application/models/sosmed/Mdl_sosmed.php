<?php 

class Mdl_sosmed extends ci_model
{
    function get_data_sosmed($list_sosmed) {
        try {
            $query ="
            select  sosmed_id, deskripsi, link_video, register_date          
            from    sosmed
            where   kode_sosmed = '$list_sosmed'
            order by register_date desc
            ";                     
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }

    function get_data_link_yt($kode_sosmed) {
        $query ="SELECT sosmed_id
                    ,   deskripsi
                    ,   link_video
                    ,   kode_sosmed
                 FROM   sosmed
                 WHERE  kode_sosmed = '$kode_sosmed'
                 ";
        
        return $this->db->query($query);   
    }
    
    function get_data_sosmed_dtl() {
        $query ="SELECT sosmed_id
                    ,   deskripsi
                    ,   link_video
                    ,   kode_sosmed
                 FROM   sosmed
                 ORDER BY kode_sosmed, register_date desc
                 ";
        
        return $this->db->query($query);   
    }



    function simpan_sosmed( $_status_edit,
                            $_sosmed_id,                                                        
                            $txt_deskripsi,
                            $txt_link_video,                                                      
                            $user_id,
                            $list_sosmed) {
        try {                    

            $query = '';
            if($_status_edit=='true'){
                $query .="
                update  sosmed
                set     deskripsi = '$txt_deskripsi',
                        link_video = '$txt_link_video',                        
                        update_user = '$user_id',
                        update_date = now()
                where   sosmed_id = '$_sosmed_id'
                ";
            }else{
                if($_sosmed_id>0){
                    $query .="
                    update  sosmed
                    set     deskripsi = '$txt_deskripsi',
                            link_video = '$txt_link_video',                           
                            update_user = '$user_id',
                            update_date = now()
                    where   sosmed_id = '$_sosmed_id'
                    ";
                }else{
                    

                    $query .="
                    insert  into sosmed
                    (
                        kode_sosmed,
                        deskripsi,
                        link_video,                        
                        register_user,
                        register_date,
                        update_user,
                        update_date
                    )
                    values  
                    (  
                        '$list_sosmed',                      
                        '$txt_deskripsi',
                        '$txt_link_video',                       
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