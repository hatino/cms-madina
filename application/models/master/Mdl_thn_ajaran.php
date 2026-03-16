<?php 

class Mdl_thn_ajaran extends ci_model
{
    function get_data_thn_ajaran() {
        $query="SELECT  thn_ajaran_cls
                    ,   thn_ajaran_nama
                FROM    thn_ajaran_cls";
                    
        return $this->db->query($query);
    }

    function get_data_list_jenjang() {      
        $query ="SELECT group_cls
                    ,   deskripsi
                 FROM   group_cls
                 ORDER BY no_urut ";
        return $this->db->query($query); 
    }

    function get_thn_ajaran_exists($thn_ajaran_cls) {
        $query ="SELECT thn_ajaran_cls
                    ,   thn_ajaran_nama
                 FROM   thn_ajaran_cls
                 WHERE  thn_ajaran_cls = '$thn_ajaran_cls'";
        return $this->db->query($query);             
    }

    function cek_thn_ajaran_aktif($kode_jenjang) {         
        $query ="call sp_thn_ajaran_aktif('$kode_jenjang')" ;                        
        return $this->db->query($query);        
    }
    
    function cek_thn_ajaran_aktif_home() {         
        $query ="(
            select 	sp.group_cls, sp.thn_ajaran_cls, ta.thn_ajaran_nama
            from 	thn_ajaran_setting_pendaftaran sp
            left join thn_ajaran_cls ta
            on      sp.thn_ajaran_cls = ta.thn_ajaran_cls
            where 	sp.status_open = '1' and date_format(now(), '%Y-%m-%d') between sp.tgl_mulai_pendaftaran and sp.tgl_selesai_pendaftaran
            and 	sp.status_close = '0'
            and 	sp.group_cls = 'TKIT'
            limit 	1
            )
            union 
            (
            select 	sp.group_cls, sp.thn_ajaran_cls, ta.thn_ajaran_nama
            from 	thn_ajaran_setting_pendaftaran sp
            left join thn_ajaran_cls ta
            on      sp.thn_ajaran_cls = ta.thn_ajaran_cls
            where 	sp.status_open = '1' and date_format(now(), '%Y-%m-%d') between sp.tgl_mulai_pendaftaran and sp.tgl_selesai_pendaftaran
            and 	sp.status_close = '0'
            and 	sp.group_cls = 'SDIT'
            limit 	1
            )
            union 
            (
            select 	sp.group_cls, sp.thn_ajaran_cls, ta.thn_ajaran_nama
            from 	thn_ajaran_setting_pendaftaran sp
            left join thn_ajaran_cls ta
            on      sp.thn_ajaran_cls = ta.thn_ajaran_cls
            where 	sp.status_open = '1' and date_format(now(), '%Y-%m-%d') between sp.tgl_mulai_pendaftaran and sp.tgl_selesai_pendaftaran
            and 	sp.status_close = '0'
            and 	sp.group_cls = 'SMPIT'
            limit 	1
            )" ;                        
        return $this->db->query($query);        
    }

    function get_data_tbl_setting_thn_ajaran($kode_jenjang) {
        $query ="
        select 	ta.thn_ajaran_cls
            , 	thn_ajaran_nama  
            ,	IFNULL(sp.status_open,'0') as status_open    
            , 	IFNULL(sp.tgl_mulai_pendaftaran, '') tgl_mulai_pendaftaran
            , 	IFNULL(sp.tgl_selesai_pendaftaran, '') tgl_selesai_pendaftaran
            ,	IFNULL(sp.status_close,'0') as status_close
            ,	IFNULL(sp.tgl_close_pendaftaran,'') as tgl_close_pendaftaran
        from    thn_ajaran_cls as ta
        left join thn_ajaran_setting_pendaftaran as sp
        on 	    ta.thn_ajaran_cls = sp.thn_ajaran_cls
        and     sp.group_cls = '$kode_jenjang' ";  
          
        return $this->db->query($query);              
    }

    function simpan_mst_thn_ajran($status_edit, $thn_ajaran_cls, $thn_ajaran_nama, $user_id){          
        $query="";
            if($status_edit=='true'){
                $query .= "
                update  thn_ajaran_cls
                set     thn_ajaran_nama = '$thn_ajaran_nama',
                        update_user = '$user_id',
                        update_date = now()
                where   thn_ajaran_cls = '$thn_ajaran_cls'";
            }else{
                $query .= "
                insert  into thn_ajaran_cls
                (
                    thn_ajaran_cls,
                    thn_ajaran_nama,
                    register_user,
                    register_date,
                    update_user,
                    update_date
                )
                values  
                (
                    '$thn_ajaran_cls',
                    '$thn_ajaran_nama',
                    '$user_id',
                    now(),
                    '$user_id',
                    now()
                )";
            }
        
            return $query;       
    }

    function delete_mst_thn_ajran($thn_ajaran_cls) {
        $query ="DELETE FROM thn_ajaran_cls
                 WHERE  thn_ajaran_cls = '$thn_ajaran_cls' ";
        return $query;
    }


    function simpan_setting_thn_ajran($jenjang
                                    , $thn_ajaran
                                    , $chk_open
                                    , $dt_mulai
                                    , $dt_selesai
                                    , $chk_close
                                    , $dt_close
                                    , $user_id) 
    {
        $query="      
        call sp_simpan_thn_ajaran_setting_pendaftaran(
            '$jenjang',
            '$thn_ajaran',
            '$chk_open',
            '$dt_mulai',
            '$dt_selesai',
            '$chk_close',
            '$dt_close',
            '$user_id'     
        )";
       
        return $query;
    }

}



// async function get_data_thn_ajaran_with_status_open(par) {
//     try {
//         var ls_query =`
//         select  ta.thn_ajaran_cls
//             ,   ta.thn_ajaran_nama
//             ,	status_open
//         from    thn_ajaran_cls ta
//         left join thn_ajaran_setting_pendaftaran sp
//         on 		ta.thn_ajaran_cls = sp.thn_ajaran_cls
//         and 	sp.status_open = '1'
//         and 	sp.status_close = '0'
//         and 	group_cls = '`+par.kode_jenjang+`'
//         `
//         var conn = sql.createConnection(config)
//         conn.connect()
//         const [rs, fields] = await conn.promise().query(ls_query)
//         conn.end
//         return rs

//     } catch (error) {
//         return error;
//     }
// }



// async function simpan_mst_thn_ajran(par, user_id) {    
//     var ls_query
//     if(par.status_edit=='true'){
//         ls_query = `
//         update  thn_ajaran_cls
//         set     thn_ajaran_nama = '`+par.thn_ajaran_nama+`',
//                 update_user = '`+user_id+`',
//                 update_date = now()
//         where   thn_ajaran_cls = '`+par.thn_ajaran_cls+`'
//         `
//     }else{
//         ls_query = `
//         insert  into thn_ajaran_cls
//         (
//             thn_ajaran_cls,
//             thn_ajaran_nama,
//             register_user,
//             register_date,
//             update_user,
//             update_date
//         )
//         values  
//         (
//             '`+par.thn_ajaran_cls+`',
//             '`+par.thn_ajaran_nama+`',
//             '`+user_id+`',
//             now(),
//             '`+user_id+`',
//             now()
//         )`
//     }

//     return ls_query;
// }

// async function delete_mst_thn_ajran(par) {
//     var ls_query =`
//         delete from thn_ajaran_cls
//         where  thn_ajaran_cls = '`+par.thn_ajaran_cls+`'
//         `      
//     return ls_query
// }

// async function simpan_setting_thn_ajran(jenjang, thn_ajaran, chk_open, dt_mulai, dt_selesai, chk_close, dt_close, user_id) {
   
//         var ls_query=`        
//         call sp_simpan_thn_ajaran_setting_pendaftaran(
//             '`+jenjang+`',
//             '`+thn_ajaran+`',
//             '`+chk_open+`',
//             '`+dt_mulai+`',
//             '`+dt_selesai+`',
//             '`+chk_close+`',
//             '`+dt_close+`',
//             '`+user_id+`'     
//         )`
       
//     return ls_query;
// }

// async function get_thn_ajaran_exists(par) {
//     var ls_query =`
//         select  thn_ajaran_cls
//             ,   thn_ajaran_nama
//         from    thn_ajaran_cls
//         where   thn_ajaran_cls = '`+par.thn_ajaran_cls+`'
//         `      
//         var conn = sql.createConnection(config)
//         conn.connect()
//         const [rs, fields] = await conn.promise().query(ls_query)
//         conn.end
//         return rs
// }

// async function get_data_tbl_setting_thn_ajaran(jenjang) {
//     var ls_query =`
//         select 	ta.thn_ajaran_cls
//             , 	thn_ajaran_nama  
//             ,	IFNULL(sp.status_open,'0') as status_open    
//             , 	IFNULL(sp.tgl_mulai_pendaftaran, '') tgl_mulai_pendaftaran
//             , 	IFNULL(sp.tgl_selesai_pendaftaran, '') tgl_selesai_pendaftaran
//             ,	IFNULL(sp.status_close,'0') as status_close
//             ,	IFNULL(sp.tgl_close_pendaftaran,'') as tgl_close_pendaftaran
//         from    thn_ajaran_cls as ta
//         left join thn_ajaran_setting_pendaftaran as sp
//         on 	    ta.thn_ajaran_cls = sp.thn_ajaran_cls
//         and     sp.group_cls = '`+jenjang+`'
//         `             
//         var conn = sql.createConnection(config)
//         conn.connect()
//         const [rs, fields] = await conn.promise().query(ls_query)
//         conn.end
//         return rs
// }



// module.exports = {
//     get_data_thn_ajaran,
//     simpan_mst_thn_ajran,
//     get_thn_ajaran_exists,
//     delete_mst_thn_ajran,
//     get_data_tbl_setting_thn_ajaran,
//     get_data_list_jenjang,
//     simpan_setting_thn_ajran,
//     cek_thn_ajaran_aktif,
//     get_data_thn_ajaran_with_status_open
// }