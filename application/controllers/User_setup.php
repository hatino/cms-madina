<?php

class User_setup extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('mdl_user');
        check_session();
    }

    function show_user_setup()
	{		
        $this->template->load('template','user/frm_user_setup');        
	}

    function load_tbl_daftar_user()
    {
        echo "<table class='table table-bordered table-sticky table-striped table-sm '  id='table_daftar_user' >
        <thead class='col-form-label-sm bg-primary'>
        <tr >
            <th class='fixheader' style='min-width: 40px;'>No</th>
            <th style='min-width: 60px;'>User ID</th>
            <th style='min-width: 100px;'>Nama</th>                       
            <th style='min-width: 100px;'>Status Admin</th>                        
            <th colspan='2'></th></tr>
        </tr>
        </thead>";
        $no=1;
        $data=  $this->mdl_user->query_tbl_daftar_user()->result();
        foreach ($data as $d){
            echo "
                <tr id='dataku$d->user_name' class = 'col-form-label-sm'>                 
                <td >$no</td>
                <td style='min-width: 60px;'>$d->user_name</td>
                <td style='min-width: 100px;'>$d->name</td>               
                <td style='display:none'>$d->password</td>               
                <td>$d->status_admin</td>                               
                <td width='50'><a id='edit_user' data-id='$d->user_name'><span class='glyphicon glyphicon-edit text-success' style='margin-left: 10px; color:#FF0000; cursor:pointer' title='Edit'></span></a></td>
                <td width='50'><a id='hapus_user_setup' data-id='$d->user_name'><span class='glyphicon glyphicon-trash text-delete' style='margin-left: 10px; color:#FF0000; cursor:pointer' title='Hapus'></span></a></td>                
                </tr>";
            $no++;
        }
        echo"</table>";
    }

    function get_data_tbl_privilege() {

        include 'conn.php';   
        $query=$this->mdl_user->get_data_tbl_privilege(); 
        $query_run = mysqli_query($conn,$query);
        
        $group_id = array(); 
        $menu_name = array();
        while($row = mysqli_fetch_array($query_run)) {
                $group_id[] = $row[0]; // group_id
                $menu_name[] = $row[1]; //menu_id
        }
        $res = array($id,$name);
        echo json_encode($res);
        mysqli_close($conn);
            
    }

}

?>