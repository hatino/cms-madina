<?php 

class Mdl_struktur extends ci_model
{
    function get_data_kelompok_jabatan(){       
        try {
            $query ="
            select  kelompok_jabatan
            from    master_kelompok_jabatan
            order by no_urut";            
            return $this->db->query($query);            
    
        } catch (error) {
            return error;
        }
    } 


    function get_data_tbl_struktur($kode_jenjang) {
        try {
            $query ="
            select  st.struktur_id, st.kelompok_jabatan, st.nama_jabatan, st.nama, st.no_urut, st.img_path
            from    struktur st
            left join master_kelompok_jabatan mk
            on      st.kelompok_jabatan = mk.kelompok_jabatan
            where   st.group_cls = '$kode_jenjang'
            order by mk.no_urut, st.no_urut";            
            return $this->db->query($query);            
    
        } catch (error) {
            return error;
        }
    } 

    function get_data_tbl_struktur_yayasan() {
        try {
            $query ="
            select  struktur_id, jabatan, nama, no_urut, img_path
            from    struktur_yayasan           
            order by no_urut";            
            return $query;            
    
        } catch (error) {
            return error;
        }
    } 

    function get_data_struktur($kode_jenjang, $kelompok_jabatan) {
        try {
            $query ="
            select  st.struktur_id, st.kelompok_jabatan, st.nama_jabatan, st.nama, st.no_urut, st.img_path
            from    struktur st
            left join master_kelompok_jabatan mk
            on      st.kelompok_jabatan = mk.kelompok_jabatan
            where   st.group_cls = '$kode_jenjang'
            and     st.kelompok_jabatan = '$kelompok_jabatan'
            order by mk.no_urut, st.no_urut";            
            return $this->db->query($query);            
    
        } catch (error) {
            return error;
        }
    } 
    
    function simpan_struktur($_status_edit,
                            $_struktur_id,
                            $_kode_jenjang,
                            $list_kelompok_jabatan,
                            $txt_jabatan,
                            $txt_nama,
                            $txt_no_urut,
                            $uploaded_img_struktur_path,
                            $user_id) {
        try {                    

            $ls_query = '';
            if($_status_edit=='true'){
                $ls_query .="
                update  struktur
                set     group_cls = '$_kode_jenjang',
                        kelompok_jabatan = '$list_kelompok_jabatan',
                        nama_jabatan = '$txt_jabatan',
                        nama = '$txt_nama',
                        no_urut = '$txt_no_urut',
                        img_path = '$uploaded_img_struktur_path',
                        update_user = '$user_id',
                        update_date = now()
                where   struktur_id = '$_struktur_id'
                ";
            }else{
                if($_struktur_id>0){
                    $ls_query .="
                    update  struktur
                    set     group_cls = '$_kode_jenjang',
                            kelompok_jabatan = '$list_kelompok_jabatan',
                            nama_jabatan = '$txt_jabatan',
                            nama = '$txt_nama',
                            no_urut = '$txt_no_urut',
                            img_path = '$uploaded_img_struktur_path'
                            update_user = '$user_id',
                            update_date = now()
                    where   struktur_id = '$_struktur_id'
                    ";
                }else{
                    $ls_query .="
                    insert  into struktur
                    (
                        group_cls,
                        kelompok_jabatan,
                        nama_jabatan,
                        nama,
                        no_urut,
                        img_path, 
                        register_user,
                        register_date,
                        update_user,
                        update_date
                    )
                    values  
                    (
                        '$_kode_jenjang',
                        '$list_kelompok_jabatan',
                        '$txt_jabatan',
                        '$txt_nama',
                        '$txt_no_urut',
                        '$uploaded_img_struktur_path',
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


    function simpan_struktur_yayasan($_status_edit,
                                    $_struktur_id,
                                    $txt_jabatan,
                                    $txt_nama,
                                    $txt_no_urut,
                                    $uploaded_img_struktur_path,
                                    $user_id) {
        try {                    

            $ls_query = '';
            if($_status_edit=='true'){
                $ls_query .="
                update  struktur_yayasan
                set                             
                        jabatan = '$txt_jabatan',
                        nama = '$txt_nama',
                        no_urut = '$txt_no_urut',
                        img_path = '$uploaded_img_struktur_path',
                        update_user = '$user_id',
                        update_date = now()
                where   struktur_id = '$_struktur_id'
                ";
            }else{
                if($_struktur_id>0){
                    $ls_query .="
                    update  struktur_yayasan
                    set     
                            jabatan = '$txt_jabatan',
                            nama = '$txt_nama',
                            no_urut = '$txt_no_urut',
                            img_path = '$uploaded_img_struktur_path'
                            update_user = '$user_id',
                            update_date = now()
                    where   struktur_id = '$_struktur_id'
                    ";
                }else{
                    $ls_query .="
                    insert  into struktur_yayasan
                    (                       
                        jabatan,
                        nama,
                        no_urut,
                        img_path, 
                        register_user,
                        register_date,
                        update_user,
                        update_date
                    )
                    values  
                    (                       
                        '$txt_jabatan',
                        '$txt_nama',
                        '$txt_no_urut',
                        '$uploaded_img_struktur_path',
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