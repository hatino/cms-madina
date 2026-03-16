<?php 

class Mdl_kurikulum extends ci_model
{
	function get_data_kurikulum($kode_jenjang){
        $query ="SELECT group_cls, penjelasan, sistem_pembelajaran_nilai, img_path
                 FROM   kurikulum
                 WHERE  group_cls = '$kode_jenjang' ";

        return $this->db->query($query);
    }

    function get_data_kurikulum_home(){
        $query ="SELECT kk.group_cls, kk.penjelasan, kk.sistem_pembelajaran_nilai, kk.img_path
                 FROM   kurikulum  kk
                 LEFT JOIN group_cls gc
                 ON     kk.group_cls = gc.group_cls
                 ORDER BY gc.no_urut";         
        return $this->db->query($query);
    }
   
}
?>