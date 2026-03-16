<?php

use LDAP\Result;

class Mdl_profil extends ci_model
{
	
    function get_data_profil_yayasan(){
        $query ="SELECT nama, alamat, telp, no_hotline, google_map, sejarah, photo_sejarah_path, visi, misi, photo_visi_path
                FROM    profil_yayasan";

        return $this->db->query($query);
    }

    function get_carousel_text() {
        $query ="SELECT carousel1, carousel2, carousel3
                FROM    carousel_text";
        return $this->db->query($query);
    }

    function get_data_profil_unit_sekolah($list_jenjang) {   
        $query ="SELECT nama
                    ,   alamat
                    ,   telp
                    ,   no_hotline
                    ,   nama_petugas
                    ,   visi
                    ,   misi
                    ,   photo_visi_path
                    ,   google_map
                    ,   case when nama_petugas = '' then '' else concat('(',nama_petugas,')') end as nama_petugas
                 FROM   profil_unit_sekolah
                 WHERE  group_cls = '$list_jenjang' ";       
        return $this->db->query($query);       
    }

    function get_data_kontak_unit($kode_jenjang) {   
        $query ="SELECT case when pu.group_cls = 'RA' then 'RA/TK' 
                             when pu.group_cls = 'MI' then 'MI/SD' 
                             else pu.group_cls end as group_cls
                    ,   nama
                    ,   no_hotline
                    ,   case when nama_petugas = '' then '' else concat('(',nama_petugas,')') end as nama_petugas
                 FROM   profil_unit_sekolah as pu
                 LEFT JOIN group_cls as gc 
                 ON     pu.group_cls = gc.group_cls 
                 WHERE  pu.group_cls = '$kode_jenjang'
                 ORDER BY gc.no_urut";
        
        return $this->db->query($query);       
    }

    function get_data_tbl_testimoni() {
        $query ="SELECT testimoni_id
                    ,   pemberi_testimoni
                    ,   testimoni
                 FROM   testimoni               
                 ";
        
        return $this->db->query($query);   
    }

    function simpan_carousel_text($data) {
        //var_dump($data);          
        $status_simpan=false;   
        extract($data, EXTR_SKIP);
        if ($txt_carousel1 != $txt_carousel1_temp){
            $status_simpan=true;
        };
        if ($txt_carousel2 != $txt_carousel2_temp){
            $status_simpan=true;
        };
        if ($txt_carousel3 != $txt_carousel3_temp){
            $status_simpan=true;
        };

        $query = "
        select * from carousel_text
        ";

        $hasil = $this->db->query($query);
        if ($hasil->num_rows() > 0){
            $query = "
            update carousel_text
            set carousel1 = '$txt_carousel1',
                carousel2 = '$txt_carousel2',
                carousel3 = '$txt_carousel3'
            ";
        }else{
            $query = "
            insert into carousel_text
            values ('$txt_carousel1', '$txt_carousel2', '$txt_carousel3' )
            ";
        }
        
        //var_dump($hasil);
       
        $this->db->query($query);
        return $status_simpan;
    } 
    
    function simpan_testimoni($_status_edit,
                              $_testimoni_id,
                              $pemberi_testimoni,
                              $testimoni,                            
                              $user_id) {
        try {                    

            $query = '';
            if($_status_edit=='true'){
                $query .="
                update  testimoni
                set     pemberi_testimoni = '$pemberi_testimoni',
                        testimoni = '$testimoni',                     
                        update_user = '$user_id',
                        update_date = now()
                where   testimoni_id = '$_testimoni_id'
                ";
            }else{
                if($_testimoni_id>0){
                    $query .="
                    update  testimoni
                    set     pemberi_testimoni = '$pemberi_testimoni',
                            testimoni = '$testimoni',                          
                            update_user = '$user_id',
                            update_date = now()
                    where   testimoni_id = '$_testimoni_id'
                    ";
                }else{
                    

                    $query .="
                    insert  into testimoni
                    (
                        pemberi_testimoni,
                        testimoni,                       
                        register_user,
                        register_date,
                        update_user,
                        update_date
                    )
                    values  
                    (
                        '$pemberi_testimoni',
                        '$testimoni',                      
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

    function get_data_visitors_today(){
        $query ="SELECT 
                       count(visitor_key) as jml_visitor_today
                FROM   visitors       
                WHERE  date(visit_time) = date(CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'));                
                ";
        
        return $this->db->query($query);   
    }

    function get_data_visitors_yesterday(){
        $query ="SELECT count(visitor_key) as jml_visitor_yesterday
                 from visitors
                 where datediff(CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'), visit_time) = 1;                  
                 ";
        
        return $this->db->query($query);   
    }

    function get_data_visitors_lastweek(){
        $query ="SELECT count(visitor_key) as jml_visitor_lastweek
                 from visitors
                 where datediff(CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'), visit_time) <= 7;                  
                 ";
        
        return $this->db->query($query);   
    }

    function get_data_visitors_online(){
        $query ="SELECT count(visitor_key) as jml_visitor_online
                 from visitors
                 where TIMESTAMPDIFF(MINUTE, visit_time, CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')) <= 5;                  
                 ";
        
        return $this->db->query($query);   
    }

    function get_data_visitors_total(){
        $query ="SELECT count(visitor_key) as jml_visitor_total
                 from visitors;                  
                 ";
        
        return $this->db->query($query);   
    }

}
?>