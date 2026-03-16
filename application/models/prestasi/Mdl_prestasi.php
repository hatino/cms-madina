<?php 

class Mdl_prestasi extends ci_model
{
	function get_data_tbl_prestasi($kode_jenjang){
        $query ="SELECT prestasi_id
                    ,   group_cls
                    ,   tgl_prestasi
                    ,   IFNULL(nama_siswa,'') as nama_siswa
                    ,   jenis_prestasi
                    ,   peringkat
                    ,   IFNULL(tingkat_lomba,'') as tingkat_lomba
                    ,   tempat_kegiatan
                    ,   img_path
                 FROM   prestasi
                 WHERE  group_cls = '$kode_jenjang' 
                 order by tgl_prestasi desc";

        return $this->db->query($query);
    }

    function get_data_prestasi_home() {
        $query = "SELECT prestasi_id
                    ,    group_cls
                    ,    tgl_prestasi
                    ,    jenis_prestasi
                    ,    peringkat
                    ,    tempat_kegiatan
                    ,    img_path
                    ,    register_date
                    ,    nama_siswa
                    ,    tingkat_lomba
                  FROM   prestasi                  
                  ORDER BY register_date desc
                  LIMIT  15 ";
        return $this->db->query($query);
    }
    
    function simpan_prestasi($_status_edit,
                             $_prestasi_id,
                             $_kode_jenjang,                          
                             $dt_tgl_prestasi,
                             $txt_nama_siswa,
                             $txt_jenis_prestasi,
                             $txt_peringkat,
                             $txt_tingkat_lomba,
                             $txt_tempat_kegiatan,
                             $uploaded_img_prestasi_path,
                             $username) {
        try {                    
            $query = '';
            if($_status_edit=='true'){
                $query .="
                update  prestasi
                set     tgl_prestasi = '$dt_tgl_prestasi',
                        nama_siswa = '$txt_nama_siswa',
                        jenis_prestasi = '$txt_jenis_prestasi',
                        peringkat = '$txt_peringkat',
                        tingkat_lomba = '$txt_tingkat_lomba',
                        tempat_kegiatan = '$txt_tempat_kegiatan',
                        img_path = '$uploaded_img_prestasi_path',
                        update_user = '$username',
                        update_date = now()
                where   prestasi_id = '$_prestasi_id'
                ";
            }else{
                if($_prestasi_id>0){
                    $query .="
                    update  prestasi
                    set     tgl_prestasi = '$dt_tgl_prestasi',
                            nama_siswa = '$txt_nama_siswa',
                            jenis_prestasi = '$txt_jenis_prestasi',
                            peringkat = '$txt_peringkat',
                            tingkat_lomba = '$txt_tingkat_lomba',
                            tempat_kegiatan = '$txt_tempat_kegiatan',
                            img_path = '$uploaded_img_prestasi_path',
                            update_user = '$username',
                            update_date = now()
                    where   prestasi_id = '$_prestasi_id'
                    ";
                }else{
                    

                    $query .="
                    insert  into prestasi
                    (
                        group_cls,
                        tgl_prestasi,
                        nama_siswa,
                        jenis_prestasi,
                        peringkat,
                        tingkat_lomba,
                        tempat_kegiatan,
                        img_path, 
                        register_user,
                        register_date,
                        update_user,
                        update_date
                    )
                    values  
                    (
                        '$_kode_jenjang',
                        '$dt_tgl_prestasi',
                        '$txt_nama_siswa',
                        '$txt_jenis_prestasi',
                        '$txt_peringkat',
                        '$txt_tingkat_lomba',
                        '$txt_tempat_kegiatan',
                        '$uploaded_img_prestasi_path',
                        '$username',
                        now(),
                        '$username',
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