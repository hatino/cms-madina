<?php
class Mdl_user extends CI_Model{

    function login($user_name,$password)
    {
        $query = $this->db->get_where('user_setup', array('rtrim(user_id)'=>$user_name));       
        //$query = $this->db->get_where('user_setup',array('rtrim(user_id)'=>$user_name,'rtrim(password)'=>$password));                
        
        if($query->num_rows()>0){
            //return 1;
            $rs = $query->row_array();                         
            $password_db = $rs['password'];
            $status_admin= $rs['status_admin'];

            if (password_verify($password, $password_db)) {
                return $status_admin;
            } else {
                $status_admin = '-1';
                return $status_admin;
            }
            
            // foreach($rs as $d){               
            //     $status_admin = $d->status_admin;
            // }
            
            // return json_encode(array('status_user'=>$satus_user, 'status_admin'=>$status_admin));
        }
        
        
        $query = $this->db->get_where('user_setup_siswa',array('user_id'=>$user_name,'password'=>$password));
        if($query->num_rows()>0){
            // return 1;           
            $status_admin = '2';
            return $status_admin;
            // return json_encode(array('status_user'=>$satus_user, 'status_admin'=>$status_admin));
        }else{
            //return 0;
            $status_admin = '-1';
            return $status_admin;
            //return json_encode(array('status_user'=>'false', 'status_admin'=>''));
        } 
    }

    function login_ujian($user_name,$password,$status_user){
        if($status_user=='guru'||$status_user=='admin'){           
            $query = $this->db->get_where('user_setup',array('rtrim(user_id)'=>$user_name,'rtrim(password)'=>$password));                        
            if($query->num_rows()>0){      
                foreach($rs as $d){               
                    $status_admin = $d->status_admin;
                }
                return $status_admin;
                // return json_encode(array('status_user'=>$satus_user, 'status_admin'=>$status_admin));
            }
        }

        if($status_user=='siswa'){
            //buat variable baru untuk password agar tidak tertimpa dengan passwrod yang ada di conn.php
            $password_temp = $password;
            include 'conn.php';
            
            $query = "
            select * from (
            select  ms.nis, ms.nis as password 
            from    master_siswa ms
            left join kelas_siswa ks
            on 	    ms.nis = ks.nis
            and     left(now(),10) between 	ks.tgl_mulai and ks.tgl_selesai 
            )q
            where   q.nis = '$user_name' 
            and     q.password = '$password_temp' 
            ";            
            
            $rs = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($rs);
            if($rows>0){
                return '2';
            }else{
                return '-1';
            }

        }
        
    }

    function cek_user($user_name){
        $query = $this->db->get_where('user_setup',array('rtrim(user_id)'=>$user_name));                        
        if($query->num_rows()>0){           
            $rs = $query->result();            
            foreach($rs as $d){               
                $status_admin = $d->status_admin;
            }
            return $status_admin;           
        }        
        
        $query = $this->db->get_where('user_setup_siswa',array('user_id'=>$user_name));
        if($query->num_rows()>0){                
            $status_admin = '2';
            return $status_admin;            
        }else{            
            $status_admin = '-1';
            return $status_admin;
        } 
    }

    function check_session_exists($user_name,$sid) {
        $query = $this->db->get_where('session',array('value'=>$user_name,'sid'=>$sid));
        if($query->num_rows()>0){
            return 1;
        }else{
            return 0;
        } 
    }

    function simpan_data_session_login($user_name, $session_exists, $sid) {
        include 'conn.php';        

        if($session_exists>0){
            $query = "
            update session set last_login = now() where value = '$user_name' and sid = '$sid' ";
        }else{
            $query = "
            insert into session (sid, value, last_login) values  ('$sid','$user_name', now()) ";
        }

        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            return $rows;
        }
       
        mysqli_close($conn);        
    }

    function simpan_data_status_user_login($user_name, $sid, $status_user) {
        include 'conn.php';        

        $query = "
        select * from status_user where user_id = '$user_name' and sid = '$sid'
        ";
        $rs_status = mysqli_query($conn, $query);
        $rows_num = mysqli_num_rows($rs_status);

        if($rows_num> 0){
            $query = "
            update status_user 
            set status = '$status_user', last_login = now() 
            where user_id = '$user_name' and sid = '$sid' ";
        }else{
            $query = "
            insert into status_user (sid, user_id, status, last_login) 
            values  ('$sid','$user_name', '$status_user', now()) ";
        }
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            return $rows;
        }  
    }

    function simpan_data_session_logout($user_name, $session_exists, $sid) {
        include 'conn.php';
       
        if($session_exists>0){
            $query = "
            update session set last_logout= now() where value = '$user_name' and sid = '$sid' ";  
            
            if (mysqli_query($conn, $query)) {
                $rows = mysqli_affected_rows($conn);                
                return $rows;
            }      
        }

        
       
        mysqli_close($conn);        
    }


    function query_tbl_daftar_user()
    {
        $query="SELECT 	user_name, 
						name,
						password,
						status_admin						
				FROM 	user_setup";
				
		return $this->db->query($query);	
    }

    
    function get_data_tbl_privilege() {
    
        //$query="SELECT * FROM user_menu";

        $query="SELECT um.group_id
                , um.menu_id
                , um.menu_desc
                , IFNULL(up.allow_access,'0') as allow_access
                , IFNULL(up.allow_update,'0') as allow_update
                , IFNULL(up.allow_access,'0') as allow_access_ori
                , IFNULL(up.allow_update,'0') as allow_update_ori
                , IFNULL(up.allow_access,'0') as allow_access_temp
                , IFNULL(up.allow_update,'0') as allow_update_temp              
        from user_menu as um
        left join user_privilege as up
        on  um.menu_id = up.menu_id
        and up.user_id = 'admin'";
       
        return $query;
        //return $this->db->query($query);	
      
    }

    function get_user_menu($user_status) {
        if($user_status=='admin'){
            $query = "
            select * from user_menu
            where status_user IN ('admin','guru')
            and     menu_id not in (3)
            order by group_indeks, menu_indeks";
        }else{
            $query = "
            select * from user_menu
            where status_user = '$user_status'
            and     menu_id not in (3)
            order by group_indeks, menu_indeks";
        }
        
        return $this->db->query($query);	
    }
    

}