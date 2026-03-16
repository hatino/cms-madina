<?php 
class Mdl_running_text extends CI_Model{

    function get_data_running_text() {
        $query = "
        select * from running_text_ujian";
        return $this->db->query($query);
    }

    function simpan_running_text($data, $jml, $username) {

        if($jml>0){
            $query = "
            UPDATE  running_text_ujian
            SET     running_text_1 = '".$data['txt_running_text_1']."',
                    update_user = '$username',
                    update_date = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            ";
        }else{
            $query = "
            INSERT INTO running_text_ujian 
            (running_text_1, register_user, register_date, update_user, update_date) 
            VALUES ('".$data['txt_running_text_1']."', '$username', CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'), '$username', CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')) 
            ";
        }

        return $query;
    }

    function hapus_running_text()  {
         $query = "
            DELETE FROM  running_text_ujian          
            ";
            return $query;
    }
}