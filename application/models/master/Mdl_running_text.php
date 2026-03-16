<?php 

class Mdl_running_text extends ci_model
{	
    function get_data_running_text() {
        $query ="SELECT  running_text_1, running_text_2
                 FROM    running_text_cms";
        return $this->db->query($query);
    }

    function cek_data_exists() {
        $query ="SELECT  count(running_text_1) as jml
                 FROM    running_text_cms";
        return $this->db->query($query);
    }

    // function simpan_running_text($data, $jml, $username) {
    //     extract($data);       
    //     if($jml>0){
    //         $query = "
    //         UPDATE  running_text
    //         SET     running_text_1 = '$txt_running_text_1'
    //             ,   running_text_2 = '$txt_running_text_2' 
    //             ,   update_user = '$username'
    //             ,   update_date = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
    //         ";
    //     }else{
    //         $query = "
    //         INSERT INTO running_text 
    //         VALUES ('$txt_running_text_1', ' $txt_running_text_2', '$username', CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00'), '$username', CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')) 
    //         ";
    //     }

    //     return $query;
    // }

    function simpan_running_text_cms($data, $jml, $username) {
        //extract($data);       
        if($jml>0){
            $query = "
            UPDATE  running_text_cms
            SET     running_text_1 = '".$data['txt_running_text_1']."'
                ,   running_text_2 = '".$data['txt_running_text_2']."' 
                ,   update_user = '".$username."'
                ,   update_date = CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
            ";
        }else{
            $query = "
            INSERT INTO running_text_cms 
            VALUES ('".$data['txt_running_text_1']."'
                ,   '".$data['txt_running_text_2']."'
                ,   '".$username."'
                ,   CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')
                ,   '".$username."', CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '+07:00')) 
            ";
        }

        return $query;
    }
}

?>