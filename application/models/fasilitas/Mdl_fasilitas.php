<?php 

class Mdl_fasilitas extends ci_model
{    
    function get_data_tbl_fasilitas($kode_jenjang) {
        try {
            $query ="
            select  fasilitas_id, group_cls, keterangan, img_path         
            from    fasilitas
            where   group_cls = '$kode_jenjang'           
            ";                              
            return $this->db->query($query);
    
        } catch (error) {
            return error;
        }
    }

    function get_data_fasilitas_home() {
        try {
            $query ="
            select  fasilitas_id, group_cls, keterangan, img_path         
            from    fasilitas
            limit 3      
            ";                              
            return $this->db->query($query);;
    
        } catch (error) {
            return error;
        }
    }


    function simpan_fasilitas($_status_edit,
                              $_fasilitas_id,
                              $_kode_jenjang,
                              $keterangan_fasilitas,                          
                              $uploaded_img_fasilitas_path,
                              $user_id) {
        try {                    

            $ls_query = '';
            if($_status_edit=='true'){
                if ($uploaded_img_fasilitas_path!=''){
                    $ls_query .="
                    update  fasilitas
                    set     keterangan = ?,              
                            img_path = ?,
                            update_user = ?,
                            update_date = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                    where   fasilitas_id = ?
                    ";

                    $result = $this->db->query($ls_query,[
                        $keterangan_fasilitas,
                        $uploaded_img_fasilitas_path,
                        $user_id,                   
                        $_fasilitas_id
                    ]);
                }else{
                    $ls_query .="
                    update  fasilitas
                    set     keterangan = ?,       
                            update_user = ?,
                            update_date = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                    where   fasilitas_id = ?
                    ";

                    $result = $this->db->query($ls_query,[
                        $keterangan_fasilitas,                       
                        $user_id,                   
                        $_fasilitas_id
                    ]);
                }                

                $affected = $this->db->affected_rows();

                return [
                    'status' => true,
                    'affected_rows' => $affected
                ];
               
            }else{
                if($_fasilitas_id>0){
                    $ls_query .="
                    update  fasilitas
                    set     keterangan = ?,              
                            img_path = ?,
                            update_user = ?,
                            update_date = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                    where   fasilitas_id = ?
                    ";

                    $result = $this->db->query($ls_query,[
                        $keterangan_fasilitas,
                        $uploaded_img_fasilitas_path,
                        $user_id,                        
                        $_fasilitas_id
                    ]);

                    $affected = $this->db->affected_rows();

                    return [
                        'status' => true,
                        'affected_rows' => $affected
                    ];
                    
                }else{
                    $ls_query .="
                    insert into fasilitas
                    (
                    group_cls,
                    keterangan,                   
                    img_path, 
                    register_user,
                    register_date,
                    update_user,
                    update_date
                    )
                    values  
                    (
                    ?,?,?,?,CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'),?,CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                    )";

                    $result = $this->db->query($ls_query,[
                        $_kode_jenjang,
                        $keterangan_fasilitas,
                        $uploaded_img_fasilitas_path,
                        $user_id,                        
                        $user_id                        
                    ]);

                    $affected = $this->db->affected_rows();
                    $insert_id = $this->db->insert_id();

                    return [
                        'status' => true,
                        'affected_rows' => $affected,
                        'fasilitas_id'=> $insert_id
                    ];                    
                }            
            }

        } catch (error) {
            //return error;
        }
    }
}

?>